<?php

declare(strict_types=1);

namespace App\Database;

use PDO;
use RuntimeException;

final class Migrator
{
    public function __construct(
        private readonly PDO $pdo,
        private readonly string $migrationsDirectory,
    ) {
    }

    public function migrate(): void
    {
        $this->createMigrationsTable();

        $files = glob($this->migrationsDirectory . '/*.sql');

        if ($files === false) {
            throw new RuntimeException('Unable to read migrations directory.');
        }

        sort($files);

        foreach ($files as $file) {
            $name = basename($file);

            if ($this->hasBeenApplied($name)) {
                continue;
            }

            $sql = file_get_contents($file);

            if ($sql === false) {
                throw new RuntimeException('Unable to read migration: ' . $name);
            }

            $this->pdo->exec($sql);

            $statement = $this->pdo->prepare(
                'INSERT INTO migrations (name, applied_at) VALUES (:name, :applied_at)'
            );

            $statement->execute([
                'name' => $name,
                'applied_at' => (new \DateTimeImmutable())->format('Y-m-d H:i:s'),
            ]);
        }
    }

    private function createMigrationsTable(): void
    {
        $this->pdo->exec(
            'CREATE TABLE IF NOT EXISTS migrations (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                name TEXT NOT NULL UNIQUE,
                applied_at TEXT NOT NULL
            )'
        );
    }

    private function hasBeenApplied(string $name): bool
    {
        $statement = $this->pdo->prepare(
            'SELECT COUNT(*) FROM migrations WHERE name = :name'
        );

        $statement->execute([
            'name' => $name,
        ]);

        return (int) $statement->fetchColumn() > 0;
    }
}