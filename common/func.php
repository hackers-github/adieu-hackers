<?php

function escapeHtmlData($data){
    if(empty($data)){
        return $data;
    }

    if(is_array($data)){
        return array_map('escapeHtmlData', $data);
    }

    return htmlspecialchars($data);
}

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
    if(empty($_SESSION['hackers2024_member_id']) || empty($_SESSION['hackers2024_member_cp']) || empty($_SESSION['hackers2024_member_user_level'])) {
        return false;
    }

    return true;
}

// ������ ���� üũ
function isAdmin() {
    if(empty($_SESSION['hackers2024_member_user_level']) || $_SESSION['hackers2024_member_user_level'] != '2') {
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
        header("Location: /");
        exit;
    }
}

// ������ ������ ���� üũ
function checkAdminPageAuth() {
    checkLogin();
    checkAdmin();
}