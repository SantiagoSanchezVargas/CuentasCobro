<?php
$before = get_declared_classes();
require __DIR__ . '/app/Models/User.php';
after:;
$after = get_declared_classes();
$diff = array_diff($after, $before);
var_dump(in_array('App\\Models\\User', $after));
var_dump($diff);
