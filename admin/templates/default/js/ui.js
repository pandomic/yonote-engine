$(document).ready(function(){
    
    
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

