$(function(){
    //baseUri
    $('head').append('<script src="js/default/baseuri.js" type="text/javascript"></script>');
    //stupidtable
    $(".table").stupidtable();
    $('.edit').live('click',function(){
        var id = $(this).attr('id');
        var title = $(this).attr('name');
        var title = $(this).attr('email');
        $('#collapseOne').collapse('show');
        $('#news_nome').val(title);
        $('#news_email').val(title);
        $('#n-news').attr('action',$('#n-news').attr('action').replace('/incluir/','/atualizar/'+id+'/'));
        $('#news_nome').removeClass('invalid');
        $('#news_email').removeClass('invalid');
        $('#news_nome').focus();
    })
    
    //cancel
    $('.cancel').live('click',function(){
        $('#collapseOne').collapse('hide'); 
        $('#news_nome').val('');
        $('#news_email').val('');
        $('#news_nome').removeClass('invalid');
        $('#news_email').removeClass('invalid');
    })
    //remove
    $('.remove').live('click',function(){
        var id = $(this).attr('id');
        $('#modal-remove').modal('show');
        var url = baseUri +'/admin/news/remover/'+id+'/';
        $('#btn-remove').attr('href',url);
    })        
    //remove
    $('.removeattr').live('click',function(){
        var id = $(this).attr('id');
        var at = $(this).attr('at');
        $('#modal-remove').modal('show');
        var url = baseUri +'/admin/news/removeritem/'+id+'/'+at+'/';
        $('#btn-remove').attr('href',url);
    })        
})
function valida()
{
    if($.trim($('#news_nome').val()) == "")
    {
        $('#news_nome').addClass('invalid');
        $('#news_nome').focus();
        //$('#news_nome').popover({placement:'top',title:'Campo Requerido',html: true, content:'Voc� precisa selecionar uma Atributo!'});
        return false;
    }
    else
    {
        $('#news_nome').removeClass('invalid');
        return true;
    }
}
function validaItem()
{
    if($.trim($('#iattr_nome').val()) == "")
    {
        $('#iattr_nome').addClass('invalid');
        $('#iattr_nome').focus();
        //$('#news_nome').popover({placement:'top',title:'Campo Requerido',html: true, content:'Voc� precisa selecionar uma Atributo!'});
        return false;
    }
    else
    {
        $('#iattr_nome').removeClass('invalid');
        return true;
    }
}

