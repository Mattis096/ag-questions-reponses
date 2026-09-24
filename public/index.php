<?php

declare(strict_types=1);

use App\Application;
use Symfony\Component\Dotenv\Dotenv;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$dotenv = new Dotenv();
$dotenv->load(dirname(__DIR__) . '/.env');

$app = new Application();
$app->run();