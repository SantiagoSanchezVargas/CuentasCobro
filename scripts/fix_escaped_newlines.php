<?php
$dir = __DIR__ . '/../app';
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$files = [];
foreach ($it as $f) {
    if ($f->isFile() && str_ends_with($f->getFilename(), '.php')) {
        $content = file_get_contents($f->getPathname());
        if (strpos($content, "\\n") !== false) {
            $files[] = $f->getPathname();
        }
    }
}

foreach ($files as $file) {
    echo "Fixing: $file\n";
    $content = file_get_contents($file);
    // Replace literal backslash-n sequences with real newlines
    $new = str_replace('\\n', PHP_EOL, $content);
    // Replace literal backslash-t with real tabs
    $new = str_replace('\\t', "\t", $new);
    // Normalize line endings to LF
    $new = str_replace(["\r\n", "\r"], "\n", $new);
    file_put_contents($file, $new);
}

echo "Done.\n";
