$(document).ready(function(){
    
    $('body').on('hidden.bs.modal','.modal',function(){
        $(this).removeData('bs.modal');
    });
    
    $('form').each(function(){
        var form = $(this);
        $(this).find('*[type="reset"]').click(function(){
            form.find('.btn').removeClass('active');
        });
    });
    
    $('label.btn input[checked]').each(function(){
        $(this).parent().addClass('active');
    });
});

