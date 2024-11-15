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

// 입력값 필터링 및 보안 처리
function sanitizeInput($data) 
{
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }

    $data = trim($data); // 앞뒤 공백 제거
    return $data;
}

// 로그인 여부 체크
function isLogin() {
    if(empty($_SESSION['hackers2024_member_id']) || empty($_SESSION['hackers2024_member_cp']) || empty($_SESSION['hackers2024_member_user_level'])) {
        return false;
    }

    return true;
}

// 관리자 여부 체크
function isAdmin() {
    if(empty($_SESSION['hackers2024_member_user_level']) || $_SESSION['hackers2024_member_user_level'] != '2') {
        return false;
    }

    return true;
}

// 로그인 여부 체크 후 아니면 로그인페이지로 리다이렉트
function checkLogin() {
    if(!isLogin()){
        header("Location: /login.php");
        exit;
    }
}

// 관리자 여부 체크 후 아니면 메인페이지로 리다이렉트
function checkAdmin() {
    if(!isAdmin()) {
        header("Location: /");
        exit;
    }
}

// 관리자 페이지 권한 체크
function checkAdminPageAuth() {
    checkLogin();
    checkAdmin();
}