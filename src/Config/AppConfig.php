<?php

declare(strict_types=1);

namespace App\Config;

final class AppConfig
{
    public function __construct(
        private readonly string $databasePath,
    ) {
    }

    public function getDatabasePath(): string
    {
        return $this->databasePath;
    }

    public static function fromEnvironment(string $projectDirectory): self
    {
        $databasePath = $_ENV['DATABASE_PATH'] ?? 'var/database.sqlite';

        if (!str_starts_with($databasePath, '/')) {
            $databasePath = $projectDirectory . '/' . $databasePath;
        }

        return new self($databasePath);
    }
}