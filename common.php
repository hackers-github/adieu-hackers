<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/common/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/func.php';

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

// �¿��� �ڵ�
define('ONOFF_CODE', '036002');