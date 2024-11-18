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