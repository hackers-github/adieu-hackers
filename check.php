<?php
include $_SERVER['DOCUMENT_ROOT'] . '/common.php';

$db->connect();
$db_slave->connect();

var_dump($db->getDb());
echo '<br><br>';
var_dump($db_slave->getDb());
?>