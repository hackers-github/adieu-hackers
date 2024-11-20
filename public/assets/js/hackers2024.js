let isProcessing = false;
function ajax_request(data){
    const action = data.get('action');
    console.log(action);

    if(isProcessing){
        return;
    }

    isProcessing = true;
    $.ajax({
        url: '/?page=action',
        type: 'POST',
        data: data,
        processData: false,
        contentType: false,
        dataType: 'json',
        async: false,
        success: function(response){
            isProcessing = false;

            if(typeof response == 'string'){    
                response = JSON.parse(response);
            }

            if(response.message){
                alert(response.message);
            }

            if(response.result == 'success'){
                switch(action){
                    case 'login':
                        location.href = '/';
                        break;

                    case 'vote':
                        $('.alert_wrap').fadeOut();
                        $('.vote_pop').fadeOut();
                        $('.vote_confirm').fadeIn();

                        myVote.setVote(response.p_id, response.vote_type);
                        myVote.trophyBadgeList();
                        myVote.trophyBadge();
                        myVote.trophyBadgePop();

                        openPopConfirm(response.p_id, response.vote_type);
                        break;

                    default:
                        location.reload();
                        break;
                }
            }
        }, 
        error: function(xhr, status, error){
            isProcessing = false;   
            alert('오류가 발생했습니다.');
        }
    });
}

function login(){
    const formData = new FormData();
    formData.append('action', 'login');
    formData.append('user_mobile', $('[name=user_mobile]').val());
    formData.append('onoff', $('[name=onoff]').val());
    
    ajax_request(formData);
}

function vote(){
    const formData = new FormData();
    const p_id = $('#selected_participant input[name=selected_p_id]').val();
    const vote_type = $('.vote_bott input[name=trophy]:checked').val();

    if(!p_id || !vote_type){
        alert('투표 정보가 올바르지 않습니다.');
        closePop();
        $('.alert_wrap').fadeOut();
        return;
    }

    const p_id_arr = myVote.getPId();
    if(p_id_arr.includes(p_id)){
        alert('이미 투표하였습니다.');
        closePop();
        $('.alert_wrap').fadeOut();
        return;
    }

    const vote_type_arr = myVote.getVotedType();
    if(vote_type_arr.includes(vote_type)){
        alert('이미 사용한 트로피입니다.');
        closePop();
        $('.alert_wrap').fadeOut();
        return;
    }

    formData.append('action', 'vote');
    formData.append('p_id', p_id);
    formData.append('vote_type', vote_type);

    ajax_request(formData);
}

// 투표창 설정 시작/종료
function onoff(onoff){
    const formData = new FormData();
    formData.append('action', 'onoff');
    formData.append('onoff', onoff);

    ajax_request(formData);
}