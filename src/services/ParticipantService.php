<?php

namespace src\services;

use src\models\ParticipantModel;

class ParticipantService
{
    private $participantModel;

    public function __construct()
    {
        $this->participantModel = new ParticipantModel();
    }

    // 참가자 조회
    public function getParticipantList() {
        return $this->participantModel->selectParticipantList();
    }
}