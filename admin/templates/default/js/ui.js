$(document).ready(function(){
    
    $('body').on('hidden.bs.modal','.modal',function(){
        $(this).removeData('bs.modal');
    });
    
    $(":checkbox").change(function() {
        $(this).closest("td").parent().toggleClass("info",this.checked);
    });
    
    $('.pagination .hidden').remove();
});