<?php

declare(strict_types=1);

namespace App\Database;

use PDO;

final class Connection
{
    public function __construct(
        private readonly string $databasePath,
    ) {
    }

    public function getPdo(): PDO
    {
        $directory = dirname($this->databasePath);

        if (!is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $pdo = new PDO('sqlite:' . $this->databasePath);

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}