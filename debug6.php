<?php
$s = file_get_contents('app/Models/User.php');
$tokens = token_get_all($s);
echo 'tokens: ' . count($tokens) . PHP_EOL;
for ($i=0;$i<30 && $i<count($tokens);$i++){
    $t = $tokens[$i];
    if (is_array($t)) echo "$i: token={$t[0]} \t value='".str_replace("\n","\\n",$t[1])."'\n";
    else echo "$i: char='$t'\n";
}
