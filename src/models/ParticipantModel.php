<?php

namespace src\models;

use src\models\BaseModel;

class ParticipantModel extends BaseModel
{
    public function selectParticipantList() {
        $qry = "SELECT p_id, team_name, title, image_url, image_org_name FROM event_hackers_participant";
        $this->db_slave->prepare($qry);
        $result = $this->db_slave->stmt_execute('all');
        return $result;
    }
}