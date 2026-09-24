<?php

declare(strict_types=1);

use App\Config\AppConfig;
use App\Database\Connection;
use App\Database\Migrator;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$projectDirectory = dirname(__DIR__);

$dotenv = new Dotenv();
$dotenv->load($projectDirectory . '/.env');

$config = AppConfig::fromEnvironment($projectDirectory);

$connection = new Connection($config->getDatabasePath());
$pdo = $connection->getPdo();

$migrator = new Migrator(
    $pdo,
    $projectDirectory . '/database/migrations',
);

$migrator->migrate();

echo "Migrations applied successfully." . PHP_EOL;