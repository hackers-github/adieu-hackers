<?php
// HTML 태그 처리
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