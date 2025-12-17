<?php
$s = file_get_contents('app/Models/User.php');
echo substr(bin2hex($s),0,32) . PHP_EOL;
echo PHP_EOL;
echo substr($s,0,200) . PHP_EOL;