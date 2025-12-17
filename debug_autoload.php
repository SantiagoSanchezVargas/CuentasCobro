<?php
$loader = require __DIR__ . '/vendor/autoload.php';
var_dump(method_exists($loader, 'findFile'));
var_dump($loader->findFile('App\\Models\\User'));
var_dump(class_exists('App\\Models\\User'));
