$(document).ready(function(){
    
    
    
    
    $('label.btn input[checked]').each(function(){
        $(this).parent().addClass('active');
    });
});

