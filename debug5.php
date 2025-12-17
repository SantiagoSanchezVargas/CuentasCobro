<?php
$s = file_get_contents('app/Models/User.php');
$tokens = token_get_all($s);
foreach ($tokens as $t) {
    if (is_array($t)) {
        if ($t[0] === T_NAMESPACE) echo "FOUND_NAMESPACE\n";
        if ($t[0] === T_CLASS) echo "FOUND_CLASS\n";
        if ($t[0] === T_STRING && $t[1] === 'User') echo "FOUND_STRING_USER\n";
    }
}
