//url base para acoes js
var baseUri = $('base').attr('href').replace('/app/', '');
//carregar mais itens na home
var pageb = 2;
//url que guarda a query do carregar mais
var route;
//maior / menor preco 
var preco_max = 0;
var preco_min = 0;
$(function () {

    // caso seja loja-modo 3 esconde preços e botão
    var modoLoja = $('#modo-loja').text();

    if(modoLoja == 3){
        $('.vitrine').addClass('hide').remove();
        $('.box-item').css('min-height','280px');
        $('.orcamento').text('Orçamentos');
        $('.orcamento-singular').text('Orçamento');
    }

    if(modoLoja == 2){
        $('.addtocart').text('ADICIONAR AO ORÇAMENTO');
        $('.orcamento').text('Orçamentos');
        $('.orcamento-singular').text('Orçamento');
        $('.vitrine-mod-2').hide().remove();
        $('.vitrine-center').addClass('col-md-offset-4').find('span').text('Imprimir Orçamento');
    }

    //todas as categorias do menu
    //$('#lista-categorias').hide();
    $('#show-lista-categorias').hover(function () {
        $('#lista-categorias').removeClass('hide').fadeIn(100);
    })
    $('#lista-categorias').on("mouseleave", function () {
        $('#lista-categorias').fadeOut(100);
    })
    /*link whats app*/
    if ($(document).width() <= 580) {
        let phone = $('.link-whatsapp').data('phone');
        if(phone != ''){
            phone = phone.match( /\d+/g ).join();
            $('.link-whatsapp').attr('href','http://api.whatsapp.com/send?1=pt_BR&phone=55'+phone);
        }
    }
    if ($(document).width() >= 1100) {
        //navbar bootstrap exibe o menu no hover
        jQuery('ul.nav li.dropdown').hover(function () {
            jQuery(this).find('.dropdown-menu').stop(true, true).delay(120).fadeIn();
            $('#lista-categorias').hide();
        }, function () {
            jQuery(this).find('.dropdown-menu').stop(true, true).delay(120).fadeOut();
        });
    }
    function load_tips() {
        $('.tips-top').tooltip({
            placement: 'top'
        });
        $('.tips-left').tooltip({
            placement: 'left'
        });
        $('.tips-bottom').tooltip({
            placement: 'bottom'
        });
        $('.tips-right').tooltip({
            placement: 'right'
        });
        if(modoLoja == 3){
            $('.vitrine').addClass('hide').remove();
            $('.box-item').css('min-height','280px');
        }        
    }
    window.onload = function () {
        //tootips
        load_tips();
        //if ($(document).width() >= 1100 ) {
            //topo menu float ao rolar a pagina
            if ($(document).height() >= 1200) {
                var elm = $('#top'), pos = elm.offset();
                var elmH = $('#top-menu');
                $(window).scroll(function () {
                    if ($(this).scrollTop() >= pos.top + $('#top').height()) {
                        $('.cart-hide').removeClass('hide').show();
                        $('.compare-hide').removeClass('hide').show();
                    } else {
                        $('.cart-hide').hide();
                        $('.compare-hide').hide();
                    }
                });
            }
        //}

        setTimeout(function () {
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id))
                    return;
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.3&appId=446742768704668";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
        },2000)
    };
    //carregar mais itens na home
    var page = 2;
    //carregar mais itens 
    $('#carregar-mais').on('click', function () {
        $(this).hide();
        $('.box-all').append('<div id="load_page_add" class="col-md-12 center text-center load_page_add"><img src="images/layout/loadmore.gif" /></div>');
        if (route != '') {
            var url = route + '/page/' + pageb + '/';
        } else {
            var url = baseUri + '/index/loadMore/page/' + pageb + '/categoria/';
            //route = baseUri;
        }
        $.post(url, {loadmore_home: 0}, function (data) {
            if (data != -1) {
                $('.box-all').append(data);
                $('html, body').animate({
                    // scrollTop: $('#load_page_add').offset().top - 60
                }, 1300);
                $('.load_page_add').remove();
                $('.up2top').fadeIn();
                load_tips();
                pageb++;
            } else {
                $('.load_page_add').remove();
                $('#carregar-mais').attr('disable', 'disable').hide();
            }
        });
    });
    //carregar mais itens
    $('#carregar-mais-home').on('click', function () {
        $(this).hide();
        $('.box-all').append('<div id="load_page_add" class="center text-center col-md-12 load_page_add" style="float:left;"><img src="images/layout/loadmore.gif" /></div>');
        var url = baseUri + '/index/loadMore/page/' + pageb + '/';
        $.post(url, {loadmore_home: 1}, function (data) {
            console.log(data)
            if (data != -1) {
                $('.box-all:last').append(data);
                $('html, body').animate({
                    // scrollTop: $('#load_page_add').offset().top - 60
                }, 1300);
                $('.load_page_add').remove();
                $('.up2top').fadeIn();
                load_tips();
                pageb++;
            } else {
                $('.load_page_add').remove();
                $('#carregar-mais-home').attr('disable', 'disable').hide();
            }
        })
    })
    //ordenar resultados btn
    $('.sort-list').on('click', function () {
        pageb = 2;
        if ($(this).val() != '0') {
            $('.sort-list').removeClass('btn-default').removeClass('btn-custom').addClass('btn-default');
            $(this).removeClass('btn-default').addClass('btn-custom');
            $('#carregar-mais').hide();
            $('.box-all').html('');
            $('.box-all').append('<div id="load_page_add" class="center text-center col-md-12 load_page_add" style="float:left;"><img src="images/layout/loadmore.gif?v=2" /></div>');
            var url = baseUri + '/index/ordenar/' + $(this).val();
            if ($(this).data('local') == 1) {
                url += '/1/';
            }
            route = url;
            $.post(url, {}, function (data) {
                if (data != -1) {
                    $('.box-all').append(data);
                    $('.load_page_add').remove();
                } else {
                    $('.load_page_add').remove();
                    $('#carregar-mais').hide();
                }
                load_tips();
            });
        }
        return false;
    });
    //ordenar resultados select
    $('.sel-sort-list').on('change', function () {
        pageb = 2;
        if ($(this).val() != '0') {
            $('#carregar-mais').hide();
            $('.box-all').html('');
            $('.box-all').append('<div id="load_page_add" class="center text-center col-md-12" style="float:left;"><img src="images/layout/loadmore.gif" /></div>');
            var url = baseUri + '/index/ordenar/' + $(this).val() + '/';
            if ($(this).data('local') == 1) {
                url += '1/';
            }
            route = url;
            $.post(url, {}, function (data) {
                if (data != -1) {
                    $('.box-all').append(data);
                    $('#load_page_add').remove();
                } else {
                    $('#load_page_add').remove();
                    $('#carregar-mais').hide();
                }
                load_tips();
            });
        }
        return false;
    });
    //busca
    $('#busca').submit(function () {
        if ($('#busca').val() == "") {
            $('#busca').focus();
            return false;
        }
    });
    //recuperar senha
    $('.btn-repass').on('click', function () {
        $('.message_login').html('');
        $('#nav-login').hide();
        $('#nav-login-repass').show();
    });
    //correr para o topo
    $('.up2top').on('click', function () {
        $('html, body').animate({
            scrollTop: $('#top').offset().top - 60
        }, 1300)
    });
    //cadastro newsletters
    $('#btn-news-add').on('click', function () {
        var nome = $.trim($('#news_nome').val());
        var email = $.trim($('#news_email').val());
        var dados = {news_email: email, news_nome: nome};
        if (nome == "") {
            $('#news_nome').attr('placeholder', 'informe seu nome').val('').focus();
            return false;
        }
        if (!IsEmail(email)) {
            $('#news_email').attr('placeholder', 'informe um email válido').val('').focus();
            return false;
        }
        var url = baseUri + '/index/news_add/';
        $.post(url, dados, function (data) {
            if (data == 0) {
                $("#n-news").hide();
                $("#n-news-ok").removeClass('hide').show();
                setTimeout(function () {
                    $("#n-news-ok").fadeOut(1000);
                    setTimeout(function () {
                        $("#n-news").fadeIn(1500);
                        $('#news_nome').val('');
                        $('#news_email').val('');
                    }, 1000);
                }, 5000);
            }
            if (data == 1) {
                $("#n-news").hide();
                $("#n-news-error").removeClass('hide').show();
                setTimeout(function () {
                    $("#n-news-error").fadeOut(1000);
                    setTimeout(function () {
                        $("#n-news").fadeIn(1500);
                        $('#news_email').val('').focus();
                    }, 1000);
                }, 5000);
            }
        });
    });
    $('.one-click-to-cart').on('click', function () {
        var item_id = $(this).attr('id');
        var url = baseUri + '/carrinho/adicionar/' + item_id + '/';
        $.post(url, {attr: '',id: item_id}, function (data) {
            var url = baseUri + '/index/reload_top_cart/';
            $.post(url, {}, function (btn) {
                btn = $.parseJSON(btn);
                $(".btn-top-cart").addClass('btn-default').html(btn.lg);
                $(".btn-top-cart-sm").html(btn.sm);
            });
            $('html, body').animate({
                // scrollTop: $('#top').offset().top - 60
            }, 1300);
        });
    });
    $('.go-to-cart').on('click', function () {
        var url = $(this).data('url');
        window.location = url;
    });

    var url = baseUri + '/compara/addComparaIndex';
    $(".compara-produto").on("click", function () {
        var id = $(this).data('id');
        $.post(url,{item_id: id}, function (data) {
            var url = baseUri + '/index/reload_top_compara/';
            $.post(url, {}, function (btn) {
                btn = $.parseJSON(btn);
                $(".btn-top-compara").addClass('btn-default').html(btn.lg);
                $(".btn-top-compara-sm").html(btn.sm);
            });
            $('html, body').animate({
                // scrollTop: $('#top').offset().top - 60
            }, 1300);
        });
    });
});


function IsEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}
//seta range valor apos usar filtros
function setRangePreco(min, max) {
    if (min <= preco_min) {
        preco_min = min;
    }
    preco_min = min;
    if (max >= preco_max) {
        preco_max = max;
    }
    var n_input = '<input type="text" class="" value="" '
    n_input += ' data-slider-min="' + (preco_min - 5) + '" ';
    n_input += ' data-slider-max="' + (preco_max + 50) + '" ';
    n_input += ' data-slider-step="30" ';
    n_input += ' data-slider-value="[' + (preco_min - 5) + ',' + (preco_max + 50) + ']" ';
    n_input += ' id="range-preco">';
    $('#p-range-preco').html(n_input);
    $('#range-preco').slider().on('slide', function (ev) {
        v_min = ev.value[0];
        v_max = ev.value[1];
        $('.item-box').each(function () {
            var preco = $(this).data('preco');
            //var id = $(this).data('id');
            if (preco >= v_min && preco <= v_max) {
                $(this).fadeIn();
            } else {
                $(this).fadeOut();
            }
        });
    });
}
//oculta botao exibir mais
function hideShowBtnMore(hs) {
    if (hs == 1)
        $('.btn-load-more').hide();
    else
        $('.btn-load-more').show();
}
//paginacao home via get/post
function initHomeItem() {
    var url = baseUri + '/index/loadMore/page/2/';
    $.post(url, {}, function (data) {
        if (data != -1) {
            $('.box-all').append(data);
        }
    })
}
//menu horizontal, user logado , checa no footer.html
function replaceMenu(logged) {
    //fix IE
    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");
    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) {
        $('#top-menu .navbar').addClass('pull-left');
    }
    $('.navbar').removeClass('hide').show();
    if (logged && logged == true) {
        $('.nologged').hide();
        $('.logged').removeClass('hide').show();
    } else {
        $('.logged').hide();
        $('.nologged').removeClass('hide').show();
    }
}
//set menu categoria ativo / setado no footer.html
function setActiveMenu(catAct, subAct) {
    if (catAct != "") {
        $('.' + catAct).addClass('active');
    }
}

