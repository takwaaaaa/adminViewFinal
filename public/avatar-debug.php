<?php
// Temporary debug file — place at: public/avatar-debug.php
// Visit: http://adminview.test/avatar-debug.php
// DELETE THIS FILE after debugging!

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$user = \App\Models\User::first();

echo "<pre>";
echo "name: " . $user->name . "\n";
echo "avatar field in DB: " . ($user->avatar ?? 'NULL') . "\n";
echo "\n";

if ($user->avatar) {
    $fullPath = storage_path('app/public/' . $user->avatar);
    echo "full disk path: " . $fullPath . "\n";
    echo "file exists on disk: " . (file_exists($fullPath) ? 'YES ✅' : 'NO ❌') . "\n";
    echo "asset() URL: " . asset('storage/' . $user->avatar) . "\n";
} else {
    echo "No avatar saved in DB — will use initials fallback\n";
}

echo "\n";
echo "avatar_url accessor returns:\n";
echo $user->avatar_url . "\n";
echo "\n";

// Check symlink
$symlinkPath = public_path('storage');
echo "public/storage symlink exists: " . (file_exists($symlinkPath) ? 'YES ✅' : 'NO ❌') . "\n";
echo "public/storage is symlink: " . (is_link($symlinkPath) ? 'YES ✅' : 'NO ❌') . "\n";

// List files in storage/app/public/avatars if it exists
$avatarsDir = storage_path('app/public/avatars');
echo "\nstorage/app/public/avatars exists: " . (is_dir($avatarsDir) ? 'YES ✅' : 'NO ❌') . "\n";
if (is_dir($avatarsDir)) {
    $files = scandir($avatarsDir);
    echo "files in avatars folder:\n";
    foreach ($files as $f) {
        if ($f !== '.' && $f !== '..') echo "  - $f\n";
    }
}
echo "</pre>";