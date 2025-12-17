<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

$user = User::where('email', 'daniel00250@hotmail.com')->first();
if (!$user) {
    echo "MISSING\n";
    exit(0);
}

echo (Hash::check('cosita1225*', $user->password) ? "MATCH\n" : "NO_MATCH\n");
