$(document).ready(function(){
    // Remove modals after show
    $('body').on('hidden.bs.modal','.modal',function(){
        $(this).removeData('bs.modal');
    });
    // Higlight checked rows
    $(":checkbox").change(function() {
        $(this).closest("td").parent().toggleClass("info",this.checked);
    });
    // Remove hidden pagination elements
    $('.pagination .hidden').remove();
});