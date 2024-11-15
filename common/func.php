<?php

// �Է°� ���͸� �� ���� ó��
function sanitizeInput($data) 
{
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }

    $data = trim($data); // �յ� ���� ����
    return $data;
}

// �α��� ���� üũ
function isLogin() {
    if(empty($_SESSION['hackers2024_member_id']) || empty($_SESSION['hackers2024_member_cp'])) {
        return false;
    }

    return true;
}

// ������ ���� üũ
function isAdmin() {
    if(empty($_SESSION['hackers2024_is_admin']) || $_SESSION['hackers2024_is_admin'] != 'Y') {
        return false;
    }

    return true;
}

// �α��� ���� üũ �� �ƴϸ� �α����������� �����̷�Ʈ
function checkLogin() {
    if(!isLogin()){
        header("Location: /login.php");
        exit;
    }
}

// ������ ���� üũ �� �ƴϸ� ������������ �����̷�Ʈ
function checkAdmin() {
    if(!isAdmin()) {
        header("Location: /dev/landing/hackers2024");
        exit;
    }
}

// ������ ������ ���� üũ
function checkAdminPageAuth() {
    checkLogin();
    checkAdmin();
}