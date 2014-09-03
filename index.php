<?php

if (isset($_COOKIE['development'])) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
}

require 'Black/Autoloader.php';

$app = new Black\Application();
$app->init();
