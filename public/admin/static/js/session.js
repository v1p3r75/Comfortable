(function(){
    'use strict'

    const BASE_URL = 'http://comfortable.dev';
    let crud = function(){
        $('.send').click(function(e){
            e.preventDefault();
            let form = $(this).parents('form').get(0);
            let data = new FormData(form);
            let sendBtn = $(this).parent('.send-ctn').find('.send-wait');
            sendBtn.removeClass('d-none');
            let action = $(form).attr('action');
            console.log(data.get('image'));
            $.ajax({
                type: "POST",
                url: BASE_URL + action,
                enctype: 'multipart/form-data',
                data : data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json"

            }).always(function(response){
                console.log(response);
                if(response.status === 200) sweetAlert('Success',response.message,'success')
                else if(response.status === 201) window.location.href = '/admin'
                else toastr.error(response.message,'Error')
                sendBtn.addClass('d-none');
            })
        })
        return 0;
    }();

})();