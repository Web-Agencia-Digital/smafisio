var baseUri = $('base').attr('href').replace('/app/', '');
$(function () {
    //identificacao login-cadastro
    $('.cad').on('click', function () {
        $(this).each(function () {
            if ($(this).attr('checked') == 'checked') {
                if ($(this).attr('id') == 'cadastrar') {
                    $('#cliente_password').removeAttr('required');
                    $('#cliente_password').attr('disabled', 'disabled');
                } else {
                    $('#cliente_password').removeAttr('disabled');
                    $('#cliente_password').attr('required');
                }
            }
        })
    })
    //tabs enderecos
    $('#endTab').tab();
    $('#endTab a').click(function (e) {
        e.preventDefault();
        $(this).tab('show');
    })
    $('#endTab a:eq(1)').tab('show');
    $('#endTab a:eq(0)').tab('show');
    //selecao enderecos /entrega e retirada
    var tipo_entrega;
    $('.end-entrega').on('click', function () {
        $('#frete_result').html('');
        $('html, body').animate({
            scrollTop: $('#btn-finaliza').offset().top - 150
        }, 800);

        $(this).each(function () {
            tipo_entrega = $(this).attr('tipo');
            tipo_entrega_cep = $(this).attr('cep');
            addr = $(this).attr('addr');
            addr_id = $(this).val();
            //gravar na sessao PHP
            $('#entrega_selecionada').val(addr_id);
            $('#entrega_selecionada_tipo').val(tipo_entrega)
            $('#entrega_selecionada_id').val(tipo_entrega_cep);
            $('#entrega_selecionada_desc').val(addr);
            if (tipo_entrega == 1) {
                $('#btn-finaliza').attr('disabled', 'disabled');
                $('#btn-finaliza').html('<i class="fa fa-clock-o"></i> calculando frete, aguarde...');
                calculaFrete(tipo_entrega_cep);
            } else {
               setTimeout(function () {
                    $('#btn-finaliza').removeAttr('disabled');
                    $('#btn-finaliza').html('Prosseguir <i class="fa fa-chevron-right"></i> ');
                }, 1500);
            }
        });
    });
    $('.metodo-pagamento').on('click', function () {
        $('#btn-finaliza').removeAttr('disabled');
        $('#btn-finaliza').html('Prosseguir <i class="fa fa-chevron-right"></i> ')
        $('html, body').animate({
            scrollTop: $('#btn-finaliza').offset().top - 420
        }, 800);
    });
    $('#btn-finaliza').on('click', function () {
       // $('#btn-finaliza').button('loading');
    });
    $('.btn-cupom-valida').on('click', function () {
        var cupom = $.trim($('#cupom').val());
        var url = baseUri + '/cupom/validar/';
        $.post(url, {
            cupom: cupom
        }, function (data) {
            $('#cupom-msg').html('');
            if (data == -3) {
                $('#cupom-msg').removeClass('text-success').addClass('text-danger');
                $('#cupom-msg').html('<b>Cupom Inválido ou já utilizado!</b>');
            } else if (data == -2) {
                $('#cupom-msg').removeClass('text-success').addClass('text-danger');
                $('#cupom-msg').html('<b>Validade do Cupom Vencida!</b>');
            } else if (data == -1) {
                $('#cupom-msg').removeClass('text-success').addClass('text-danger');
                $('#cupom-msg').html('<b>Cupom Inválido!</b>');
            } else if (data == 4) {
                $('#cupom-msg').removeClass('text-danger').addClass('text-success');
                $('#cupom-msg').html('<b>Cupom Frete Grátis!</b>');
            } else if (data == 3) {
                $('#cupom-msg').removeClass('text-danger').addClass('text-success');
                $('#cupom-msg').html('<b>Desconto aplicado!</b>');
            }
            setTimeout(function () {
                window.location.href = baseUri + '/finalizar/confirmar/?cupom';
            }, 1000);
        });
    })
    $('.btn-update-frete').on('click', function () {
        var prazo = $(this).attr('p');
        var valor = $(this).attr('v');
        var tipo = $(this).attr('t');
        freteReload(valor.replace(',', '.'), prazo, tipo);
    });
    setInterval(function () {
        $('.btn-update-frete').on('click', function () {
            var prazo = $(this).attr('p');
            var valor = $(this).attr('v');
            var tipo = $(this).attr('t');
            freteReload(valor.replace(',', '.'), prazo, tipo);
        });
    }, 500);
    var modoLoja = $('#modo-loja').text();
});
function ocultaRetirada() {
    $("#retirada").hide();
    $("#retirada").remove();
}
function ocultaEntrega() {
    $("#entrega").hide();
    $("#entrega").remove();
}
function ocultaPayPal() {
    $("#paypal").hide();
    $("#paypal").remove();
}
function ocultaDeposito() {
    $("#deposito").hide();
    $("#deposito").remove();
}
function ocultaBoleto() {
    $("#boleto").hide();
    $("#boleto").remove();
}
function ocultaCielo() {
    $("#cielo").hide();
    $("#cielo").remove();
}
function ocultaPagSeguro() {
    $("#pagseguro").hide();
    $("#pagseguro").remove();
}
function ocultaMercadoPago() {
    $("#mercadopago").hide();
    $("#mercadopago").remove();
}


//calculo frete
function calculaFrete(cep) {
    var url = baseUri + '/cep/getcep/';
    $.post(url, {
            cep: cep
        },
        function (data) {
            data = $.trim(data);
            if (data != -1) {
                data = $.parseJSON(data);
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
        })
}

function freteCorreio(cep, datacep) {
    var prog_bar = '<center><img src="images/layout/square_loader.gif" /><br/>Aguarde, calculando frete...</center>';
    $('#frete_result').html(prog_bar);
    if (cep.length >= 9) {
        var url = baseUri + '/carrinho/nCalculo/';
        $.post(url, {}, function (data) {
            data = $.trim(data);
            var rs = $.parseJSON(data);
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
                    }
                    , function (data) {
                        data = $.trim(data);
                        if (data == '-1') {
                            $('#frete_result').html('<p class="alert alert-error">Serviço dos Correios indisponível</p>');
                        } else {
                        }
                        $('#frete_result').html(data);
                        bindFreteDetail();
                    });
            } else {
                $('#frete_result').html('<b>Frete Grátis</b>');
            }
            $('#btn-frete-calculo').button('reset');
        })
        $('#btn-finaliza').html('<i class="fa fa-clock-o"></i> Aguardando opção de frete');
        $('#modal-frete').modal('show');
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


function freteReload(v1, v2, v3) {
    var url = baseUri + '/carrinho/nFormata/';
    $.post(url, {
        v1: v1,
        v2: v2,
        v3: v3
    }, function (data) {
        $('#btn-finaliza').html('Prosseguir <i class="fa fa-chevron-right"></i>');
        $('#btn-finaliza').removeAttr('disabled');
        $('#modal-frete').modal('hide');

        /*
         if(v1 >= 1){
         }else{
         window.location = baseUri + '/finalizar/entrega/';
         }
         */
    })
}

function carrinhoVazio() {
    window.location = baseUri + '/carrinho/';
}
