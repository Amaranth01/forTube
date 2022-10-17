<?php

use App\Routing;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../Routing.php';
require __DIR__ . '/../src/Model/DB.php';
require __DIR__ . '/../Config.php';

session_start();

Routing::route();