<?php
include '../src/bootstrap.php';

$page = $_GET['page'] ?? 'home';

if(!in_array($page, $config['allowed_pages'])) {
    header('Location: /');
    exit;
}

include PAGES_PATH . "/{$page}.php";