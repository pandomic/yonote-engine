$.fn.confirmModal = function(){
    var evalAction = $(this).attr('data-action');
    $('#confirm-modal').modal('show');
    $('#confirm-modal-button').off('click').on('click',function(){
        eval(evalAction);
    });
};

$.fn.autoCheck = function(){
    var closest = $(this).closest('table');
    $('tr td :checkbox',closest).prop('checked',this.is(':checked'));
    $('td',closest).parent().toggleClass("info",this.is(':checked'));
}