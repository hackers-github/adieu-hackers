<?php

namespace src\services;

use src\models\VoteModel;

class VoteService
{
    private $voteModel;

    public function __construct()
    {
        $this->voteModel = new VoteModel();
    }

    // 참가자 조회
    public function getVoteListByMemberId($member_id) {
        if(!$member_id){
            return [];
        }
        return $this->voteModel->selectListByMemberId($member_id);
    }

    // 투표
    public function vote($data) {
        if(!validate_data(['member_id' => $data['member_id'], 'p_id' => $data['p_id'], 'vote_type' => $data['vote_type']])){
            return ['result' => 'fail', 'message' => '데이터가 올바르지 않습니다.'];
        }

        $insertResult = $this->voteModel->insertData([
            'member_id' => $data['member_id'],
            'p_id' => $data['p_id'],
            'vote_type' => $data['vote_type']
        ]);

        if($insertResult['insertId']){
            return ['result' => 'success', 'message' => '투표가 완료되었습니다.'];
        }else{
            return ['result' => 'fail', 'message' => '투표에 실패하였습니다.'];
        }
    }
}