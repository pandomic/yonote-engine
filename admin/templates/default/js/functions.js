$.fn.confirmModal = function(){
    var evalAction = $(this).attr('data-action');
    $('#confirm-modal').modal('show');
    $('#confirm-modal-button').off('click').on('click',function(){
        eval(evalAction);
    });
};

$.fn.autoCheck = function(){
    var closest = $(this).closest('table');
    //$('tr td :checkbox',closest).slideToggle();
    $('tr td :checkbox',closest).prop('checked',this.is(':checked'));
    $('td',closest).parent().toggleClass("info",this.is(':checked'));
}

$.fn.uploadFile = function(params){
    
    /**
     * params.progressContainer
     * params.progressBar
     * params.errorBlock
     * params.successBlock
     * params.disableObjects
     * params.fileObjects
     * params.ajaxParam
     * params.reload
     * params.successContainer
     * params.errorContainer
     */
    
    var useProgress = false;
    
    params.successContainer = $(params.successContainer);
    params.errorContainer = $(params.errorContainer);
    
    params.successContainer.hide();
    params.errorContainer.hide();
    
    if (params.progressContainer !== null){
        params.progressBar = $(params.progressBar);
        params.progressContainer = $(params.progressContainer);

        params.progressContainer.hide();
        useProgress = true;
    }

    $(this).on('submit',function(event){
        
        event.stopPropagation();
        event.preventDefault();

        var data = new FormData($(this)[0]);
        var action = $(this).attr('action');
        
        if (useProgress){
            params.progressContainer.slideDown(200);
            params.progressBar.css('width','0%');
        }
        
        params.successContainer.hide();
        params.errorContainer.hide();
        
        data.append('ajax',params.ajaxParam);
        
        function toggleDisabled(objects,disable){
            if (objects !== null){
                var len = objects.length;
                for (var i = 0; i < len; i++){
                    if (disable)
                        $(objects[i]).attr('disabled','true');
                    else
                        $(objects[i]).removeAttr('disabled');
                }
            }
        }
        
        toggleDisabled(params.disableObjects,true);
        
        var xhr = new XMLHttpRequest();
        
        xhr.open('POST',action,true);
        xhr.onload = function(e){
            if(xhr.status === 200){
                var json = $.parseJSON(xhr.responseText);
                if (json instanceof Array && json.length === 0){
                    if (params.reload)
                        window.setTimeout(function(){
                            window.location.reload();
                        },2000);
                    params.successContainer.slideDown();
                    params.successContainer.html(json.success);
                } else {
                    for (var item in json){
                        params.errorContainer.slideDown();
                        params.errorContainer.html(json[item][0]);
                        break;
                    }
                }
            } else {
                console.log('Ajax response error');
            }
            params.progressContainer.delay(1000).slideUp(200,function(){
                toggleDisabled(params.disableObjects);
                params.progressBar.css('width','0%');
            });
        };
        xhr.upload.onprogress = function(e) {
            if (e.lengthComputable){
                if (useProgress)
                    params.progressBar.css('width',((e.loaded / e.total) * 100) + '%');
            }
        };
        xhr.send(data);
        
        /*$.ajax({
            url: action,
            type: 'POST',
            data: data,
            cache: false,
            dataType: 'json',
            processData: false,
            contentType: false,
            complete: function(){
                if (useProgress){
                    params.progressBar.stop(true).animate({'width':'100%'},1000,'swing',function(){
                        window.setTimeout(function(){
                            params.progressContainer.addClass('hide');
                            toggleDisabled(params.disableObjects);
                        },1000);
                    });
                }
            },
            success: function(){
                toggleDisabled(params.disableObjects);
                //window.location.reload();
                //alert('success');
            },
            error: function(jqXHR,textStatus,error){
                    alert(jqXHR.responseText);
                    toggleDisabled(params.disableObjects);
                //alert('error');
            }
        });*/
        
    });
}