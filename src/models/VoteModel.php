<?php

namespace src\models;

use src\models\BaseModel;

class VoteModel extends BaseModel
{
    public function selectListByMemberId($member_id) {
        $qry = "SELECT p_id, vote_type FROM event_hackers_vote WHERE member_id = ?";
        $this->db_slave->prepare($qry);
        $this->db_slave->stmt_bind_param("i", $member_id);
        $votes = $this->db_slave->stmt_execute('all');
        return $votes;
    }

    public function insertData($data) {
        $qry = "INSERT INTO event_hackers_vote (member_id, p_id, vote_type) VALUES (?, ?, ?)";
        $this->db->prepare($qry);
        $this->db->stmt_bind_param("iii", [$data['member_id'], $data['p_id'], $data['vote_type']]);
        return $this->db->stmt_execute('insert');
    }
}