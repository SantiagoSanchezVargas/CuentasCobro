<?php
require __DIR__ . '/vendor/autoload.php';
var_dump(class_exists('App\\Models\\User'));
require __DIR__ . '/app/Models/User.php';
var_dump(class_exists('App\\Models\\User'));
