<?php

use \src\services\S3Service;
use \src\services\OnOffService;
use \src\services\MemberService;

if(empty($_POST['action'])){
    echo jsonEncode(['result' => 'fail', 'message' => '잘못된 접근입니다.']);
    exit;
}

$action = $_POST['action'];

switch($action){
    case 'login' :
        $user_mobile = $_POST['user_mobile'];
        $onOff = $_POST['onoff'];

        $memberService = new MemberService();
        $onOffService = new OnOffService();

        // 로그인
        $loginResult = $memberService->login(['user_mobile' => $user_mobile]);
        $onOff = $onOffService->getOnOff();

        // 로그인 성공 시 투표 종료 체크
        if($loginResult['result'] == 'success'){
            // 투표 종료 체크
            $onOffResult = $onOffService->checkOnOff($onOff);
            // 투표 종료 시 종료 메시지 반환
            if($onOffResult['result'] == 'fail'){
                echo jsonEncode($onOffResult);
                exit;
            }
        }

        // 로그인 결과 반환
        echo jsonEncode($loginResult);
        exit;
}
?>
