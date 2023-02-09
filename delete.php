<?php
function removeDirectory($path)
{

    $files = glob($path . '/*');
    foreach ($files as $file) {
        print_r('test');
        print_r($file);
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
    print_r($files);
    return;
}
removeDirectory('frontend');
print_r('test');
?>