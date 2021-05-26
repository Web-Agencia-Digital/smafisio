$(function () {


    function bandeira() {
        PagSeguroDirectPayment.getBrand({
            cardBin: $.trim($('#cartao_num').val()),
            success: function (response) {
                $('#card_brand').val(response.brand.name);
                var bandeira = response.brand.name;
                $('<img />')
                    .attr('src', 'https://stc.pagseguro.uol.com.br/public/img/payment-methods-flags/68x30/' + bandeira + '.png')
                    .appendTo($('#brand_flag'));
            },
            error: function (response) {
                console.log(response)
            },
            complete: function (response) {
                // console.log(response)
            }
        });
    }

    function cardToken() {
        var param = {
            cardNumber: $("#cartao_num").val(),
            cvv: $("#cartao_cod").val(),
            expirationMonth: $("#cartao_mes").val(),
            expirationYear: $("#cartao_ano").val(),
            success: function (response) {
                $('#card_token').val(response.card.token)
                parcelamento()
                get_senderHash()
            },
            error: function (response) {
                console.log(response)
            },
            complete: function (response) {
                // console.log(response)
            }
        }
        PagSeguroDirectPayment.createCardToken(param);
    }

    function parcelamento() {

        var parcelas_sem_juros = $('#pagseguro_semjuros').val();
        if (parcelas_sem_juros > 1) {
            PagSeguroDirectPayment.getInstallments({
                amount: $("#amount").val(),
                brand: $("#card_brand").val(),
                maxInstallmentNoInterest: parcelas_sem_juros,
                success: function (response) {
                    //console.log(response)
                    parcelas(response.installments)
                },
                error: function (response) {
                    console.log(response)
                },
                complete: function (response) {
                    //console.log(response)
                }
            })
        } else {
            PagSeguroDirectPayment.getInstallments({
                amount: $("#amount").val(),
                brand: $("#card_brand").val(),
                //maxInstallmentNoInterest: parcelas_sem_juros,
                success: function (response) {
                    //console.log(response)
                    parcelas(response.installments)
                },
                error: function (response) {
                    console.log(response)
                },
                complete: function (response) {
                    //console.log(response)
                }
            })
        }
    }

    function parcelas(parcelamento) {
        $.each(parcelamento, function (brands, installments) {
            $('#card_parcela option').remove();
            $.each(installments, function (k, v) {
                $('<option />')
                    .attr('data-amount', parseFloat(v.installmentAmount).toFixed(2))
                    .val(v.quantity)
                    .text(parseInt(v.quantity) + ' x ' + parseFloat(v.installmentAmount).toFixed(2) + ' = ' + (parseInt(v.quantity) * parseFloat(v.installmentAmount)).toFixed(2))
                    .appendTo($('#card_parcela'));
            })
            $('#card_parcela').trigger('change');
        })
    }

    $('.updade-parcela').on('change', function () {
        //parcelamento();
    })

    $('#card_parcela').on('change', function () {
        $('#parcelamento').show();
        var nparcelas = $("#card_parcela").val();
        var totalAmount = $('#card_parcela option:selected').data('amount');
        var total = Math.abs(nparcelas * totalAmount).toFixed(2);
        $("#pedido_total_parcelado").val(total);
        $(".total_parcelado").text("Valor Total Parcelado : R$ " + total);
        setTimeout(function () {
            $("#btn-finaliza-credito").removeClass('disabled');
        }, 1000);
        $('#total_amount').val(totalAmount)
    })

    function get_senderHash() {
        var sender_hash = PagSeguroDirectPayment.getSenderHash();
        $('#sender_hash').val(sender_hash)
    }

//    chamada das funcoes
    $("#fakecartao_num").change(function () {
        $("#cartao_num").val($.trim($("#fakecartao_num").val().split(" ").join("")));
        bandeira();
        cardToken();

    });

    $("#cartao_num").change(function () {
        bandeira();
        cardToken();
    });
    $("#cartao_cod").change(function () {
        bandeira();
        cardToken();
    });
    $("#cartao_mes").change(function () {
        bandeira();
        cardToken();
    });
    $("#cartao_ano").change(function () {
        bandeira();
        cardToken();
    });
    $("#cartao_cpf").change(function () {
        bandeira();
        cardToken();
    });
    $("#cartao_nome").change(function () {
        bandeira();
        cardToken();
    });

});