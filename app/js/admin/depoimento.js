$(function () {
    //baseUri
    $('head').append('<script src="js/default/baseuri.js" type="text/javascript"></script>');
    //stupidtable
    if ($(".table").length >= 1) {
        $(".table").stupidtable();
    }
    //editar
    $('.edit').live('click', function () {
        var id = $(this).attr('id');
        window.location = baseUri + '/admin/depoimento/editar/' + id + '/';
    })
    //cancel
    $('.cancel').live('click', function () {
        window.location = baseUri + '/admin/depoimento/';
    })
    //remove
    $('.remove').live('click', function () {
        var id = $(this).attr('id');
        $('#modal-remove').modal('show');
        var url = baseUri + '/admin/depoimento/remover/' + id + '/';
        $('#btn-remove').attr('href', url);
    })
})

function validaAdd()
{

}

