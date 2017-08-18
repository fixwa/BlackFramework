<?php
require_once __DIR__ . '/vendor/autoload.php';

if (isset($_COOKIE['development'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
}

$app = new Black\Application();
$app->init();
