<?php

class Index extends PHPFrodo
{
    public $config = array();
    public $menu;
    public $condition;
    public $condition_order_by = 'item_categoria desc, item_id desc';
    public $page_active = null;
    public $categoria_title;
    public $paginate_default = 12;
    public $sub_title;
    public $sid;
    public $payConfig;
    public $message_bar = "";
    public function __construct()
    {
        parent::__construct();
        $this->sid = new Session;
        $this->sid->start();
        if ($this->sid->check() && $this->sid->getNode('cliente_id') >= 1) {
            $this->cliente_email = (string)$this->sid->getNode('cliente_email');
            $this->cliente_id = (string)$this->sid->getNode('cliente_id');
            $this->cliente_nome = (string)$this->sid->getNode('cliente_nome');
            $this->cliente_fullnome = (string)$this->sid->getNode('cliente_fullnome');
            $this->assign('cliente_nome', $this->cliente_nome);
            $this->assign('cliente_email', $this->cliente_email);
            $this->assign('cliente_msg', 'acesse aqui sua conta.');
            $this->assign('logged', 'true');
        } else {
            $this->assign('cliente_nome', 'visitante');
            $this->assign('cliente_msg', 'faça seu login ou cadastre-se.');
            $this->assign('logged', 'false');
        }
        $this->select()
            ->from('config')
            ->execute();
        if ($this->result()) {
            $this->config = (object)$this->data[0];
            $this->sid->addNode('config_site_menu', $this->config->config_site_menu);
            if ($this->config->config_site_cnpj == "") {
                $this->assign('cnpjSH', 'hide');
            }
            $this->assignAll();
        }
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
            if ($this->social->social_in != "") {
                $this->assign('social_insta', str_replace('@', '', $this->social->social_in));
            }
            if ($this->config->config_site_cnpj == "") {
                $this->assign('cnpjSH', 'hide');
            }
            $this->assignAll();
        }
        //get all config site
        $this->select()
            ->from('frete')
            ->execute();
        if ($this->result()) {
            $this->config_frete = (object)$this->data[0];
            if ($this->config_frete->frete_apt > 0) {
                $this->assign('frete_apt', $this->_money($this->config_frete->frete_apt));
                $this->assign('frete_sul', $this->_money($this->config_frete->frete_sul));
            } else {
                $this->assign('show_freteg', 'hide');
            }
        }
        //initial condition for home itens
        $this->condition = 'item_show = 1 AND item_estoque >= 0 AND item_destaque = 0';
        $this->message_bar = "Produtos em Destaque";
        //get current category
        $this->getActiveCategory();
        //mostra meios de pagamento no rodape
        $this->payConfig = new Pay;
        if ($this->payConfig->_pay['PagSeguro']->pay_status == 1) {
            $this->assign('parc_num_info', $this->payConfig->_pay['PagSeguro']->pay_c1);
        } else {
            $this->assign('parc_num_info', 12);
            $this->assign('show_cielo', 'hide');
        }
        $desc_boleto = "";
        $show_desc_boleto = 'hide';
        //Troca Boleto Padrão por Boleto PagSeguro
        if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
            $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
        }
        if ($this->payConfig->_pay['Boleto']->pay_status == 1) {
            $desc_boleto = $this->payConfig->_pay['Boleto']->pay_fator_juros;
            $show_desc_boleto = '';
        }
        if($desc_boleto > 0){
            $desc_text = '<br><small>(' . $desc_boleto . '% de desconto)</small>';
            $this->assign('desconto_boleto_text', $desc_text);
        }else{
            $this->assign('desconto_boleto_text', '');
        }
        $this->assign('desconto_boleto', $desc_boleto);
        $this->assign('show_desc_boleto', $show_desc_boleto);
        $r = new Route;
        $r->set("HOME");
    }
    public function fillProdutos()
    {
        $this->action_reload = "";
        $this->select()
            ->from('item')
            ->join('sub', 'item_sub = sub_id', 'LEFT')
            ->join('categoria', 'item_categoria = categoria_id', 'INNER')
            ->join('relatrr', 'relatrr_item = item_id', 'LEFT')
            ->join('foto', 'foto_item = item_id and foto.foto_pos = ( SELECT MIN( foto_pos ) FROM foto where foto_item = item_id)', 'LEFT')
            ->where($this->condition)
            ->paginate($this->paginate_default)
            ->groupby('item_id')
            ->orderby("$this->condition_order_by")
            ->execute();
        if ($this->result()) {
            $this->categoria_title = $this->data[0]['categoria_title'];
            $this->categoria_url = $this->data[0]['categoria_url'];
            $this->sub_title = $this->data[0]['sub_title'];
            $this->sub_url = $this->data[0]['sub_url'];
            $data = $this->data;
            $preco_min = 5;
            $preco_max = 10;
            $preco_max_last = 0;
            $preco_min_last = $data[0]['item_preco'];
            foreach ($data as $k => $v) {
                //one click carrinho
                $data[$k]['one-click-to-cart'] = ($data[$k]['relatrr_item'] > 0) ? 'go-to-cart' : 'one-click-to-cart';
                if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                    $data[$k]['one-click-to-cart'] = 'hide';
                }
                //desconto
                $item_desconto = $data[$k]['item_desconto'];
                if ($item_desconto > 1) {
                    $data[$k]['item_valor_original'] = $data[$k]['item_preco'];
                    $data[$k]['item_preco'] = ($data[$k]['item_preco'] - $data[$k]['item_desconto']);
                    $data[$k]['item_valor_original'] = $this->_money($data[$k]['item_valor_original']);
                    $data[$k]['showHide'] = "";
                } else {
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['showHide'] = "hide";
                }
                //parcelamento
                $item_parc = $data[$k]['item_parc'];

                $item_parc = $this->payConfig->_pay['PagSeguro']->pay_c1; //parcelamento mod pagseguro
                $data[$k]['item_valor_parc'] = "";

                if ($item_parc == 1) {
                    $item_parc = $this->payConfig->_pay['PagSeguro']->pay_c6;
                }

                if ($item_parc >= 2) {
                    $parcela = preg_replace('/\./', ',', $this->payConfig->parcelamentoTabela($data[$k]['item_preco'], $item_parc));
                    $parcela_final = explode("<span class='b-vezes'>", $parcela);
                    $data[$k]['item_valor_parc'] = preg_replace('/\<br\>/', '', $parcela_final[count($parcela_final) - 1]);
                }
                //valor minimo
                if ($data[$k]['item_preco'] >= $preco_max_last) {
                    $preco_max = $data[$k]['item_preco'];
                    $preco_max_last = $preco_max;
                }
                //valor maximo
                if ($data[$k]['item_preco'] <= $preco_min_last) {
                    $preco_min = $data[$k]['item_preco'];
                    $preco_min_last = $preco_min;
                }
                //frete gratis
                $data[$k]['item_frete_free'] = 'hide';
                if ($data[$k]['item_calcula_frete'] == 1) {
                    $data[$k]['item_frete_free'] = 'show';
                }
                $data[$k]['item_valor_sem_mask'] = $data[$k]['item_preco'];
                if ($data[$k]['foto_url'] == "" || strlen($data[$k]['foto_url']) <= 1) {
                    $data[$k]['foto_url'] = 'nopic.jpg';
                }
                if ($data[$k]['sub_url'] == "" || strlen($data[$k]['sub_url']) <= 1) {
                    $data[$k]['sub_url'] = 'geral';
                }
                $data[$k]['item_short_title'] = $data[$k]['item_title'];
                $data[$k]['item_format_preco'] = $data[$k]['item_preco'];
                if ($data[$k]['item_estoque'] <= 0) {
                    $data[$k]['showHide'] = "hide";
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['item_valor_parc'] = "";
                    $data[$k]['item_preco'] = "Indisponível";
                    $data[$k]['show_preco_avista'] = "hide";
                    $data[$k]['one-click-to-cart'] = 'hide';
                } else {
                    if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                        $data[$k]['item_preco'] = "Sob consulta";
                        $data[$k]['show_preco_avista'] = "hide";
                        $data[$k]['item_valor_parc'] = '';
                    } else {
                        //Troca Boleto Padrão por Boleto PagSeguro
                        if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
                            $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                        }
                        //valor desconto % boleto
                        if ($this->payConfig->_pay['Boleto']->pay_status == 1) {
                            $desconto_boleto = $this->payConfig->_pay['Boleto']->pay_fator_juros;

                            if($desconto_boleto > 0){
                                $desc_text = '<br><small>(' . $desconto_boleto . '% de desconto)</small>';
                                $this->assign('desconto_boleto_text', $desc_text);
                            }else{
                                $this->assign('desconto_boleto_text', '');
                            }

                            $data[$k]['item_avista'] = $data[$k]['item_preco'] - (($data[$k]['item_preco'] / 100) * $desconto_boleto);
                            $data[$k]['item_avista'] = number_format($data[$k]['item_avista'], 2, ',', '.');
                            if ($this->config->config_modo == 3) {
                                $data[$k]['item_avista'] = "";
                                $data[$k]['show_preco_avista'] = 'hide';
                            }
                        } else {
                            $data[$k]['show_preco_avista'] = 'hide';
                            $this->assign('show_desc_boleto', 'hide');
                        }
                        $data[$k]['item_preco'] = "R$ " . $this->_money($data[$k]['item_preco']);
                    }
                }
                if ($this->config->config_modo == 3) {
                    $data[$k]['item_valor_original'] = 'hide';
                    $data[$k]['item_valor_parc'] = '';
                    $data[$k]['item_frete_free'] = 'hide';
                    $data[$k]['show_preco_avista'] = 'hide';
                    $data[$k]['one-click-to-cart'] = 'hide';
                    $data[$k]['item_desconto'] = 'hide';
                    $data[$k]['item_valor_sem_mask'] = 'hide';
                    $data[$k]['item_preco'] = '';
                    $data[$k]['showHide'] = 'hide';
                    $data[$k]['item_oferta'] = 0;
                }
            }
            $this->data = $data;
            $this->cut('item_short_title', 80, '...');
            $this->fetch('i', $this->data);
            //valor min e max | show hide mostrar mais
            $this->assign('preco_max', $preco_max);
            $this->assign('preco_min', $preco_min);
            if ($this->page_active != null) {
                if (isset($preco_max) && isset($preco_min)) {
                    $preco_max = round($preco_max);
                    $preco_min = round($preco_min);
                    $this->action_reload .= " setRangePreco($preco_min,$preco_max);";
                }
            }
        } else {
            $this->assign('message_default', '<h5> &nbsp; Desculpe, nenhum produto foi encontrado!</h5>');
            $this->action_reload .= " $('#elm-filtro-range-preco').hide();";
        }
    }
    public function welcome()
    {
        $this->tpl_page = "public/index.html";
        if ($this->page_active != null) {
            $this->tpl_page = "public/index_sem_slide.html";
        }
        if (in_array('categoria', $this->uri_segment)) {
            $this->paginate_default = 9;
        }
        $this->tpl($this->tpl_page);
        $is_mobile = 'false';
        if ($this->check_agent('mobile')) {
            $is_mobile = 'true';
        }
        $this->assign('is_mobile', $is_mobile);
        //slideshow
        if ($this->page_active == null) {
            $this->fillSlideShow();
            $this->fillBannerTopoMeio();
            $this->fillBannerMeio();
            $this->fillBannerPromocao();
        }
        $this->getCarrinho();
        $this->action_reload = '';
        if (isset($this->config->config_site_prodhome) && $this->config->config_site_prodhome == 1) {
            $this->fillProdutos();
        }
        if ($this->numrows < $this->paginate_default) {
            $this->action_reload .= "hideShowBtnMore(1);";
        } else {
            $this->action_reload .= "hideShowBtnMore(2);";
        }
        $this->assign('action_on_load', $this->action_reload);
        //menu left e footer
        $this->getMenu();
        //titulo bar
        $this->getTitleBar();
        //depoimentos
        if (isset($this->config->config_site_depoimento) && $this->config->config_site_depoimento == 1) {
            $this->fillDepoimento();
        }
        //ofertas
        $this->FillOfertas();
        //destaques ordem pos
        $this->FillDestaque();
        $this->render();
        $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
    }
    public function getLoadParams()
    {
        if (in_array('categoria', $this->uri_segment)) {
            $this->paginate_default = 9;
            if (isset($this->uri_segment[2])) {
                $categoria = $this->uri_segment[2];
                $this->condition = "categoria_url = '$categoria' ";
                if (isset($this->uri_segment[3])) {
                    $sub = $this->uri_segment[3];
                    if (isset($sub) && $sub != 'page' && $sub != 'categoria') {
                        $this->condition .= "AND sub_url = '$sub'";
                    }
                }
                $this->condition .= "  AND item_show = 1";
                $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
                $this->loadMore();
            }
        }
        if (in_array('promocoes', $this->uri_segment)) {
            $this->condition = 'item_show = 1 and item_oferta = 1 and item_estoque >= 1';
            $this->page_active = 'promocoes';
            $this->pagebase = "$this->baseUri/index/getLoadParams/promocoes";
            $this->assign('currentUri', $this->pagebase);
            $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
            $this->loadMore();
        }
        if (in_array('busca', $this->uri_segment)) {
            $this->pagebase = "$this->baseUri/index/getLoadParams/busca";
            $this->loadMore();
        }
    }
    public function loadMore($home = 0)
    {
        if (isset($_SESSION['FLUX_BUSCA_COND']) && !empty($_SESSION['FLUX_BUSCA_COND'])) {
            $this->condition = $_SESSION['FLUX_BUSCA_COND'];
            $this->pagebase = "$this->baseUri/index/getLoadParams/busca";
        }
        if ($home == 0) {
            $this->tpl('public/itens_load.html');
        } else {
            $this->tpl('public/itens_load_home.html');
        }
        if (isset($_POST['loadmore_home']) && $_POST['loadmore_home'] >= 1) {
            $this->tpl('public/itens_load_home.html');
        }
        $this->select()
            ->from('item')
            ->join('sub', 'item_sub = sub_id', 'LEFT')
            ->join('categoria', 'item_categoria = categoria_id', 'INNER')
            ->join('relatrr', 'relatrr_item = item_id', 'LEFT')
            ->join('foto', 'foto_item = item_id and foto.foto_pos = ( SELECT MIN( foto_pos ) FROM foto where foto_item = item_id)', 'LEFT')
            ->where($this->condition)
            ->paginate($this->paginate_default)
            ->groupby('item_id')
            ->orderby("$this->condition_order_by")
            ->execute();
        if ($this->result()) {
            $this->categoria_title = $this->data[0]['categoria_title'];
            $this->categoria_url = $this->data[0]['categoria_url'];
            $this->sub_title = $this->data[0]['sub_title'];
            $this->sub_url = $this->data[0]['sub_url'];
            $data = $this->data;
            $preco_min = 0;
            $preco_max = 0;
            $preco_max_last = 0;
            $preco_min_last = $data[0]['item_preco'];
            foreach ($data as $k => $v) {
                //one click carrinho
                $data[$k]['one-click-to-cart'] = ($data[$k]['relatrr_item'] > 0) ? 'go-to-cart' : 'one-click-to-cart';
                //desconto
                $item_desconto = $data[$k]['item_desconto'];
                if ($item_desconto > 1) {
                    $data[$k]['item_valor_original'] = $data[$k]['item_preco'];
                    $data[$k]['item_preco'] = ($data[$k]['item_preco'] - $data[$k]['item_desconto']);
                    $data[$k]['item_valor_original'] = $this->_money($data[$k]['item_valor_original']);
                    $data[$k]['showHide'] = "";
                } else {
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['showHide'] = "hide";
                }
                //parcelamento
                $item_parc = $data[$k]['item_parc'];
                $item_parc = $this->payConfig->_pay['PagSeguro']->pay_c1; //parcelamento mod pagseguro
                $data[$k]['item_valor_parc'] = "";
                if ($item_parc >= 2) {
                    $parcela = $this->payConfig->parcelamentoTabela($data[$k]['item_preco'], $item_parc);
                    $parcela_final = explode("<span class='b-vezes'>", $parcela);
                    $data[$k]['item_valor_parc'] = preg_replace('/\<br\>/', '', $parcela_final[count($parcela_final) - 1]);
                }
                //valor minimo
                if ($data[$k]['item_preco'] >= $preco_max_last) {
                    $preco_max = $data[$k]['item_preco'];
                    $preco_max_last = $preco_max;
                }
                //valor maximo
                if ($data[$k]['item_preco'] <= $preco_min_last) {
                    $preco_min = $data[$k]['item_preco'];
                    $preco_min_last = $preco_min;
                }
                //frete gratis
                $data[$k]['item_frete_free'] = 'hide';
                if ($data[$k]['item_calcula_frete'] == 1) {
                    $data[$k]['item_frete_free'] = 'show';
                }
                $data[$k]['item_valor_sem_mask'] = $data[$k]['item_preco'];
                if ($data[$k]['foto_url'] == "" || strlen($data[$k]['foto_url']) <= 1) {
                    $data[$k]['foto_url'] = 'nopic.jpg';
                }
                if ($data[$k]['sub_url'] == "" || strlen($data[$k]['sub_url']) <= 1) {
                    $data[$k]['sub_url'] = 'geral';
                }
                $data[$k]['item_short_title'] = $data[$k]['item_title'];
                $data[$k]['item_format_preco'] = $data[$k]['item_preco'];

                if ($data[$k]['item_estoque'] <= 0) {
                    $data[$k]['showHide'] = "hide";
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['item_valor_parc'] = "";
                    $data[$k]['item_preco'] = "Indisponível";
                    $data[$k]['show_preco_avista'] = "hide";
                } else {
                    if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                        $data[$k]['item_preco'] = "Sob consulta";
                        $data[$k]['show_preco_avista'] = "hide";

                        $data[$k]['item_valor_parc'] = '';
                    } else {
                        //Troca Boleto Padrão por Boleto PagSeguro
                        if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
                            $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                        }
                        //valor desconto % boleto
                        if ($this->payConfig->_pay['Boleto']->pay_status == 1) {
                            $desconto_boleto = $this->payConfig->_pay['Boleto']->pay_fator_juros;

                            if($desconto_boleto > 0){
                                $desc_text = '<br><small>(' . $desconto_boleto . '% de desconto)</small>';
                                $this->assign('desconto_boleto_text', $desc_text);
                            }else{
                                $this->assign('desconto_boleto_text', '');
                            }

                            $data[$k]['item_avista'] = $data[$k]['item_preco'] - (($data[$k]['item_preco'] / 100) * $desconto_boleto);
                            $data[$k]['item_avista'] = number_format($data[$k]['item_avista'], 2, ',', '.');
                        } else {
                            $data[$k]['show_preco_avista'] = 'hide';
                            $this->assign('show_desc_boleto', 'hide');
                        }
                        $data[$k]['item_preco'] = "R$ " . $this->_money($data[$k]['item_preco']);
                    }
                }
            }
            $this->data = $data;
            $this->cut('item_short_title', 80, '...');
            $this->fetch('i', $this->data);
            $this->assign('preco_max', $preco_max);
            $this->assign('preco_min', $preco_min);
            $this->action_reload = '';
            if ($this->numrows < $this->paginate_default) {
                $this->action_reload .= "hideShowBtnMore(1);";
            } else {
                $this->action_reload .= "hideShowBtnMore(2);";
            }
            if ($this->page_active != null) {
                $preco_max = round($preco_max);
                $preco_min = round($preco_min);
                if (!in_array('no-range', $this->uri_segment)) {
                    $this->action_reload .= " setRangePreco($preco_min,$preco_max);";
                }
            }
            $this->assign('action_on_reload', $this->action_reload);
            $this->render();
        } else {
            echo -1;
        }
    }
    public function promocoes()
    {
        $this->message_bar = "Promoções e Ofertas";
        $this->condition = 'item_show = 1 and item_oferta = 1 and item_estoque >= 1';
        $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
        $this->page_active = 'promocoes';
        $this->pagebase = "$this->baseUri/index/getLoadParams/promocoes";
        $this->assign('currentUri', $this->pagebase);
        $this->config->config_site_prodhome = 1;
        $this->welcome();
    }
    public function ordenar()
    {
        if (isset($_SESSION['FLUX_BUSCA_COND']) && !empty($_SESSION['FLUX_BUSCA_COND'])) {
            $this->condition = $_SESSION['FLUX_BUSCA_COND'];
        }
        $order = '';
        if (isset($this->uri_segment[2])) {
            $order = $this->uri_segment[2];
        }
        $home = 0;
        switch ($order) {
            case 'menor-preco':
                $this->condition_order_by = 'item_preco asc, item_id desc';
                break;
            case 'maior-preco':
                $this->condition_order_by = 'item_preco desc, item_id desc';
                break;
            case 'mais-vistos':
                $this->condition_order_by = 'item_views desc, item_id desc';
                break;
            case 'mais-novos':
                $this->condition_order_by = 'item_id desc';
                break;
            case 'mais-antigos':
                $this->condition_order_by = 'item_id asc';
                break;
            case 'a-z':
                $this->condition_order_by = 'item_title asc';
                break;
            case 'z-a':
                $this->condition_order_by = 'item_title desc';
                break;
            default:
                $this->condition_order_by = 'item_categoria desc, item_id desc';
                break;
        }
        $this->page_active = 'ordenar';
        $this->pagebase = "$this->baseUri/index/ordenar/$order";
        $this->loadMore($home);
    }
    public function busca()
    {
        $this->pagebase = "$this->baseUri/index/getLoadParams/busca";
        $this->assign('currentUri', $this->pagebase);
        $this->page_active = 'busca';
        if (isset($_POST['busca']) && !empty($_POST['busca'])) {
            $busca = trim(addslashes(strip_tags($_POST['busca'])));
            $this->assign('busca', "$busca");
            $this->term_busca = $busca;
            $this->condition = "item_title like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "item_keywords like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "item_ref like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "categoria_title like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "sub_title like'%$busca%' AND item_show = 1";
            $this->message_bar = "Resultado da busca: $busca";
            $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
            $this->condition_order_by = 'item_preco desc';
        }
        $this->config->config_site_prodhome = 1;
        $this->welcome();
    }
    public function tag()
    {
        $this->pagebase = "$this->baseUri/index/getLoadParams/busca";
        $this->assign('currentUri', $this->pagebase);
        $this->page_active = 'busca';
        //if (isset($_POST['busca']) && !empty($_POST['busca'])) {
        if (isset($this->uri_segment[2])) {
            $busca = addslashes(trim(strip_tags($this->uri_segment[2])));
            $this->assign('busca', "$busca");
            $this->term_busca = $busca;
            //codicao para busca
            $this->condition = "item_title like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "item_keywords like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "item_ref like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "categoria_title like'%$busca%' AND item_show = 1 OR ";
            $this->condition .= "sub_title like'%$busca%' AND item_show = 1";
            $this->message_bar = "Resultado da busca: $busca";
            $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
            $this->condition_order_by = 'item_preco desc';
        }
        $this->config->config_site_prodhome = 1;
        $this->welcome();
    }
    public function categoria()
    {
        if (isset($this->uri_segment[2])) {
            $categoria = $this->uri_segment[2];
            $this->condition = "categoria_url = '$categoria' ";
            $this->pagebase = "$this->baseUri/index/getLoadParams/$categoria/categoria";
            if (isset($this->uri_segment[3])) {
                $sub = $this->uri_segment[3];
                //condicao para categorias
                if (isset($sub) && $sub != 'page') {
                    $this->pagebase = "$this->baseUri/index/getLoadParams/$categoria/$sub/categoria";
                    $this->condition .= "AND sub_url = '$sub'";
                    $this->assign('sub_url', $sub);
                }
            }
            $this->condition .= "  AND item_show = 1";
            $this->page_active = 'categoria';
            $_SESSION['FLUX_BUSCA_COND'] = $this->condition;
            $this->assign('currentUri', $this->pagebase);
            $this->assign('categoria_url', $categoria);
            $this->config->config_site_prodhome = 1;
            $this->welcome();
        }
    }
    public function getTitleBar()
    {
        $rastro = '<ul class="breadcrumb">';
        if ($this->page_active == "categoria") {
            $this->message_bar = "$this->categoria_title";
            if (isset($this->uri_segment[3])) {
                $this->message_bar = "$this->categoria_title / $this->sub_title";
            }
            $rastro .= "<li><a href=\"[baseUri]/index/categoria/$this->categoria_url/\">$this->categoria_title</a> </li>";
            if (isset($this->uri_segment[3])) {
                $rastro .= "<li class=\"active\"><a href=\"[baseUri]/index/categoria/$this->categoria_url/$this->sub_url/\">$this->sub_title</a></li>";
            }
        }
        if ($this->page_active == "busca") {
            (isset($this->term_busca)) ? $busca = $this->term_busca : $busca = '';
            $rastro .= "<li class=\"active\"><a>Você buscou por \"$busca\" e encontramos ($this->numrows_total) produto(s).</a> </li>";
        }
        if ($this->page_active == "promocoes") {
            (isset($this->term_busca)) ? $busca = $this->term_busca : $busca = '';
            $rastro .= "<li class=\"active\"><a>Temos ($this->numrows_total) produto(s) em oferta.</a> </li>";
        }
        $rastro .= '</ul>';
        $this->assign('migalhas-de-pao', $rastro);
        $this->assign('message_bar', $this->message_bar);
    }
    public function getMenu()
    {
        $this->menu = new Menu;
        $menu = $this->menu->getAll();
        $this->fetch('cat', $menu[0]);
        $this->fetch('f', $this->menu->getFooter());
        if ($this->page_active != null) {
            $this->fetch('menu', $menu[1]);
        }
    }
    public function fillDepoimento()
    {
        if ($this->page_active == null) {
            $this->select()
                ->from('depoimento')
                ->orderby('depoimento_id DESC')
                ->execute();
            if ($this->result()) {
                $j = 0;
                foreach ($this->data as $k => $v) {
                    $this->data[$k]['depoimento_key'] = $j++;
                }
                $this->addkey('depoimento_thumb', '', 'depoimento_foto');
                $this->preg(array('/\.jpg/', '/\.png/'), array('', ''), 'depoimento_thumb');
                $this->fetch('licom', $this->data);
                $this->fetch('com', $this->data);
            }
        }
    }
    public function fillSlideShow()
    {
        if ($this->page_active == null) {
            $this->select()
                ->from('slide')
                ->where('slide_local = 1')
                ->orderby('slide_pos asc')
                ->execute();
            if ($this->result()) {
                foreach ($this->data as $k => $v) {
                    $this->data[$k]['slide_cursor'] = '';
                    if ($this->data[$k]['slide_link'] == "" || $this->data[$k]['slide_link'] == "0") {
                        $this->data[$k]['slide_link'] = "javascript:;";
                        $this->data[$k]['slide_cursor'] = 'cursor-default';
                    }
                }
                $this->fetch('sl', $this->data);
            }
        }
    }
    public function fillBannerMeio()
    {
        if ($this->page_active == null) {
            $this->select()
                ->from('slide')
                ->where('slide_local = 2')
                ->orderby('slide_pos asc')
                ->execute();
            if ($this->result()) {
                foreach ($this->data as $k => $v) {
                    $this->data[$k]['slideto'] = "";
                    $this->data[$k]['slide_cursor'] = '';
                    if ($this->data[$k]['slide_link'] == "" || $this->data[$k]['slide_link'] == "0") {
                        $this->data[$k]['slide_link'] = "javascript:;";
                        $this->data[$k]['slide_cursor'] = 'cursor-default';
                    }
                }
                $this->fetch('bl', $this->data);
            }
        }
    }
    public function fillBannerTopoMeio()
    {
        if ($this->page_active == null) {
            $this->select()
                ->from('slide')
                ->where('slide_local = 4')
                ->orderby('slide_pos asc')
                ->execute();
            if ($this->result()) {
                foreach ($this->data as $k => $v) {
                    $this->data[$k]['slideto'] = "";
                    $this->data[$k]['slide_title'] = preg_replace('/\s+/', ' ', $this->data[$k]['slide_title']);
                    $this->data[$k]['slide_desc'] = preg_replace('/\s+/', ' ', $this->data[$k]['slide_desc']);
                    $this->data[$k]['slide_cursor'] = '';
                    if ($this->data[$k]['slide_link'] == "" || $this->data[$k]['slide_link'] == "0") {
                        $this->data[$k]['slide_link'] = "javascript:void(0);";
                        $this->data[$k]['slide_cursor'] = 'style="cursor:default"';
                    } else {
                        $this->data[$k]['slide_link'] = "http://" . $this->data[$k]['slide_link'];
                    }
                    if ($this->data[$k]['slide_target'] == "1") {
                        $this->data[$k]['slide_target'] = "_blank";
                    } else {
                        $this->data[$k]['slide_target'] = "";
                    }
                }
                $this->fetch('blt', $this->data);
            }
        }
    }
    public function fillBannerPromocao()
    {
        if ($this->page_active == null) {
            $this->select()
                ->from('slide')
                ->where('slide_local = 5')
                ->orderby('slide_pos asc')
                ->execute();
            if ($this->result()) {
                foreach ($this->data as $k => $v) {
                    $this->data[$k]['slideto'] = "";
                    //$this->data[$k]['slide_title'] = preg_replace('/\s+/', ' ', $this->data[$k]['slide_title']);
                    //$this->data[$k]['slide_desc'] = preg_replace('/\s+/', ' ', $this->data[$k]['slide_desc']);
                    $this->data[$k]['slide_cursor'] = '';
                    if ($this->data[$k]['slide_link'] == "" || $this->data[$k]['slide_link'] == "0") {
                        $this->data[$k]['slide_link'] = "";
                        $this->data[$k]['slide_cursor'] = 'cursor-default';
                    }else{
                        $this->data[$k]['slide_link'] = "href=\"".$this->data[$k]['slide_link']."\"";
                        $this->data[$k]['slide_cursor'] = 'cursor-pointer';

                    }
                }
                $this->fetch('bp', $this->data);
            }
        }
    }
    public function FillBanner()
    {
        if (isset($this->uri_segment[2])) {
            $local = $this->uri_segment[2];
        }
        $per_page = 5;
        if (isset($this->uri_segment[3])) {
            $per_page = $this->uri_segment[3];
        }
        $this->select()
            ->from('slide')
            ->where("slide_local = $local")
            ->orderby('slide_pos asc')
            ->paginate($per_page)
            ->execute();
        if ($this->result()) {
            $this->encode(null, 'utf8_encode');
            shuffle($this->data);
            echo json_encode($this->data);
        }
    }
    public function FillDestaque()
    {
        $this->select()
            ->from('item')
            ->join('sub', 'item_sub = sub_id', 'LEFT')
            ->join('categoria', 'item_categoria = categoria_id', 'INNER')
            ->join('relatrr', 'relatrr_item = item_id', 'LEFT')
            ->join('foto', 'foto_item = item_id AND foto.foto_pos = ( SELECT MIN( foto_pos ) FROM foto where foto_item = item_id)', 'LEFT')
            ->where('item_show = 1 AND item_estoque >= 1 AND item_destaque = 1')
            //->paginate(16)
            ->groupby('item_id')
            ->orderby("item_pos ASC")
            ->execute();
        if ($this->result()) {
            $this->categoria_title = $this->data[0]['categoria_title'];
            $this->categoria_url = $this->data[0]['categoria_url'];
            $this->sub_title = $this->data[0]['sub_title'];
            $this->sub_url = $this->data[0]['sub_url'];
            $data = $this->data;
            $preco_min = 5;
            $preco_max = 10;
            $preco_max_last = 0;
            $preco_min_last = $data[0]['item_preco'];
            foreach ($data as $k => $v) {
                //one click carrinho
                $data[$k]['one-click-to-cart'] = ($data[$k]['relatrr_item'] > 0) ? 'go-to-cart' : 'one-click-to-cart';
                if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                    $data[$k]['one-click-to-cart'] = 'hide';
                }
                //desconto
                $item_desconto = $data[$k]['item_desconto'];
                if ($item_desconto > 1) {
                    $data[$k]['item_valor_original'] = $data[$k]['item_preco'];
                    $data[$k]['item_preco'] = ($data[$k]['item_preco'] - $data[$k]['item_desconto']);
                    $data[$k]['item_valor_original'] = $this->_money($data[$k]['item_valor_original']);
                    $data[$k]['showHide'] = "";
                } else {
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['showHide'] = "hide";
                }
                //parcelamento
                if ($this->config->config_modo != 3) {
                    $item_parc = $data[$k]['item_parc'];
                    $item_parc = $this->payConfig->_pay['PagSeguro']->pay_c1; //parcelamento mod pagseguro
                    $data[$k]['item_valor_parc'] = "";
                    if ($item_parc >= 2) {
                        $parcela = $this->payConfig->parcelamentoTabela($data[$k]['item_preco'], $item_parc);
                        $parcela_final = explode("<span class='b-vezes'>", $parcela);
                        $data[$k]['item_valor_parc'] = preg_replace('/\<br\>/', '', $parcela_final[count($parcela_final) - 1]);
                    }
                }
                //valor minimo
                if ($data[$k]['item_preco'] >= $preco_max_last) {
                    $preco_max = $data[$k]['item_preco'];
                    $preco_max_last = $preco_max;
                }
                //valor maximo
                if ($data[$k]['item_preco'] <= $preco_min_last) {
                    $preco_min = $data[$k]['item_preco'];
                    $preco_min_last = $preco_min;
                }
                //frete gratis
                $data[$k]['item_frete_free'] = 'hide';
                if ($data[$k]['item_calcula_frete'] == 1) {
                    $data[$k]['item_frete_free'] = 'show';
                }
                $data[$k]['item_valor_sem_mask'] = $data[$k]['item_preco'];
                if ($data[$k]['foto_url'] == "" || strlen($data[$k]['foto_url']) <= 1) {
                    $data[$k]['foto_url'] = 'nopic.jpg';
                }
                if ($data[$k]['sub_url'] == "" || strlen($data[$k]['sub_url']) <= 1) {
                    $data[$k]['sub_url'] = 'geral';
                }
                $data[$k]['item_short_title'] = $data[$k]['item_title'];
                $data[$k]['item_format_preco'] = $data[$k]['item_preco'];

                if ($data[$k]['item_estoque'] <= 0) {
                    $data[$k]['showHide'] = "hide";
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['item_valor_parc'] = "";
                    $data[$k]['item_preco'] = "Indisponível";
                    $data[$k]['show_preco_avista'] = "hide";
                } else {
                    if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                        $data[$k]['item_preco'] = "Sob consulta";
                        $data[$k]['show_preco_avista'] = "hide";

                        $data[$k]['item_valor_parc'] = '';
                    } else {
                        //Troca Boleto Padrão por Boleto PagSeguro
                        if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
                            $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                        }
                        //valor desconto % boleto
                        if ($this->payConfig->_pay['Boleto']->pay_status == 1) {
                            $desconto_boleto = $this->payConfig->_pay['Boleto']->pay_fator_juros;

                            if($desconto_boleto > 0){
                                $desc_text = '<br><small>(' . $desconto_boleto . '% de desconto)</small>';
                                $this->assign('desconto_boleto_text', $desc_text);
                            }else{
                                $this->assign('desconto_boleto_text', '');
                            }

                            $data[$k]['item_avista'] = $data[$k]['item_preco'] - (($data[$k]['item_preco'] / 100) * $desconto_boleto);
                            $data[$k]['item_avista'] = number_format($data[$k]['item_avista'], 2, ',', '.');
                        } else {
                            $data[$k]['show_preco_avista'] = 'hide';
                            $this->assign('show_desc_boleto', 'hide');
                        }
                        $data[$k]['item_preco'] = "R$ " . $this->_money($data[$k]['item_preco']);
                    }
                }
                if ($this->config->config_modo == 3) {
                    $data[$k]['item_valor_original'] = 'hide';
                    $data[$k]['item_valor_parc'] = '';
                    $data[$k]['item_frete_free'] = 'hide';
                    $data[$k]['show_preco_avista'] = 'hide';
                    $data[$k]['one-click-to-cart'] = 'hide';
                    $data[$k]['item_desconto'] = 'hide';
                    $data[$k]['item_valor_sem_mask'] = 'hide';
                    $data[$k]['item_preco'] = '';
                    $data[$k]['showHide'] = 'hide';
                    $data[$k]['item_oferta'] = 0;
                }
            }
            $this->data = $data;
            if (isset($data[0])) {
                $this->cut('item_short_title', 80, '...');
            }
            $this->fetch('dtk', $this->data);
        }
    }
    public function FillOfertas()
    {
        $this->select()
            ->from('item')
            ->join('sub', 'item_sub = sub_id', 'LEFT')
            ->join('categoria', 'item_categoria = categoria_id', 'INNER')
            ->join('relatrr', 'relatrr_item = item_id', 'LEFT')
            ->join('foto', 'foto_item = item_id AND foto.foto_pos = ( SELECT MIN( foto_pos ) FROM foto where foto_item = item_id)', 'LEFT')
            ->where('item_show = 1 AND item_estoque >= 1 AND item_oferta = 1')
            ->paginate(16)
            ->groupby('item_id')
            ->execute();
        if ($this->result()) {
            $this->categoria_title = $this->data[0]['categoria_title'];
            $this->categoria_url = $this->data[0]['categoria_url'];
            $this->sub_title = $this->data[0]['sub_title'];
            $this->sub_url = $this->data[0]['sub_url'];
            $data = $this->data;
            $preco_min = 5;
            $preco_max = 10;
            $preco_max_last = 0;
            $preco_min_last = $data[0]['item_preco'];
            foreach ($data as $k => $v) {
                //one click carrinho
                $data[$k]['one-click-to-cart'] = ($data[$k]['relatrr_item'] > 0) ? 'go-to-cart' : 'one-click-to-cart';
                if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                    $data[$k]['one-click-to-cart'] = 'hide';
                }
                //desconto
                $item_desconto = $data[$k]['item_desconto'];
                if ($item_desconto > 1) {
                    $data[$k]['item_valor_original'] = $data[$k]['item_preco'];
                    $data[$k]['item_preco'] = ($data[$k]['item_preco'] - $data[$k]['item_desconto']);
                    $data[$k]['item_valor_original'] = $this->_money($data[$k]['item_valor_original']);
                    $data[$k]['showHide'] = "";
                } else {
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['showHide'] = "hide";
                }
                //parcelamento
                $item_parc = $data[$k]['item_parc'];
                $item_parc = $this->payConfig->_pay['PagSeguro']->pay_c1; //parcelamento mod pagseguro
                $data[$k]['item_valor_parc'] = "";
                if ($item_parc >= 2) {
                    $parcela = $this->payConfig->parcelamentoTabela($data[$k]['item_preco'], $item_parc);
                    $parcela_final = explode("<span class='b-vezes'>", $parcela);
                    $data[$k]['item_valor_parc'] = preg_replace('/\<br\>/', '', $parcela_final[count($parcela_final) - 1]);
                }
                //valor minimo
                if ($data[$k]['item_preco'] >= $preco_max_last) {
                    $preco_max = $data[$k]['item_preco'];
                    $preco_max_last = $preco_max;
                }
                //valor maximo
                if ($data[$k]['item_preco'] <= $preco_min_last) {
                    $preco_min = $data[$k]['item_preco'];
                    $preco_min_last = $preco_min;
                }
                //frete gratis
                $data[$k]['item_frete_free'] = 'hide';
                if ($data[$k]['item_calcula_frete'] == 1) {
                    $data[$k]['item_frete_free'] = 'show';
                }
                $data[$k]['item_valor_sem_mask'] = $data[$k]['item_preco'];
                if ($data[$k]['foto_url'] == "" || strlen($data[$k]['foto_url']) <= 1) {
                    $data[$k]['foto_url'] = 'nopic.jpg';
                }
                if ($data[$k]['sub_url'] == "" || strlen($data[$k]['sub_url']) <= 1) {
                    $data[$k]['sub_url'] = 'geral';
                }
                $data[$k]['item_short_title'] = $data[$k]['item_title'];
                $data[$k]['item_format_preco'] = $data[$k]['item_preco'];
                if ($data[$k]['item_estoque'] <= 0) {
                    $data[$k]['showHide'] = "hide";
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['item_valor_parc'] = "";
                    $data[$k]['item_preco'] = "Indisponível";
                    $data[$k]['show_preco_avista'] = "hide";
                } else {
                    if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                        $data[$k]['item_preco'] = "Sob consulta";
                        $data[$k]['show_preco_avista'] = "hide";
                        
                        $data[$k]['item_valor_parc'] = '';
                    } else {
                        //Troca Boleto Padrão por Boleto PagSeguro
                        if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
                            $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                        }
                        //valor desconto % boleto
                        if ($this->payConfig->_pay['Boleto']->pay_status == 1) {
                            $desconto_boleto = $this->payConfig->_pay['Boleto']->pay_fator_juros;

                            if($desconto_boleto > 0){
                                $desc_text = '<br><small>(' . $desconto_boleto . '% de desconto)</small>';
                                $this->assign('desconto_boleto_text', $desc_text);
                            }else{
                                $this->assign('desconto_boleto_text', '');
                            }

                            $data[$k]['item_avista'] = $data[$k]['item_preco'] - (($data[$k]['item_preco'] / 100) * $desconto_boleto);
                            $data[$k]['item_avista'] = number_format($data[$k]['item_avista'], 2, ',', '.');
                        } else {
                            $data[$k]['show_preco_avista'] = 'hide';
                            $this->assign('show_desc_boleto', 'hide');
                        }
                        $data[$k]['item_preco'] = "R$ " . $this->_money($data[$k]['item_preco']);
                    }
                }
                if ($this->config->config_modo == 3) {
                    $data[$k]['item_valor_original'] = 'hide';
                    $data[$k]['item_valor_parc'] = '';
                    $data[$k]['item_frete_free'] = 'hide';
                    $data[$k]['show_preco_avista'] = 'hide';
                    $data[$k]['one-click-to-cart'] = 'hide';
                    $data[$k]['item_desconto'] = 'hide';
                    $data[$k]['item_valor_sem_mask'] = 'hide';
                    $data[$k]['item_preco'] = '';
                    $data[$k]['showHide'] = 'hide';
                    $data[$k]['item_oferta'] = 0;
                }
            }
            $this->data = $data;
            if (isset($data[0])) {
                $this->cut('item_short_title', 80, '...');
                shuffle($this->data);
            }
            $this->fetch('oft', $this->data);
        }
    }
    public function FillMaisNovosVistos()
    {
        $this->order_by = 'item_views desc';
        $this->select()
            ->from('item')
            ->join('sub', 'item_sub = sub_id', 'LEFT')
            ->join('categoria', 'item_categoria = categoria_id', 'INNER')
            ->join('foto', 'foto_item = item_id and foto.foto_pos = ( SELECT MIN( foto_pos ) FROM foto where foto_item = item_id)', 'LEFT')
            ->where('item_show = 1 and item_estoque >= 1')
            ->paginate(12)
            ->groupby('item_id')
            ->orderby("$this->order_by")
            ->execute();
        if ($this->result()) {
            $this->categoria_title = $this->data[0]['categoria_title'];
            $this->categoria_url = $this->data[0]['categoria_url'];
            $this->sub_title = $this->data[0]['sub_title'];
            $this->sub_url = $this->data[0]['sub_url'];
            $data = $this->data;
            $preco_min = 5;
            $preco_max = 10;
            $preco_max_last = 0;
            $preco_min_last = $data[0]['item_preco'];
            foreach ($data as $k => $v) {
                //desconto
                $item_desconto = $data[$k]['item_desconto'];
                if ($item_desconto > 1) {
                    $data[$k]['item_valor_original'] = $data[$k]['item_preco'];
                    $data[$k]['item_preco'] = ($data[$k]['item_preco'] - $data[$k]['item_desconto']);
                    $data[$k]['item_valor_original'] = $this->_money($data[$k]['item_valor_original']);
                    $data[$k]['showHide'] = "";
                } else {
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['showHide'] = "hide";
                }
                //parcelamento
                $item_parc = $data[$k]['item_parc'];
                $item_parc = $this->payConfig->_pay['PagSeguro']->pay_c1; //parcelamento mod pagseguro
                $data[$k]['item_valor_parc'] = "";
                if ($item_parc >= 2) {
                    $parcela = $this->payConfig->parcelamentoTabela($data[$k]['item_preco'], $item_parc);
                    $parcela_final = explode("<span class='b-vezes'>", $parcela);
                    $data[$k]['item_valor_parc'] = preg_replace('/\<br\>/', '', $parcela_final[count($parcela_final) - 1]);
                }
                //valor minimo
                if ($data[$k]['item_preco'] >= $preco_max_last) {
                    $preco_max = $data[$k]['item_preco'];
                    $preco_max_last = $preco_max;
                }
                //valor maximo
                if ($data[$k]['item_preco'] <= $preco_min_last) {
                    $preco_min = $data[$k]['item_preco'];
                    $preco_min_last = $preco_min;
                }
                //frete gratis
                $data[$k]['item_frete_free'] = 'hide';
                if ($data[$k]['item_calcula_frete'] == 1) {
                    $data[$k]['item_frete_free'] = 'show';
                }
                $data[$k]['item_valor_sem_mask'] = $data[$k]['item_preco'];
                if ($data[$k]['foto_url'] == "" || strlen($data[$k]['foto_url']) <= 1) {
                    $data[$k]['foto_url'] = 'nopic.jpg';
                }
                if ($data[$k]['sub_url'] == "" || strlen($data[$k]['sub_url']) <= 1) {
                    $data[$k]['sub_url'] = 'geral';
                }
                $data[$k]['item_short_title'] = $data[$k]['item_title'];
                $data[$k]['item_format_preco'] = $data[$k]['item_preco'];

                if ($data[$k]['item_estoque'] <= 0) {
                    $data[$k]['showHide'] = "hide";
                    $data[$k]['item_valor_original'] = "";
                    $data[$k]['item_valor_parc'] = "";
                    $data[$k]['item_preco'] = "Indisponível";
                    $data[$k]['show_preco_avista'] = "hide";
                } else {
                    if ($data[$k]['item_preco'] == '0,00' || $data[$k]['item_preco'] <= 0) {
                        $data[$k]['item_preco'] = "Sob consulta";
                        $data[$k]['show_preco_avista'] = "hide"; 
                        $data[$k]['item_valor_parc'] = '';
                    } else {
                        //Troca Boleto Padrão por Boleto PagSeguro
                        if ($this->payConfig->_pay['PagSeguro']->pay_c3 == 1 && $this->payConfig->_pay['Boleto']->pay_status == 0) {
                            $this->payConfig->_pay['Boleto'] = $this->payConfig->_pay['PagSeguro'];
                        }
                        //valor desconto % boleto
                        if ($this->payConfig->_pay['Boleto']->pay_status == 1) {
                            $desconto_boleto = $this->payConfig->_pay['Boleto']->pay_fator_juros;

                            if($desconto_boleto > 0){
                                $desc_text = '<br><small>(' . $desconto_boleto . '% de desconto)</small>';
                                $this->assign('desconto_boleto_text', $desc_text);
                            }else{
                                $this->assign('desconto_boleto_text', '');
                            }

                            $data[$k]['item_avista'] = $data[$k]['item_preco'] - (($data[$k]['item_preco'] / 100) * $desconto_boleto);
                            $data[$k]['item_avista'] = number_format($data[$k]['item_avista'], 2, ',', '.');
                        } else {
                            $data[$k]['show_preco_avista'] = 'hide';
                            $this->assign('show_desc_boleto', 'hide');
                        }
                        $data[$k]['item_preco'] = "R$ " . $this->_money($data[$k]['item_preco']);
                    }
                }

                if ($this->config->config_modo == 3) {
                    $data[$k]['item_valor_original'] = 'hide';
                    $data[$k]['item_valor_parc'] = '';
                    $data[$k]['item_frete_free'] = 'hide';
                    $data[$k]['show_preco_avista'] = 'hide';
                    $data[$k]['one-click-to-cart'] = 'hide';
                    $data[$k]['item_desconto'] = 'hide';
                    $data[$k]['item_valor_sem_mask'] = 'hide';
                    $data[$k]['item_preco'] = '';
                    $data[$k]['showHide'] = 'hide';
                    $data[$k]['item_oferta'] = 0;
                }
            }
            $this->data = $data;
            shuffle($this->data);
            $this->cut('item_short_title', 35, '...');
            echo json_encode($this->data);
        }
    }
    public function getActiveCategory()
    {
        if (isset($this->uri_segment) && in_array('categoria', $this->uri_segment)) {
            $categoria = $this->uri_segment[2];
            $sub = "";
            if (isset($this->uri_segment[3])) {
                $sub = $this->uri_segment[3];
            }
            $this->assign('sub_active', $sub);
            $this->assign('cat_active', $categoria);
        }
    }
    public function getCarrinho()
    {
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) >= 1) {
            $cart = new Carrinho;
            $this->data = $_SESSION['cart'];
            $cart->getTotal();
            $this->money('item_preco');
            $this->cut('item_title', 20, '...');
            $this->assign('qtdeItem', count($this->data));
            $this->assign('cartTotal', "R$ " . $this->_money($cart->valor_total));
            $this->fetch('cart', $this->data);
        } else {
            $this->assign('cartTotal', "O carrinho est? vazio! ;(");
            $this->assign('carrinhoVazio', "hide");
        }
    }
    public function _money($val)
    {
        return @number_format($val, 2, ",", ".");
    }
    public function _2thumb($url)
    {
        return preg_replace(array('/\.jpg/', '/\.png/', '/\.gif/'), array('', '', ''), $url);
    }
    public function news_add()
    {
        if ($this->postIsValid(array('news_email' => 'string'))) {
            $this->postValueChange('news_nome', ucfirst(addslashes($this->postGetValue('news_nome'))));
            $this->postValueChange('news_email', strtolower(addslashes($this->postGetValue('news_email'))));
            $mail = $this->postGetValue('news_email');
            $this->select()->from('news')->where("news_email = '$mail'")->execute();
            if (!$this->result()) {
                echo '0';
                $this->insert('news')->fields()->values()->execute();
            } else {
                echo '1';
            }
        }
    }
    public function reload_top_cart()
    {
        $btn = "<i class=\"fa fa-shopping-cart fa-3x\"></i> <br /> Carrinho ";
        $btn2 = "<i class=\"fa fa-shopping-cart\" style=\"font-size: 18px !important\"></i> ";
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) >= 1) {
            $cart = new Carrinho;
            //$this->data = $_SESSION['cart'];
            $cart->getTotal();
            $btn .= "(" . count($_SESSION['cart']) . ")";
            $btn2 .= "(" . count($_SESSION['cart']) . ")";
            $btn .= '<br>R$<span id="total-carrinho-top"> ' . number_format($_SESSION['__TOTAL__COMPRA__'], 2, ',', '.');
            $btn .= '</span>';
        }
        echo json_encode(array('lg' => $btn, 'sm' => $btn2));
    }
    public function reload_top_compara()
    {
        $btn = "<i class=\"fa fa-exchange fa-3x\"></i> <br /> Compare ";
        $btn2 = "<i class=\"fa fa-exchange\" style=\"font-size: 18px !important\"></i> ";
        if (isset($_SESSION['compara']) && count($_SESSION['compara']) >= 1) {
            $btn .= "(" . count($_SESSION['compara']) . ")";
            $btn2 .= "(" . count($_SESSION['compara']) . ")";
            $btn .= '</span>';
        }
        echo json_encode(array('lg' => $btn, 'sm' => $btn2));
    }
}
/*end file*/