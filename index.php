<?php
require __DIR__ . '/vendor/autoload.php';

use Slim\Factory\AppFactory;

$app = AppFactory::create();

$routes = require __DIR__ . '/routes/students.php';
$routes = require __DIR__ . '/routes/grades.php';
$routes($app);

$app->run();
