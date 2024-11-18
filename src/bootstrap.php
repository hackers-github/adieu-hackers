<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

session_start();

use src\core\DB;

// 기본 경로
define('BASE_PATH', dirname(__DIR__));
define('ASSETS_PATH', BASE_PATH . '/assets');
define('SRC_PATH', BASE_PATH . '/src');
define('CONFIG_PATH', SRC_PATH . '/config');
define('HELPERS_PATH', SRC_PATH . '/helpers');
define('PAGES_PATH', SRC_PATH . '/pages');
define('CORE_PATH', SRC_PATH . '/core');
define('IS_DEV', ($_SERVER['HTTP_HOST'] == 'tdevadieu2024.hackers.com'));

// 설정 파일
include CONFIG_PATH . '/config.php';

// 헬퍼 함수
include HELPERS_PATH . '/filter.php';
include HELPERS_PATH . '/auth.php';

// 클래스 자동 로드
spl_autoload_register(function ($className) {
    $className = str_replace('\\', '/', $className);

    $dirs = [
        BASE_PATH . '/',
    ];

    foreach ($dirs as $dir) {
        $classPath = $dir . $className . '.php';

        if(file_exists($classPath)) {
            require_once $classPath;
            return;
        }
    }
});