<?php

namespace src\models;

use src\models\BaseModel;

class OnOffModel extends BaseModel
{
    public function getOnOff()
    {
        $qry = "SELECT onoff FROM event_hackers_onoff";
        $this->db_slave->prepare($qry);
        $result = $this->db_slave->stmt_execute('row');

        return $result;
    }
}