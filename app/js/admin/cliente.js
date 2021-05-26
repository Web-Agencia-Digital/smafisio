$(function(){
    //baseUri
    $('head').append('<script src="js/default/baseuri.js" type="text/javascript"></script>');
    
    $('.money').mask('000.000.000.000.000,00', {reverse: true});
    $('.price').mask('000.000.000.000.000,00', {reverse: true});
    $('#item_desconto').mask('000.000.000.000.000,00', {reverse: true});
    $('#item_preco').mask('000.000.000.000.000,00', {reverse: true});
    
    //stupidtable
    $(".table").stupidtable();   
    //button submit
    $('#btn-add').on('click',function(){
        $('#f-item').submit();
    })
    //editar item
    $('.edit').on('click',function(){
        var id = $(this).attr('id');
        var cpf = $(this).data("cpf");
        if(cpf != ""){
            window.location = baseUri+'/admin/cliente/editar/'+id+'/';
        }else{window.location = baseUri+'/admin/cliente/editar_pjuridica/'+id+'/';}
    });


    //cancel
    $('.cancel').on('click',function(){
        $('#sub_categoria').val('');
        $('#collapseOne').collapse('hide'); 
        $('#add-categoria').find('b').html('Cadastrar Nova Subcategoria');
        $('#f-categoria').attr('action',$('#f-categoria').attr('action').replace('/atualizar/','/incluir/'));
        $('#btn-add').html('Cadastrar');
        $('#sub_title').val('');
        $('#add-categoria').find('.icon-edit').removeClass('icon-edit').addClass('icon-plus-sign');
        $('#sub_title').removeClass('invalid');
    })
    //remover item
    $('.remove').on('click',function(){
        var id = $(this).attr('id');
        $('#modal-remove').modal('show');
        var url = baseUri +'/admin/cliente/remover/'+id+'/';
        $('#btn-remove').attr('href',url);
    })      



});
