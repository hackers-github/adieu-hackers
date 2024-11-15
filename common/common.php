<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

session_start();

include $_SERVER['DOCUMENT_ROOT'] . '/common/autoload.php';
include $_SERVER['DOCUMENT_ROOT'] . '/common/func.php';

use \classes\DB;

// ȣ��Ʈ üũ
if($_SERVER['HTTP_HOST'] == 'tdevadieu2024.hackers.com'){
    $db = new DB('hacademia');
    $db_slave = new DB('hacademia');
} else {
    $db = new DB('master');
    $db_slave = new DB('slave');
}

// GET ��û ó��
if (!empty($_GET)) {
    $_GET = sanitizeInput($_GET);
}

// POST ��û ó��
if (!empty($_POST)) {
    $_POST = sanitizeInput($_POST);
}

// ���� ó��
if(!empty($_FILES)){
    $_FILES = sanitizeInput($_FILES);
}

// ���ε� ���
define('UPLOAD_PATH', 'images/event/hackers2024');