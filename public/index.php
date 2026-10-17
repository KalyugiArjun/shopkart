<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Auto-initialize environment and sqlite database if missing on cloud platforms (e.g. Render)
$baseDir = dirname(__DIR__);
if (!file_exists($baseDir . '/.env') && file_exists($baseDir . '/.env.example')) {
    @copy($baseDir . '/.env.example', $baseDir . '/.env');
}

$dbDir = $baseDir . '/database';
if (!is_dir($dbDir)) {
    @mkdir($dbDir, 0777, true);
}
$sqliteFile = $dbDir . '/database.sqlite';
if (!file_exists($sqliteFile)) {
    @touch($sqliteFile);
    @chmod($sqliteFile, 0777);
}

$storageDirs = [
    $baseDir . '/storage/framework/views',
    $baseDir . '/storage/framework/sessions',
    $baseDir . '/storage/framework/cache',
    $baseDir . '/storage/logs',
    $baseDir . '/bootstrap/cache',
];
foreach ($storageDirs as $dir) {
    if (!is_dir($dir)) {
        @mkdir($dir, 0777, true);
    }
}

// Determine if the application is in maintenance mode...
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register the Composer autoloader...
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel and handle the request...
/** @var Application $app */
$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
