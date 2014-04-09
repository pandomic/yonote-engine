$.fn.confirmModal = function (){
    var evalAction = $(this).attr('data-action');
    $('#confirm-modal').modal('show');
    $('#confirm-modal-button').off('click').on('click',function(){
        eval(evalAction);
    });
};