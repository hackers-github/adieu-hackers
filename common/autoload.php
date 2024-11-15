<?php
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);

    $dirs = [
        $_SERVER['DOCUMENT_ROOT'] . '/common/',
    ];

    foreach ($dirs as $dir) {
        $classPath = $dir . $className . '.php';
        
        if(file_exists($classPath)) {
            require_once $classPath;
            return;
        }
    }
});