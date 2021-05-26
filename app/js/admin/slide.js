$(function(){
    //baseUri
    $('head').append('<script src="js/default/baseuri.js" type="text/javascript"></script>');
    //editar
    $('.edit').live('click',function(){
        var id = $(this).attr('id');
        var url = baseUri +'/admin/slideshow/editar/'+id+'/';
        window.location = url;
    })
    //remove
    $('.remove').live('click',function(){
        var id = $(this).attr('id');
        $('#modal-remove').modal('show');
        var url = baseUri +'/admin/slideshow/remover/'+id+'/';
        $('#btn-remove').attr('href',url);
    })      
    //local do slide
    $("#slide_local").live('change',function(){
        if($(this).val() == 2 || $(this).val() == 3){
            $('.for-slide-top').hide();
        }else{
            $('.for-slide-top').show();
        }
    })


    $('.slide-pos').on('change',function () {
        var pos = $(this).val();
        var id = $(this).data('id');
        var url = baseUri +'/admin/slideshow/pos/';
        $.post(url,{pos:pos,id:id},function (rs) {
            notify('<h1>Procedimento realizado com sucesso</h1>');
        })
    })

})

function valida(){
    if($('#page_area option:selected').val() == ""){
        $('#page_area').addClass('invalid');
        $('#page_area').focus();
        return false;        
    }
    else{
        $('#page_area').removeClass('invalid');
    }
}

