<?php
error_reporting(E_ALL & ~E_NOTICE);
ini_set("display_errors", 1);

session_start();

require_once $_SERVER['DOCUMENT_ROOT'] . '/common/DB.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/common/func.php';

// 龋胶飘 眉农
if($_SERVER['HTTP_HOST'] == 'tdevadieu2024.hackers.com'){
    $db = new DB('hacademia');
    $db_slave = new DB('hacademia');
} else {
    $db = new DB('master');
    $db_slave = new DB('slave');
}

// GET 夸没 贸府
if (!empty($_GET)) {
    $_GET = sanitizeInput($_GET);
}

// POST 夸没 贸府
if (!empty($_POST)) {
    $_POST = sanitizeInput($_POST);
}

// 颇老 贸府
if(!empty($_FILES)){
    $_FILES = sanitizeInput($_FILES);
}

// 柯坷橇 内靛
define('ONOFF_CODE', '036002');