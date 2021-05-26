var baseUri = $('base').attr('href').replace('/app/', '');
$(function () {
    var total_frete = 0;
    $('#frete_cep').mask('99999-999');
    $('#endTab').tab();
    $('#endTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
    //adiciona +1 no carrinho
    $('.cart-add').on('click', function () {
        var id = $(this).attr('name');
        var elm = id + ' .input_qtde';
        var lim = parseInt($('#qtde_' + id).data('estoque'));
        var curr = parseInt($('#' + id + ' .qtde').val()) ;
        var restante = parseInt(lim - curr);
        if (restante >= 1) {
            if (restante <= 7 && restante > 1) {
                if (restante > 1) {
                    var msg = 'Restam apenas ' + restante + ' itens em nosso estoque!';
                } else {
                    var msg = 'Resta apenas ' + restante + ' item em nosso estoque!';
                }
                addPop(elm, 'Limite no Estoque', msg, 'top');
            }
            if (restante <= 0) {
                addPop(elm, 'Limite no Estoque', 'Seu pedido atingiu o número máximo deste item em nosso estoque!', 'top');
                return false;
            } else {
                var url = baseUri + '/carrinho/incrementa/' + id + '/';
                $.post(url, {}, function (data) {
                    data = $.parseJSON(data);
                    $('#' + id + ' .qtde').val(data.qtde);
                    $('#' + id + ' .input_qtde').text(data.qtde);
                    $('#' + id + ' .sp_total').text(data.total);
                    $('#' + id + ' .sp_total').effect('highlight', 2000);
                    $('#total_compra').text('R$ ' + data.total_compra);
                    $('#total-carrinho-top').text(data.total_compra);
                    $('#total_compra').effect('highlight', 2000);
                })
            }
        } else {
            addPop(elm, 'Limite no Estoque', 'Seu pedido atingiu o número máximo deste item em nosso estoque!', 'top');
        }
        $('#btn-frete-calculo').click();
    })

    //remove -1 no carrinho
    $('.cart-remove').on('click', function () {
        var id = $(this).attr('name');
        var url = baseUri + '/carrinho/decrementa/' + id + '/';
        var id = $(this).attr('name');
        var elm = id + ' .input_qtde';
        $.post(url, {}, function (data) {
            data = $.parseJSON($.trim(data));
            if (data.itens <= 0) {
                limparCarrinho();
            }
            if (data.qtde == 0) {
                if ($.browser.msie) {
                    $('#' + id + ' .qtde').val(data.qtde);
                    $('#' + id + ' .input_qtde').text(data.qtde);
                    $('#' + id + ' .sp_total').text(data.total);
                    $('#' + id + ' .sp_total').effect('highlight', 2000);
                    $('#total_compra').text('R$ ' + data.total_compra);
                    $('#total-carrinho-top').text(data.total_compra);
                    $('#total_compra').effect('highlight', 2000);
                    $('#' + id).remove();
                    return false;
                } else {
                    $('#' + id).fadeOut(500, function () {
                        $('#' + id).remove();
                    });
                }
            } else {

                if (data.estoque <= 5 && data.estoque >= 1) {
                    var restante = parseInt(data.estoque);
                    if (restante > 1) {
                        var msg = 'Restam apenas ' + restante + ' itens em nosso estoque!';
                    } else {
                        var msg = 'Resta apenas ' + restante + ' item em nosso estoque!';
                    }
                    addPop(elm, 'Limite no Estoque', msg, 'top');
                }
                $('#' + id + ' .qtde').val(data.qtde);
                $('#' + id + ' .input_qtde').text(data.qtde);
                $('#' + id + ' .sp_total').text(data.total);
                $('#' + id + ' .sp_total').effect('highlight', 2000);
                $('#total_compra').text('R$ ' + data.total_compra);
                $('#total-carrinho-top').text(data.total_compra);
                $('#total_compra').effect('highlight', 2000);
            }
            $('#btn-frete-calculo').click();
            $('#total_compra').text('R$ ' + data.total_compra);
            $('#total_compra').effect('highlight', 2000);
        })
    })
    //button remove item
    $('.btn-cart-remove').on('click', function () {
        var id = $(this).attr('id');
        var url = baseUri + '/carrinho/remove/' + id + '/';
        window.location = url;
    });
    //limpa carrinho + refresh
    limparCarrinho = function () {
        var url = baseUri + '/carrinho/clear/retorna/';
        window.location = url;
    }

    $('.btn-update-frete').on('click', function () {
        var prazo = $(this).attr('p');
        var valor = $(this).attr('v');
        freteReload(valor);
    });

    //calculo frete
    $('#btn-frete-calculo').on('click', function (e) {
        var $btncalc = $(this);
        e.stopPropagation();
        e.preventDefault();
        var cep = $.trim($('#frete_cep').val());
        if (cep.length <= 8) {
            return false;
        }
        freteReload(0); //reset valor frete
        $('#frete_cep').removeClass('invalid');
        $btncalc.button('loading');
        var url = baseUri + '/cep/getcep/';
        $.post(url, {
            cep: cep
        }, function (data) {
            if (data != -1) {
                data = $.parseJSON($.trim(data));
                data = data.rs[0];
                var datacep = {};
                if (data.cep_unico == 0) {
                    datacep = {
                        cep: cep,
                        uf: data.uf,
                        cidade: data.cidade,
                        bairro: data.bairro
                    };
                } else {
                    datacep = {
                        cep: cep,
                        uf: data.uf,
                        cidade: data.cidade,
                        bairro: data.bairro
                    };
                }
                freteCorreio(cep, datacep);
            } else {
                $('#frete_result_pac').html('');
                var msg = '<p class="font-12">Confirme seu cep e tente novamente.</p>';
                var tit = '<p class="font-12"><b>Cep não encontrado!</b></p>';
                addPop('frete_cep', tit, msg, 'bottom');
                $('#frete_cep').addClass('invalid').focus();
            }
        });
    });

});


function freteCorreio(cep, datacep) {
    var prog_bar = '<center><img src="images/layout/square_loader.gif" /><br/>Aguarde, calculando frete...</center>';
    $('#frete_result_pac').html(prog_bar);
    if (cep.length >= 9) {
        var url = baseUri + '/carrinho/nCalculo/';
        $.post(url, {}, function (data) {
            var rs = $.parseJSON($.trim(data));
            if (rs.p != 0) { //calcula frete
                if (rs.p == '-1') {
                    carrinhoVazio();
                }
                if (rs.cf == 'sim') {
                    var url = baseUri + '/frete/correios/';
                } else {
                    //nao calcula valor, somente prazo
                    var url = baseUri + '/frete/correios/no-cf/';
                }
                $.post(url, {
                    comprimento: rs.c,
                    largura: rs.l,
                    altura: rs.a,
                    peso: rs.p,
                    cep: cep,
                    uf: datacep.uf,
                    cidade: datacep.cidade,
                    bairro: datacep.bairro
                }, function (data) {
                    if (data == '-1') {
                        $('#frete_result_pac').html('<p class="alert alert-error">Serviço dos Correios indisponível</p>');
                    } else {
                        $('#frete_result_pac').html(data);
                        if ($('#frete-produtos').length >= 1) {
                            $('.nav-tabs li').removeClass('hide');
                            $('.nav-tabs a[href="#frete-produtos"]').tab('show');
                        }
                        $('.btn-update-frete').on('click', function () {
                            var prazo = $(this).attr('p');
                            var valor = $(this).attr('v');
                            freteReload(valor);
                        });
                        bindFreteDetail();
                    }
                })
            } else {
                $('#frete_result_pac').html('<b>Frete Grátis</b>');
            }
            $('#btn-frete-calculo').button('reset');
            $('.btn-update-frete').on('click', function () {
                var prazo = $(this).attr('p');
                var valor = $(this).attr('v');
                freteReload(valor);
            });
        })
    }
}

function bindFreteDetail() {
    $('.btn-detail-frete-1').on('click', function () {
        $('#texto-frete-2').addClass('hide');
        if ($('#texto-frete-1').hasClass('hide')) {
            $('#texto-frete-1').removeClass('hide');
        } else {
            $('#texto-frete-1').addClass('hide');
        }
    });
    $('.btn-detail-frete-2').on('click', function () {
        $('#texto-frete-1').addClass('hide');
        if ($('#texto-frete-2').hasClass('hide')) {
            $('#texto-frete-2').removeClass('hide');
        } else {
            $('#texto-frete-2').addClass('hide');
        }
    });
}

function freteReload(v1) {
    var url = baseUri + '/carrinho/nFormata/';
    $.post(url, {
        v1: v1
    }, function (data) {
        if (v1 >= 1) {
            if (logged && logged == true) {
                $('.btn-next').show();
            } else {
                $('.btn-login').show();
            }
        } else {
            $('.btn-next').hide();
        }
        $('#total_compra').html('R$ ' + data);
        $('#totalCompra').html('R$ ' + data);
    });

}

function addPop(elm, title, msg, pos) {
    //var msg = '<spam style="color:black"> ' + msg + '</spam>'
    $('#' + elm).popover('destroy');
    setTimeout(function () {
        $('#' + elm).popover({
            placement: pos,
            title: title,
            html: true,
            content: msg,
            'template': '<div class="popover fade top" style="width: 180px" role="tooltip"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>'
        });
        $('#' + elm).popover('show');
        setTimeout(function () {
            $('#' + elm).popover('hide');
        }, 3000)
    }, 300)
}
