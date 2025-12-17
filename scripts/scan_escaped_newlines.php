<?php
$dir = __DIR__ . '/../';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
$files = [];
foreach ($iterator as $file) {
    if ($file->isFile() && str_ends_with($file->getFilename(), '.php')) {
        $content = file_get_contents($file->getPathname());
        if (strpos($content, "\\n") !== false) {
            $files[] = $file->getPathname();
        }
    }
}
foreach ($files as $f) echo $f . "\n";
