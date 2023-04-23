$(document).click(function() {
    $(".close").click(function(){
        $('.modal').removeClass('show');
        $('.modal-dialog').removeClass('show');
    });  
    $("#close").click(function(){
        $('.modal').removeClass('show');
        $('.modal-dialog').removeClass('show');
    });  
 });

function boton1(){
    $('.modal').addClass('show');
    $('.modal-dialog').addClass('show');
    $('#confirm-delete').on('show.bs.modal', function(e){
        $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        $('.debug-url').html('Delete URL: <strong>' + $(this).find('.btn-ok').attr('href')+ '</strong>');
        });
}