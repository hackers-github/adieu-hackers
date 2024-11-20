<?php
include '../../src/bootstrap.php';

$page = $_GET['page'] ?? 'home';

if(!in_array($page, $config['admin_allowed_pages'])) {
    header('Location: /');
    exit;
}

include PAGES_PATH . "/admin/{$page}.php";