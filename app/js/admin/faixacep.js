$(function(){
    //baseUri
    $('head').append('<script src="js/default/baseuri.js" type="text/javascript"></script>');
    $('.price').mask('000.000.000.000.000,00', {reverse: true});
    $('#btn-add').live('click',function(){
        $('#f-item').submit();
    });
    //remover item
    $('.remove').live('click',function(e){
        e.preventDefault();
        var id = $(this).attr('id');
        $('#modal-remove').modal('show');
        var url = baseUri +'/admin/faixacep/remover/'+id+'/';
        $('#btn-remove').attr('href',url);
    });
});
