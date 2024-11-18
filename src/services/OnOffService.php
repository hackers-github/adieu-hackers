<?php

namespace src\services;

use src\models\OnOffModel;

class OnOffService
{
    private $onOffModel;

    public function __construct()
    {
        $this->onOffModel = new OnOffModel();
    }

    // 관리자 투표 종료 체크
    public function checkOnOff($onOff) {
        if($onOff == '2' && $_SESSION['hackers2024_member_user_level'] == '1'){
            session_unset();
            session_destroy();
            return ['result' => 'fail', 'message' => '종료된 투표입니다.'];
        } else {
            return ['result' => 'success', 'message' => '투표 진행중입니다.'];
        }
    }

    public function getOnOff()
    {
        $result = $this->onOffModel->getOnOff();
        return $result['onoff'];
    }

    public function updateOnOff($onoff)
    {
        return $this->onOffModel->updateOnOff($onoff);
    }
}