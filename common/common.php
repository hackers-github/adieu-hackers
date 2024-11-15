<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/common/autoload.php';
include $_SERVER['DOCUMENT_ROOT'] . '/common/func.php';

use \classes\DB;

// 호스트 체크
if($_SERVER['HTTP_HOST'] == 'tdevadieu2024.hackers.com'){
    $db = new DB('hacademia');
    $db_slave = new DB('hacademia');
} else {
    $db = new DB('master');
    $db_slave = new DB('slave');
}

// GET 요청 처리
if (!empty($_GET)) {
    $_GET = sanitizeInput($_GET);
}

// POST 요청 처리
if (!empty($_POST)) {
    $_POST = sanitizeInput($_POST);
}

// 파일 처리
if(!empty($_FILES)){
    $_FILES = sanitizeInput($_FILES);
}

// 업로드 경로
define('UPLOAD_PATH', 'images/event/hackers2024');