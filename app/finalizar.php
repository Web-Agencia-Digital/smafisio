<?php
error_reporting(E_ALL);

class Finalizar extends PHPFrodo
{

    public $config = array();
    public $page_url;
    public $logged = false;
    public $total_compra;
    public $pedido_id = 0;
    public $pedido_total_frete;
    public $pedido_frete;
    public $cliente_id;
    public $cliente_nome;
    public $cliente_email;
    public $itens_da_fatura;
    public $pedido_endereco;
    public $pedido_entrega;
    public $frete_prazo;
    public $valor_total_formatado;
    public $valor_frete_formatado;
    public $payConfig;

    public function __construct()
    {
        parent:: __construct();
        $sid = new Session;
        $sid->start();
        if ($sid->check() && $sid->getNode('cliente_id') >= 1) {
            $this->cliente_email = (string)$sid->getNode('cliente_email');
            $this->cliente_id = (string)$sid->getNode('cliente_id');
            $this->cliente_nome = (string)$sid->getNode('cliente_nome');
            $this->cliente_fullnome = (string)$sid->getNode('cliente_fullnome');
            $this->assign('cliente_nome', $this->cliente_nome);
            $this->assign('cliente_email', $this->cliente_email);
            $this->assign('cliente_msg', 'acesse aqui sua conta.');
            $this->assign('logged', 'true');
            $this->logged = true;
        } else {
            $this->assign('cliente_nome', 'visitante');
            $this->assign('cliente_msg', 'faça seu login ou cadastre-se.');
            $this->assign('logged', 'false');
        }
        $this->select()
            ->from('config')
            ->execute();
        if ($this->result()) {
            $this->map($this->data[0]);
            $this->config = (object)$this->data[0];
            $this->assignAll();
        }
        $this->select()->from('frete')->execute();
        $this->map($this->data[0]);
        $this->select()
            ->from('social')
            ->execute();
        if ($this->result()) {
            $this->social = (object)$this->data[0];
            if ($this->social->social_fb == "") {
                $this->assign('faceSH', 'hide');
            } else {
                $pl = '<div class="fb-page" data-href="' . $this->social->social_fb . '" data-width="500" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"><div class="fb-xfbml-parse-ignore"><blockquote cite="https://www.facebook.com/clares.lab"><a href="https://www.facebook.com/clares.lab">PHPStaff</a></blockquote></div></div>
                <div id="fb-root"></div>';
                $this->assign('social_plug_fb', $pl);
            }
            if ($this->social->social_tw == "") {
                $this->assign('twSH', 'hide');
            }
            if ($this->social->social_yt == "") {
                $this->assign('ytSH', 'hide');
            }
            if ($this->social->social_in == "") {
                $this->assign('inSH', 'hide');
            }
            if ($this->config->config_site_cnpj == "") {
                $this->assign('cnpjSH', 'hide');
            }
            $this->assignAll();
        }
        $this->payConfig = new Pay;
        if (isset($this->payConfig->_cielo['pay_c3'])) {
            $this->assign('parc_num_info', $this->payConfig->_cielo['pay_c3']);
        } else {
            $this->assign('parc_num_info', 12);
        }
    }

    public function welcome()
    {
        if ($this->logged == true) {
            $this->redirect("$this->baseUri/finalizar/entrega/");
        }
        if ($this->postIsValid(array('cliente_cadastrado' => 'string'))) {
            $cadastrado = $this->postGetValue('cliente_cadastrado');
            if ($cadastrado == 'nao') {
                $_SESSION['referer'] = "$this->baseUri/finalizar/";
                $_SESSION['email_cadastro'] = $this->postGetValue('cliente_email');
                $url_retorno = (string)$_SESSION['referer'];
                $this->redirect("$this->baseUri/cliente/cadastro/");
            }
        }
        $this->tpl('public/finalizar_identificacao.html');
        if ($this->postIsValid(array('cliente_email' => 'email', 'cliente_password' => 'string'))) {
            $cliente = new Cliente();
            $cliente->proccess();
            if ($cliente->login_status == false) {
                $msg_login = '<p class="alert alert-danger">';
                $msg_login .= 'Foram encontrados os seguintes problemas: <br>';
                $msg_login .= $cliente->message_login;
                $msg_login .= '</p>';
                $this->assign('message_login', "$msg_login");
            } else {
                $this->redirect("$this->baseUri/finalizar/entrega/");
            }
        }
        $this->getMenu();
        $this->render();
    }

    public function entrega()
    {
        $this->tpl('public/finalizar_entrega.html');
        $this->getItens();
        if ($this->logged == true) {
            if ($this->config->config_modo == 2) {
                $end = $this->getClienteAddrOne($this->cliente_id);
                $_SESSION['finaliza-entrega'] = [
                    'entrega_selecionada' => $end->endereco_id,
                    'entrega_selecionada_tipo' => 1,
                    'entrega_selecionada_desc' => $end->endereco_title,
                    'entrega_selecionada_id' => $end->endereco_cep
                ];
                $this->redirect("$this->baseUri/finalizar/pagamento/");
            }
            $this->getMenu();
            $this->assignAll();
            if ($this->frete_opcoes == 1) {
                $this->getClienteAddr();
                $this->getRetiradaAddr();
            } elseif ($this->frete_opcoes == 2) {
                $this->getClienteAddr();
                $this->assign('evt_onload', 'ocultaRetirada()');
            } elseif ($this->frete_opcoes == 3) {
                $this->getRetiradaAddr();
                $this->assign('evt_onload', 'ocultaEntrega()');
            }
            $this->render();
        } else {
            $this->redirect("$this->baseUri/finalizar/");
        }
    }

    public function pagamento()
    {
        if ($this->logged == true) {
            if ($this->config->config_modo == 2) {
                $_SESSION['finaliza-pagamento'] = "deposito";
            }
            if ($this->config->config_modo != 2) {
                $_SESSION['finaliza-entrega'] = $_POST;
            }
            $this->confirmar();
        } else {
            $this->redirect("$this->baseUri/finalizar/");
        }
    }

    public function confirmar()
    {
        $final_cart = new Carrinho;
        $this->cart = $_SESSION['cart'];
        foreach ($this->cart as $k => $v) {
            $att_now = "";
            $id = $this->cart[$k]['item_id'];
            if (isset($this->cart[$k]['atributos']) && !empty($this->cart[$k]['atributos'])) {
                $atrs = explode(",", $this->cart[$k]['atributos']);
                if (isset($atrs[3]) && !empty($atrs[3])) {
                    $att_id = intval($atrs[3]);
                    $att_now = $final_cart->getAttr_item($att_id, $id);
                    $att_now_preco = $att_now[0];
                    $att_now_item_preco = $att_now[3];
                    $att_now_preco_desconto = $att_now[4];
                    $this->cart[$k]['item_estoque'] = intval($att_now[1]);
                    $this->cart[$k]['atributo_qtde'] = intval($att_now[2]);
                    if (intval($att_now_preco) > 0) {
                        $this->cart[$k]['item_preco'] = ($att_now_preco + $att_now_item_preco) - $att_now_preco_desconto;
                        $this->cart[$k]['item_valor_original'] = ($att_now_preco + $att_now_item_preco);
                    }
                }
            } else {
                $this->select('item_preco,item_estoque,item_desconto')->from('item')->where("item_id = $id")->execute();
                if ($this->result()) {
                    $this->cart[$k]['item_preco'] = ($this->data[0]['item_preco']) - $this->data[0]['item_desconto'];
                    $this->cart[$k]['item_estoque'] = intval($this->data[0]['item_estoque']);
                    $this->cart[$k]['item_valor_original'] = floatval($this->data[0]['item_preco']);
                }
            }
            $this->cart[$k]['valor_total'] = intval($this->cart[$k]['item_qtde']) * $this->cart[$k]['item_preco'];
        }
        $_SESSION['cart'] = $this->cart;
        $maior_parc = 1;
        foreach ($_SESSION['cart'] as $item) {
            $parcs = intval($item['item_parc']);
            ($parcs > $maior_parc) ? $maior_parc = $parcs : '';
        }
        $r = new Route;
        $r->set("FINALIZAR");


        if ($this->logged == true) {
            if (isset($_SESSION['finaliza-entrega']['entrega_selecionada_tipo'])) {
                if ($_SESSION['finaliza-entrega']['entrega_selecionada_tipo'] == 1) {
                    $_SESSION['mycep'] = $_SESSION['finaliza-entrega']['entrega_selecionada_id'];
                } else {
                    $_SESSION['mycep_frete'] = "0";
                    $_SESSION['mycep_prazo'] = "Retirada no local";
                    $_SESSION['mycep_tipo_frete'] = "";
                }
                $_SESSION['mycep_entrega'] = (string)$_SESSION['finaliza-entrega']['entrega_selecionada'];
            }
            $this->local_entrega = "";
            if ($this->config->config_modo == 1) {
                $_SESSION['finaliza-pagamento'] = $this->payConfig->_pay['Config']->pay_key;
                if (isset($_POST['pagamento']) && !empty($_POST['pagamento'])) {
                    $_SESSION['finaliza-pagamento'] = $_POST['pagamento'];
                }
            }
            if ($this->config->config_modo == 2) {
                $_SESSION['mycep_entrega'] = (string)$_SESSION['finaliza-entrega']['entrega_selecionada'];
                $_SESSION['finaliza-pagamento'] = "deposito";
                $_SESSION['metodo_pagamento'] = 'deposito';
                $this->checkout();
                exit;
            }
            $this->pay_gw = $_SESSION['finaliza-pagamento'];

            global $btn_popup;
            $btn_popup = false;


            // Verifica tipo de gatway
            $this->select('pay_key')->from('pay')->where('pay_id = 6')->execute();
            $gatway = $this->data[0]['pay_key'];
            if (isset($gatway) && !empty($gatway) && $gatway == 'pagseguro') {
                $this->select()->from('pay')->where('pay_name = "Deposito"')->execute();
                $this->map($this->data[0]);
                $this->assign('deposito_on_off', $this->pay_status);

                $this->select()->from('pay')->where('pay_name = "PagSeguro"')->execute();
                $this->map($this->data[0]);
                $cred = $this->pagseguro_get_session($this->pay_user, $this->pay_key, $this->pay_c5);
                $this->assign('pagseguro_url_js', $cred->url_js);
                $this->assign('pagseguro_ssid', $cred->url_ssid);
                $this->assign('pagseguro_semjuros', $this->pay_c1);
                if ($this->pay_gw == 'pagseguro' || $this->pay_gw == 'PagSeguro') {
                    $this->tpl('public/finalizar_confirmar_pagseguro.html');
                }
                if ($this->pay_gw == 'cielo' || $this->pay_gw == 'Cielo') {
                    $this->tpl('public/finalizar_confirmar_cielo.html');
                }
                if ($this->payConfig->_pay['PagSeguro']->pay_status == 2) {
                    $this->assign('show_hide_cartao', 'hide');
                }
                $this->assign('pay_gw_url', "$this->baseUri/finalizar/checkout/");
                if (isset($_SESSION['mycep_frete'])) {
                    $frete_valor = $this->_money($_SESSION['mycep_frete']);
                    $frete_valor_unformat = $_SESSION['mycep_frete'];
                    $frete_prazo = $_SESSION['mycep_tipo_frete'];
                    $local_entrega = $_SESSION['finaliza-entrega']['entrega_selecionada_desc'];
                    ($frete_valor <= 0) ? $frete_valor = '<b></b>' : $frete_valor = "R$  $frete_valor ";
                    $this->assign('frete_valor', $frete_valor);
                    $this->assign('frete_prazo', $frete_prazo);
                    $this->assign('local_entrega', $local_entrega);
                }
                if (isset($_SESSION['cupom']['alfa'])) {
                    $this->assign('cupom_alfa', $_SESSION['cupom']['alfa']);
                }
                $this->getCarrinho();
                /*PAGSEGURO TRANSP*/
                //Troca Boleto Padrão por Boleto PagSeguro
                $show_hide_boleto_pagseguro = 'hide';
                $show_hide_boleto_padrao = 'hide';
                if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
                    $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                    $show_hide_boleto_pagseguro = '';
                }
                if ($this->payConfig->_pay['Boleto']->pay_status == 1 && $this->payConfig->_pay['PagSeguro']->pay_c3 == 0) {
                    $show_hide_boleto_padrao = '';
                    $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                }
                $boleto_desconto = ($this->total_com_desconto - (($this->total_com_frete / 100) * $this->payConfig->_pay['Boleto']->pay_fator_juros));
                $boleto_desconto = number_format($boleto_desconto, 2, ',', '.');
                $this->assign('boleto_desconto', $this->payConfig->_pay['Boleto']->pay_fator_juros);
                $this->assign('boleto_valor', $boleto_desconto);
                $this->assign('show_hide_boleto_pagseguro', $show_hide_boleto_pagseguro);
                if ($this->payConfig->_pay['Config']->pay_user == 'pagseguro' && $this->payConfig->_pay['PagSeguro']->pay_status == 2) {
                    $this->assign('show_hide_boleto_pagseguro', 'hide');
                    $this->assign('evt_onload', '$("#a-dep").trigger("click");');
                }
                //hide_show_dep
                $this->assign('show_boleto_padrao', $show_hide_boleto_padrao);
                if ($this->pay_gw == 'cielo') {
                    $this->select()->from('pay')->where('pay_name = "Cielo"')->execute();
                    $this->map($this->data[0]);
                    $this->helper('cielo');
                    $visa = new Cielo;
                    $visa->taxa(0);
                    $visa->juros($this->pay_fator_juros);
                    if ($this->total_com_desconto > 0) {
                        $visa->valor($this->total_com_desconto);
                    } else {
                        $visa->valor($this->total_compra + $frete_valor_unformat);
                    }
                    $defparc = $this->total_compra + $frete_valor_unformat;
                    $defparc = floor($defparc / floatval($this->pay_c5));
                    if ($maior_parc < $defparc && $defparc >= 2 && $defparc <= $this->pay_c3) {
                        $maior_parc = $defparc;
                    }
                    $maior_parc = floor(($this->total_compra + $frete_valor_unformat) / $this->pay_c5);
                    if ($maior_parc > $this->pay_c3) {
                        $maior_parc = $this->pay_c3;
                    }
                    $visa->num_parcelas($maior_parc);
                    $visa->desconto_avista($this->pay_c2);
                    $visa->parcelas_sem_juros($this->pay_c1);
                    $visa->parcelamento();
                    $visa->add_bandeira_array($this->pay_c4);
                    $this->assign('cielo_parcelas', $visa->combo_parcelas());
                    $this->assign('cielo_bandeiras', $visa->combo_bandeiras());
                    $this->assign('cielo_info', $visa->header_info());
                    $this->assign('evt_pay_module_start', $visa->get_event_start());
                    $this->assign('show_pay_module_start', 'cielo');
                } else {
                    $this->assign('evt_pay_module_start', '');
                    $this->assign('parcelamento-cartao', 'hide');
                    $this->assign('show_pay_module_start', '');
                }
                $this->assign('pagseguro_amount', $this->_moneyUS($this->total_com_desconto));
                $this->getMenu();
                $this->render();
            } elseif (isset($gatway) && !empty($gatway) && $gatway == 'mercadoPago') {
                $this->select()->from('pay')->where('pay_name = "Deposito"')->execute();
                $this->map($this->data[0]);
                $this->assign('deposito_on_off', $this->pay_status);
                $this->getCarrinho();

                $this->tpl('public/finalizar_confirmar_mercadopago.html');
                // MERCADO PAGO
                $this->select()->from('pay')->where('pay_name = "MercadoPago" ')->execute();
                if (isset($this->data[0]) && !empty($this->data[0])) {
                    $_mpago = $this->data[0];
                    $this->assign('pay_key', $_mpago['pay_key']);
                    $this->assign('pay_user', $_mpago['pay_user']);

                    $this->map($this->data[0]);
                    $this->assign('pay_gw_url', "$this->baseUri/finalizar/checkout/");

                    $fator_juros = $this->payConfig->_pay['PagSeguro']->pay_fator_juros;
                    $boleto_desconto = ($this->total_com_desconto - (($this->total_com_frete / 100) * $fator_juros));
                    $boleto_desconto = number_format($boleto_desconto, 2, ',', '.');
                    $this->assign('boleto_desconto', $fator_juros);
                    $this->assign('boleto_valor', $boleto_desconto);
                    $this->assign('pagseguro_amount', $this->_moneyUS($this->total_com_desconto));

                    $show_hide_boleto = 'hide';
                    if ($_mpago['pay_c3'] == 1) {
                        $show_hide_boleto = '';
                    }
                    $this->assign('show_hide_boleto', $show_hide_boleto);

                    if (isset($_SESSION['mycep_frete'])) {
                        $frete_valor = $this->_money($_SESSION['mycep_frete']);
                        $frete_valor_unformat = $_SESSION['mycep_frete'];
                        $frete_prazo = $_SESSION['mycep_tipo_frete'];
                        $local_entrega = $_SESSION['finaliza-entrega']['entrega_selecionada_desc'];
                        ($frete_valor <= 0) ? $frete_valor = '<b></b>' : $frete_valor = "R$  $frete_valor ";
                        $this->assign('frete_valor', $frete_valor);
                        $this->assign('frete_prazo', $frete_prazo);
                        $this->assign('local_entrega', $local_entrega);
                    }
                    if (isset($_SESSION['cupom']['alfa'])) {
                        $this->assign('cupom_alfa', $_SESSION['cupom']['alfa']);
                    }

                    $this->getMenu();
                    $this->render();

                } else {
                    $this->redirect("$this->baseUri/finalizar/");
                }
            }


        } else {
            $this->redirect("$this->baseUri/finalizar/");
        }
    }

    public function pre($data = null)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function checkout()
    {
        if (isset($_SESSION['finaliza-pagamento'])) {
            $this->incluirPedido();
        } else {
            $this->redirect("$this->baseUri/finalizar/");
        }
    }

    public function incluirPedido()
    {

        if (!isset($_SESSION['finaliza-entrega']) || !isset($_SESSION['mycep_entrega'])) {
            $this->redirect("$this->baseUri/finalizar/");
        }

        if (isset($_POST['metodo_pagamento']) && !empty($_POST['metodo_pagamento'])) {
            $_SESSION['metodo_pagamento'] = $_POST['metodo_pagamento'];
        }

        if (isset($_SESSION['cupom']['id'])) {
            $id_cupomm = intval($_SESSION['cupom']['id']);
            $this->select()->from('cupom')->where("cupom_id = $id_cupomm")->execute();
            if (isset($this->data[0])) {
                $att_cupom = intval($this->data[0]['cupom_lote']) + 1;
                $f_cupom = array(
                    'cupom_lote',
                );
                $v_cupom = array(
                    $att_cupom,
                );
                $this->update('cupom')->set($f_cupom, $v_cupom)->where("cupom_id = $id_cupomm")->execute();
            }
        }

        $cart = new Carrinho;
        $cart->getTotal();
        $this->pedido_cupom_desconto = 0;
        $this->pedido_cupom_alfa = $cart->cupom_alfa;
        $this->pedido_cupom_info = $cart->cupom_desconto_info;
        if ($cart->valor_desconto >= 1) {
            $this->pedido_cupom_desconto = $cart->valor_desconto;
        }
        $this->pedido_entrega = (string)$_SESSION['finaliza-entrega']['entrega_selecionada_tipo'];
        $this->pedido_endereco = (string)$_SESSION['mycep_entrega'];
        $this->prazo_frete = (string)$_SESSION['mycep_tipo_frete'] . " ";
        $this->valor_frete = ($cart->valor_frete);
        $this->pedido_total_frete = ($cart->total_com_frete - $this->pedido_cupom_desconto);
        $this->pedido_total_produto = ($cart->total_produtos);
        if (isset($_SESSION['cupom']['alfa'])) {
            if ($_SESSION['cupom']['tp_desconto'] == 1) {
                $cart->valor_desconto_cupom = (($cart->total_compra / 100) * $_SESSION['cupom']['desconto']);
            } else {
                $cart->valor_desconto_cupom = $this->_moneyUS($_SESSION['cupom']['real']);
            }
        }
        $motivo_desconto = "";
        $this->total_descontos = 0;

        if ($_SESSION['metodo_pagamento'] == 'boleto') {
            #UPDATE: aplicar regra para pegar porcentagem do banco
            //valor desconto % boleto
            $desconto_boleto = intval($this->payConfig->_pay['PagSeguro']->pay_fator_juros);
            if ($desconto_boleto > 0) {
                $cart->valor_desconto = (($cart->total_compra / 100) * $desconto_boleto);
                $motivo_desconto = "Boleto: -" . $this->_money($cart->valor_desconto);

                $this->total_descontos = $cart->valor_desconto;
                if (isset($cart->valor_desconto_cupom)) {
                    $alfa = $_SESSION['cupom']['alfa'];
                    $motivo_desconto .= "<br />";
                    $motivo_desconto .= "Cupom ($alfa): -" . $this->_money($cart->valor_desconto_cupom);
                    $this->total_descontos = $cart->valor_desconto + $cart->valor_desconto_cupom;
                }
                $this->pedido_cupom_info = $motivo_desconto;
                $this->pedido_cupom_desconto = $this->total_descontos;
                $this->total_com_desconto = ($cart->total_compra - $this->total_descontos) + $cart->valor_frete;
                $this->pedido_total_frete = $this->total_com_desconto;
                $cart->total_sem_desconto = $cart->total_compra + $cart->valor_frete;
            }
        }
        //insere pedido
        $f = array(
            'pedido_cliente',
            'pedido_data',
            'pedido_total_produto',
            'pedido_total_frete',
            'pedido_frete',
            'pedido_prazo',
            'pedido_entrega',
            'pedido_endereco',
            'pedido_cupom_desconto',
            'pedido_cupom_alfa',
            'pedido_cupom_info',
            'pedido_status'
        );
        $v = array(
            $this->cliente_id,
            date('d/m/Y H:i'),
            $this->_moneyUS($cart->total_compra),
            $this->_moneyUS($this->pedido_total_frete),
            $this->_moneyUS($this->valor_frete),
            "$this->prazo_frete",
            "$this->pedido_entrega",
            "$this->pedido_endereco",
            $this->_moneyUS($this->pedido_cupom_desconto),
            "$this->pedido_cupom_alfa",
            "$this->pedido_cupom_info",
            1
        );
        $this->insert('pedido')->fields($f)->values($v)->execute();
        $this->pedido_id = $this->objBanco->lastId();
        $_SESSION['FLUX_PEDIDO_ID'] = $this->pedido_id;

        $this->itens_da_fatura = "";
        $itens = $_SESSION['cart'];
        sort($itens);
        foreach ($itens as $item) {
            $i = (object)$item;
            $i->item_preco = number_format($i->item_preco, 2, '.', '');
            $i->item_title = str_replace("'", "\'", $i->item_title);
            $f = array('lista_pedido', 'lista_item', 'lista_preco', 'lista_title', 'lista_qtde', 'lista_foto', 'lista_atributos', 'lista_atributo_ped');
            $v = array("$this->pedido_id", "$i->item_id", "$i->item_preco", "$i->item_title", "$i->item_qtde", "$i->item_foto", "$i->atributos", "$i->atributo_ped");
            $this->insert('lista')->fields($f)->values($v)->execute();
            //baixa nos atributos
            if (isset($i->atributos) && !empty($i->atributos)) {
                $i->atributos = preg_replace('/\"/', '', $i->atributos);
                $attrs = explode("|", $i->atributos);
                foreach ($attrs as $attr) {
                    $attr = preg_replace('/\"/', '', $attr);
                    $attr = explode(",", $attr);
                    if (count($attr) >= 2) {
                        $iattr_id = explode("|", $attr[3]);
                        $iattr_id = $iattr_id[0];
                        $iattr_atributo = $attr[2];
                        $cond = "relatrr_atributo = '$iattr_atributo' AND relatrr_iattr = '$iattr_id' AND relatrr_item  = '$i->item_id'";
                        $this->decrement('relatrr', 'relatrr_qtde', $i->item_qtde, "$cond");
                    }
                }
            }
            //baixa no estoque
            $this->decrement('item', 'item_estoque', $i->item_qtde, "item_id = $i->item_id");
            $i->item_qtde_preco = $i->item_qtde * $i->item_preco;
            $this->itens_da_fatura .= "Item: $i->item_title $i->atributo_ped <br/> Qtde: $i->item_qtde <br />Valor: R$ $i->item_preco <br/>  <br />";
        }
        $this->local_entrega = (string)$_SESSION['finaliza-entrega']['entrega_selecionada_desc'];


        $config_pgto = $this->payConfig->_pay['Config']->pay_key;
        if (isset($_SESSION['metodo_pagamento']) && !empty($_SESSION['metodo_pagamento'])) {

            if ($_SESSION['metodo_pagamento'] == 'credito') {
                if ($config_pgto == 'mercadoPago') {
                    self::incluirFaturaMercadoPago();
                } else {
                    self::incluirFaturaPagSeguroTransp();
                }
            }
            if ($_SESSION['metodo_pagamento'] == 'deposito') {
                self::incluirFaturaDeposito();
            }
            if ($_SESSION['metodo_pagamento'] == 'boleto') {
                if ($config_pgto == 'mercadoPago') {
                    self::incluirFaturaBoletoMercadoPago();
                } else {
                    self::incluirFaturaBoletoPagSeguro();
                }
            }
        } else {
            $this->redirect("$this->baseUri/finalizar/");
        }
    }

    public function incluirFaturaDeposito()
    {
        $this->select()->from('pay')->where('pay_name = "Deposito"')->execute();
        $this->map($this->data[0]);
        $this->pay_texto = nl2br($this->pay_texto);
        if ($this->pedido_id >= 1) {
            $this->select()
                ->from('cliente')
                ->join('endereco', 'endereco_cliente = cliente_id', 'INNER')
                ->where("cliente_id = $this->cliente_id and endereco_tipo = 1")
                ->execute();
            $this->encode('endereco_uf', 'strtoupper');
            $this->map($this->data[0]);
            $this->cliente_telefone = preg_replace('/\W/', '', $this->cliente_telefone);
            $this->cliente_ddd = substr($this->cliente_telefone, 0, 2);
            $this->cliente_telefone = substr($this->cliente_telefone, 2, -1);
            $this->select()
                ->from('pedido')
                ->where("pedido_cliente = $this->cliente_id AND pedido_id = $this->pedido_id")
                ->execute();
            if ($this->result()) {
                $this->map($this->data[0]);
                //atualiza cupom
                if ($this->pedido_cupom_desconto != 0) {
                    $this->pedido_cupom_desconto = $this->_moneyUS($this->pedido_cupom_desconto);
                    //Atualiza cupom como usado
                    $this->cupom_update = date('d/m/Y H:i:s');
                    $this->cupom_alfa = $_SESSION['cupom']['alfa'];
                    $f = array('cupom_status', 'cupom_pedido', 'cupom_update');
                    $v = array(1, $this->pedido_id, $this->cupom_update);
                    $this->update('cupom')->set($f, $v)->where("cupom_alfa = '$this->cupom_alfa'")->execute();
                }
                if ($this->pedido_frete <= 0) {
                    $this->pedido_frete = "0.00";
                    $this->valor_frete = "0.00";
                }

                $this->valor_total_formatado = (($this->pedido_total_produto - $this->pedido_cupom_desconto) + $this->valor_frete);
                $this->valor_frete_formatado = $this->valor_frete;

                $this->update('pedido')
                    ->set(array('pedido_pay_code', 'pedido_pay_url', 'pedido_pay_gw'), array('deposito', '', 4))
                    ->where("pedido_id = $this->pedido_id")
                    ->execute();
                $this->notificarAdmin();
                $this->notificarFaturaCliente();
                $this->clear();
                $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
            }
        }
    }

    /*PAGSEGURO*/
    public function pagseguro_get_env($env)
    {
        require_once 'pay-pagseguro.php';
        return _pagseguro_get_env($env);
    }

    public function pagseguro_get_session($email = "suporte@lojamodelo.com.br", $token = "57BE455F4EC148E5A54D9BB91C5AC12C", $__ENV = 'SANDBOX')
    {
        require_once 'pay-pagseguro.php';
        return _pagseguro_get_session($email, $token, $__ENV);
    }

    public function incluirFaturaPagSeguroTransp()
    {
        require_once 'pay-pagseguro-c.php';
    }

    public function incluirFaturaBoletoPagSeguro()
    {
        require_once 'pay-pagseguro-b.php';
    }

    /*END PAGSEGURO*/

    /* MERCADO PAGO */
    public function incluirFaturaBoletoMercadoPago()
    {
        $this->select()->from('pay')->where('pay_name = "Deposito"')->execute();
        $this->map($this->data[0]);
        $this->pay_texto = nl2br($this->pay_texto);
        if ($this->pedido_id >= 1) {
            $this->select()
                ->from('cliente')
                ->join('endereco', 'endereco_cliente = cliente_id', 'INNER')
                ->where("cliente_id = $this->cliente_id and endereco_tipo = 1")
                ->execute();
            $this->encode('endereco_uf', 'strtoupper');
            $this->map($this->data[0]);
            $dados_cliente_mp = $this->data[0];
            $this->cliente_telefone = preg_replace('/\W/', '', $this->cliente_telefone);
            $this->cliente_ddd = substr($this->cliente_telefone, 0, 2);
            $this->cliente_telefone = substr($this->cliente_telefone, 2, -1);
            $cliente_email = $this->cliente_email;
            $this->select()
                ->from('pedido')
                ->where("pedido_cliente = $this->cliente_id AND pedido_id = $this->pedido_id")
                ->execute();
            if ($this->result()) {
                $this->map($this->data[0]);
                //atualiza cupom
                if ($this->pedido_cupom_desconto != 0) {
                    $this->pedido_cupom_desconto = $this->_moneyUS($this->pedido_cupom_desconto);
                    //Atualiza cupom como usado
                    $this->cupom_update = date('d/m/Y H:i:s');
                    $this->cupom_alfa = $_SESSION['cupom']['alfa'];
                    $f = array('cupom_status', 'cupom_pedido', 'cupom_update');
                    $v = array(1, $this->pedido_id, $this->cupom_update);
                    $this->update('cupom')->set($f, $v)->where("cupom_alfa = '$this->cupom_alfa'")->execute();
                }
                if ($this->pedido_frete <= 0) {
                    $this->pedido_frete = "0.00";
                    $this->valor_frete = "0.00";
                }
                $this->valor_total_formatado = (($this->pedido_total_produto - $this->pedido_cupom_desconto) + $this->valor_frete);
                $this->valor_frete_formatado = $this->valor_frete;

                // MERCADO PAGO
                $this->select()->from('pay')->where('pay_name = "MercadoPago"')->execute();
                if (isset($this->data[0]) && !empty($this->data[0])) {
                    $_mpago = $this->data[0];
                    require_once 'pay-mercadopago.php';
                    $payment = faturaMPBoleto($_mpago, $this);
                    if (isset($payment->error)) {
                        $this->update('pedido')
                            ->set(['pedido_status', 'pedido_pay_url', 'pedido_pay_gw', 'pedido_total_frete'], [7, $this->baseUri, 5, $this->valor_frete_formatado])
                            ->where("pedido_id = $this->pedido_id")
                            ->execute();
                        if (isset($_SESSION['cart'])) {
                            unset($_SESSION['cart']);
                        }
                        $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/?$payment->error");
                    } else {
                        $id_transacao = $payment->payer->id;
                        $pay_url = $payment->transaction_details->external_resource_url;
                        $this->update('pedido')
                            ->set(array('pedido_pay_code', 'pedido_pay_url', 'pedido_pay_gw'), array($id_transacao, $pay_url, 5))
                            ->where("pedido_id = $this->pedido_id")
                            ->execute();
                        $this->notificarAdmin();
                        $this->notificarFaturaCliente();
                        $this->clear();
                        $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
                    }

                } else {
                    $this->redirect("$this->baseUri/finalizar/");
                }
            }
        }
    }

    public function incluirFaturaMercadoPago()
    {

        if ($this->pedido_id >= 1) {
            $this->select()
                ->from('cliente')
                ->join('endereco', 'endereco_cliente = cliente_id', 'INNER')
                ->where("cliente_id = $this->cliente_id and endereco_tipo = 1")
                ->execute();
            $this->encode('endereco_uf', 'strtoupper');
            $this->map($this->data[0]);
            $dados_cliente_mp = $this->data[0];
            $this->cliente_telefone = preg_replace('/\W/', '', $this->cliente_telefone);
            $this->cliente_ddd = substr($this->cliente_telefone, 0, 2);
            $this->cliente_telefone = substr($this->cliente_telefone, 2, -1);
            $cliente_email = $this->cliente_email;

            // MERCADO PAGO
            $this->select()->from('pay')->where('pay_name = "MercadoPago"')->execute();
            if (isset($this->data[0]) && !empty($this->data[0])) {
                $_mpago = $this->data[0];
                require_once 'pay-mercadopago.php';
                $payment = faturaMP($_mpago, $this);

                if (isset($payment->error)) {
                    self::pre($payment);
                    exit;
                    $valor_com_juros = (isset($payment->transaction_details->total_paid_amount)) ? $payment->transaction_details->total_paid_amount : $payment->transaction_amount;
                    $this->update('pedido')
                        ->set(['pedido_status', 'pedido_total_parcelado', 'pedido_obs'], [7, $valor_com_juros, 'Pagamento não autorizado pela administradora do cartão!'])
                        ->where("pedido_id = $this->pedido_id")
                        ->execute();
                    $this->clear();
                    $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
                } else {
                    $id_transacao = $payment->payer->id;
                    $valor_com_juros = $payment->transaction_details->total_paid_amount;
                    $this->update('pedido')
                        ->set(['pedido_pay_code', 'pedido_pay_gw', 'pedido_total_parcelado'], [$id_transacao, 1, $valor_com_juros])
                        ->where("pedido_id = $this->pedido_id")
                        ->execute();
                    $this->notificarAdmin();
                    $this->notificarFaturaCliente();
                    $this->clear();
                    $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
                }
            } else {
                $this->redirect("$this->baseUri/finalizar/");
            }

        }
    }

    /* END MERCADO PAGO */

    public function notificarAdmin()
    {
        $body = '<html><body>';
        $body .= '<h1 style="font-size:15px;">Novo Pedido Criado</h1>';
        $body .= '<table style="border-color: #666; font-size:11px" cellpadding="10">';
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Pedido ID:</strong> </td><td style="color:#333">' . $this->pedido_id . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Data:</strong> </td><td>' . date('d/m/Y h:s') . '</td></tr>';
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Cliente:</strong> </td><td style="color:#333">' . ($this->cliente_fullnome) . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Email:</strong> </td><td style="color:#333">' . $this->cliente_email . '</td></tr>';
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Local de entrega:</strong> </td><td style="color:#333">' . ($this->local_entrega) . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Itens:</strong> </td><td>' . ($this->itens_da_fatura) . '</td></tr>';
        if ($this->pedido_cupom_desconto != 0) {
            $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Desconto:</strong> </td><td style="color:#333"> -' . $this->_money($this->pedido_cupom_desconto) . '</td></tr>';
            $body .= '<tr style="background: #eee;"><td><strong>Subtotal:</strong> </td><td>' . $this->_money($this->pedido_total_produto - $this->pedido_cupom_desconto) . '</td></tr>';
        }
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Frete:</strong> '
            . '</td><td style="color:#333">' . $this->_money($this->pedido_frete) .
            ' - ' . ($this->prazo_frete) . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Valor Total:</strong> </td><td>' . $this->_money($this->pedido_total_frete) . '</td></tr>';
        $body .= '</table>';
        $body .= '</body></html>';
        $n = array(
            'subject' => utf8_decode("Novo Pedido Nº $this->pedido_id"),
            'body' => utf8_decode($body)
        );
        require_once 'sendmail.php';
        $m = new sendmail;
        $m->sender($n);
    }

    public function notificarFaturaCliente()
    {
        $body = '<html><body>';
        $body .= ('<h1 style="font-size:15px;">Olá ' . $this->cliente_nome . ', recebemos seu pedido nº ' . $this->pedido_id . '</h1>');
        $body .= '<table style="border-color: #666; font-size:11px" cellpadding="10">';
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Pedido ID:</strong> </td><td style="color:#333">' . $this->pedido_id . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Data:</strong> </td><td>' . date('d/m/Y h:s') . '</td></tr>';
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Cliente:</strong> </td><td style="color:#333">' . ($this->cliente_nome) . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Email:</strong> </td><td style="color:#333">' . $this->cliente_email . '</td></tr>';
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Local de entrega:</strong> </td><td style="color:#333">' . ($this->local_entrega) . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Itens:</strong> </td><td>' . ($this->itens_da_fatura) . '</td></tr>';
        if ($this->pedido_cupom_desconto != 0) {
            $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Desconto:</strong> </td><td style="color:#333"> -' . $this->_money($this->pedido_cupom_desconto) . '</td></tr>';
            $body .= '<tr style="background: #eee;"><td><strong>Subtotal:</strong> </td><td>' . $this->_money($this->pedido_total_produto - $this->pedido_cupom_desconto) . '</td></tr>';
        }
        $body .= '<tr style="background: #fff;"><td style="color:#333"><strong>Frete:</strong> '
            . '</td><td style="color:#333">' . $this->_money($this->pedido_frete) .
            ' - ' . ($this->prazo_frete) . '</td></tr>';
        $body .= '<tr style="background: #eee;"><td><strong>Valor Total:</strong> </td><td>' . $this->_money($this->pedido_total_frete) . '</td></tr>';
        $body .= '<br/><br/>';
        $body .= "<a href=\"$this->baseUri/cliente/pedido/$this->pedido_id/\">Acompanhe o status de seu pedido em nosso site.</a>";
        $body .= '</body></html>';

        $n = array(
            'email' => $this->cliente_email,
            'subject' => utf8_decode("Detalhes do pedido #$this->pedido_id"),
            'body' => utf8_decode($body)
        );
        require_once 'sendmail.php';
        $m = new sendmail;
        $m->sender($n);
    }

    public function clear()
    {
        if (isset($_SESSION['cart'])) {
            $_SESSION['cart'] = null;
            unset($_SESSION['cart']);
            $this->assign('mybasket', 'icon-basket');
            $this->assign('qtdeItem', '0');
        }
        unset($_SESSION['mycep_prazo']);
        unset($_SESSION['mycep_frete']);
        unset($_SESSION['mycep_entrega']);
        unset($_SESSION['mycep']);
        unset($_SESSION['referer']);
        unset($_SESSION['cart']);
        unset($_SESSION['finaliza-entrega']);
        unset($_SESSION['FLUX_PEDIDO_ID']);
        unset($_SESSION['cupom']);
    }

    public function novoendereco()
    {
        $_SESSION['referer'] = "$this->baseUri/finalizar/entrega/";
        $this->redirect("$this->baseUri/cliente/enderecoNovo/");
    }

    public function getClienteAddr()
    {
        $this->select()
            ->from('endereco')
            ->where("endereco_cliente = $this->cliente_id")
            ->orderby('endereco_title asc')
            ->execute();
        if ($this->result()) {
            $this->fetch('addr', $this->data);
        }
    }

    public function getClienteAddrOne($cliente_id)
    {
        $this->select()
            ->from('endereco')
            ->where("endereco_cliente = $cliente_id")
            ->orderby('endereco_id asc')
            ->execute();
        if ($this->result()) {
            return (object)$this->data[0];
        }
    }

    public function getRetiradaAddr()
    {
        $this->select()
            ->from('retirada')
            ->orderby('retirada_local asc')
            ->execute();
        if ($this->result()) {
            foreach ($this->data as $k => $v) {
                if (strlen($this->data[$k]['retirada_complemento']) >= 2) {
                    $this->data[$k]['retirada_num'] = $this->data[$k]['retirada_num'] . ", " . $this->data[$k]['retirada_complemento'];
                }
            }
            $this->fetch('raddr', $this->data);
        } else {
            $this->assign('evt_onload', 'ocultaRetirada()');
        }
    }

    public function getMenu()
    {
        $this->menu = new Menu;
        $menu = $this->menu->getAll();
        $this->fetch('cat', $menu[0]);
        $this->fetch('f', $this->menu->getFooter());
    }

    public function getItens()
    {
        $cart = new Carrinho;
        $cart->getTotal();
        if (isset($_SESSION['cart'])) {
            $this->qtde_item = count($_SESSION['cart']);
            if ($this->qtde_item <= 0) {
                $this->redirect("$this->baseUri/carrinho/");
            }
        } else {
            $this->redirect("$this->baseUri/carrinho/");
        }
    }

    public function getCarrinho()
    {
        $cart = new Carrinho;
        $cart->getTotal();
        if (count($_SESSION['cart']) <= 0) {
            $this->redirect("$this->baseUri/carrinho/");
        }
        $this->data = $_SESSION['cart'];
        $this->money('item_preco');
        $this->money('valor_total');
        $this->money('item_valor_original');
        $this->cut('item_title', 75, '...');
        $this->fetch('cart', $this->data);

        $cart->total_sem_desconto = $cart->valor_total;
        if (isset($_SESSION['mycep_frete'])) {
            $frete_valor = (string)$_SESSION['mycep_frete'];
            $frete_prazo = (string)$_SESSION['mycep_prazo'];
            $this->assign('valor_frete', $frete_valor);
            $this->assign('valor_prazo', $frete_prazo);
        }
        $this->total_compra = $cart->valor_total;

        if (isset($_SESSION['cupom']['alfa'])) {
            if ($_SESSION['cupom']['tp_desconto'] == 1) {
                $cart->valor_desconto_cupom = (($cart->total_compra / 100) * $_SESSION['cupom']['desconto']);
            } else {
                $cart->valor_desconto_cupom = $this->_moneyUS($_SESSION['cupom']['real']);
            }
        }
        $motivo_desconto = "";
        $this->total_descontos = 0;
        $cart->valor_desconto = 0;
        if ($_SESSION['finaliza-pagamento'] == 'boleto') {
            #UPDATE: aplicar regra para pegar porcentagem do banco
            $cart->valor_desconto = (($cart->total_compra / 100) * $this->payConfig->_pay['Boleto']->pay_fator_juros);
            $motivo_desconto = "Boleto: -" . $this->_money($cart->valor_desconto);
            $this->total_descontos = $cart->valor_desconto;
        }
        if (isset($cart->valor_desconto_cupom)) {
            $motivo_desconto .= "<br />";
            $motivo_desconto .= "Cupom: -" . $this->_money($cart->valor_desconto_cupom);
            $this->total_descontos = $cart->valor_desconto + $cart->valor_desconto_cupom;
        }
        $cart->total_com_desconto = ($cart->total_compra - $this->total_descontos) + $frete_valor;
        $cart->total_sem_desconto = $cart->total_compra + $frete_valor;
        $this->total_com_desconto = $cart->total_com_desconto;
        $this->total_com_frete = $cart->total_com_frete;

        $this->assign('desconto_motivo', $motivo_desconto);
        $this->assign('cartTotal', $this->total_compra);
        $this->assign('total_sem_desconto', $this->_money($cart->total_sem_desconto));
        $this->assign('total_com_desconto', $this->_money($cart->total_com_desconto));
        $this->assign('valor_desconto', $this->_money($cart->valor_desconto));
        $this->assign('total_com_frete', $this->_money($cart->total_com_frete));
        $this->assign('cupom_desconto_info', $cart->cupom_desconto_info);
        $this->assign('cupom_msg', $cart->cupom_msg);
        $this->assign('total_produtos', $this->_money($cart->total_compra));
        if ($cart->valor_desconto_cupom > 1) {
            $this->assign('valor_total', $this->_money($cart->valor_total));
            $this->assign('desconto_ext', $cart->cupom_desconto_ext);
            $this->assign('btn-cupom-valida', 'hide');
            $this->assign('btn-cupom-remove', '');
        } else {
            $this->assign('btn-cupom-remove', 'hide');
        }
    }

    public function val2bd($str)
    {
        $str = preg_replace('/\./', '', $str);
        $str = preg_replace('/\,/', '', $str);
        return $str;
    }

    public function _money($val)
    {
        return @number_format($val, 2, ",", ".");
    }

    public function _moneyUS($val)
    {
        return @number_format($val, 2, ".", "");
    }

    public function _double($val)
    {
        return @number_format($val, 2, ".", ",");
    }

    public function _float($val)
    {
        return @number_format($this->val2bd($val), 2, ",", "");
    }
}
/*end file*/