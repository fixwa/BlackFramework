<?php
set_include_path(
    get_include_path() .
    PATH_SEPARATOR . __DIR__ .
    PATH_SEPARATOR . __DIR__ . '/../Application/'
); // optional

include __DIR__ . '/../vendor/autoload.php';
//include __DIR__ . '/../vendor/form-manager/form-manager/FormManager/autoloader.php';

spl_autoload_register(function ($class) {
    $file = preg_replace('#\\\|_(?!.+\\\)#', '/', $class) . '.php';
    if (stream_resolve_include_path($file)) {
        require $file;
    } else {
        //echo "<P>Class: [{$class}] not found.</p>";
        //echo "<P>File: [{$file}] not found.</p>";
    }
});

//Helpers
