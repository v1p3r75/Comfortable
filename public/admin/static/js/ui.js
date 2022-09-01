(function(){
    'use strict'

    let initPrimitive = function(){
        $('.ui-action').each((i,e) => {
            $(e).click(function(){
                if($(e).data('display-target')){
                    let target = '.' + $(e).data('display-target') || '#' + $(e).data('display-target');
                    $('.drop').removeClass('d-none').show();
                    $(target).removeClass('d-none').fadeIn(1000);
                }
                if($(e).data('display-target-update')){
                    let target = $('.' + $(e).data('display-target-update')) || $('#' + $(e).data('display-target-update'));
                    $('.drop').removeClass('d-none').show();
                    $(target).removeClass('d-none').fadeIn(1000)
                    let fieldinfo = $(e).parents('tr').data('cf-data');
                    $(target).find('input').each(function (i,e){
                        for (let column of Object.entries(fieldinfo)){
                            if($(e).attr('name') == column[0]){
                                $(e).attr('value', column[1]);
                            }
                        }
                    })

                }
                if($(e).data('close-target')){
                    let target = $('.' + $(e).data('close-target')) || $('#' + $(e).data('close-target'));
                    $(target).fadeOut(1000);
                }
                if($(e).data('toggle-target')){
                    let target = $('.' + $(e).data('toggle-target')) || $('#' + $(e).data('toggle-target'));
                    $(target).toggle('slow')
                }
            })
        })
        $('.model-name').attr('value', window.location.hash.slice(12));

    }();

    let model = function(){
        $('.ui-model').each((i,e) => {
            $(e.querySelectorAll('.close-model')).each(function (el){
                $(this).click(function(){
                    $('.drop').hide() && $(e).fadeOut(400)
                    cfRefresh ? window.location.reload() : null
                })
            })
        })
    }();

    let crud = function(){
        $('.send').click(function(e){
            e.preventDefault();
            let data = new FormData($(this).parents('form').get(0));
            let type = $(this).data('cf-action-type');
            let delId = sessionStorage.getItem('cf_del_id');
            let UpId = sessionStorage.getItem('cf_up_id');
            data.append('type', type);
            let idName = $('.cf-xxx-primaryKey').attr('value');
            type === 'del' ? data.append('cf-xxx-id', delId) : null;
            type === 'update' ? data.append('cf-xxx-id', UpId) : null;
            let sendBtn = $(this).parent('.send-ctn').find('.send-wait');
            sendBtn.removeClass('d-none');
            $.ajax({
                type: "POST",
                url: settings.API_BASEURL + 'crud',
                enctype: 'multipart/form-data',
                data : data,
                processData: false,
                contentType: false,
                cache: false,
                dataType: "json"

            }).always(function(response){
                // console.log(response);
                response.status === 200 ?
                    sweetAlert('Success',response.message,'success') && (cfRefresh = true) :
                    toastr.error(response.message,'Error');
                sendBtn.addClass('d-none');
            })
        })
        cfRefresh = false;
        return 0;
    }();

    $('.loadPage').each((i,e) =>{
        $(e).click(function() {
            let page = $(this).data(settings.LOADVIEW_ATTRIBUTES);
            if(window.location.hash == '#' + page){
                return false;
            }
            $(settings.PAGE_CONTAINER).html(settings.LOADING_TEMPLATE);
            window.location.hash = page;
        })
    });
    $('.action').each(function(i,e){
        $(e).click(function(ev){
            let primaryKey = $('.cf-xxx-primaryKey').attr('value');
            let id = $(this).parents('tr').data('cf-data')[primaryKey];
            let type = $(this).data('cf-action-type');
            if(type === 'del'){
                sessionStorage.setItem('cf_del_id', id);
            }else if(type === 'update') {
                sessionStorage.setItem('cf_up_id', id);
            }
        });
    });
    $('.m-name').text(window.location.hash.slice(12));

})();