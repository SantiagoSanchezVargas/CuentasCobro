<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__.'/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\User;

$user = User::where('email','daniel00250@hotmail.com')->first();
if (!$user) { echo "MISSING\n"; exit(0); }

echo json_encode([
    'id' => $user->id,
    'email' => $user->email,
    'role_id' => $user->role_id,
    'email_verified_at' => $user->email_verified_at?->toDateTimeString(),
]);
