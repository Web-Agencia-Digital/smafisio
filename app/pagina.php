<?php

class Pagina extends PHPFrodo {

    public $config = array();
    public $page_url;

    public function __construct() {
        parent:: __construct();
        $sid = new Session;
        $sid->start();
        if ($sid->check() && $sid->getNode('cliente_id') >= 1) {
            $this->cliente_email = (string) $sid->getNode('cliente_email');
            $this->cliente_id = (string) $sid->getNode('cliente_id');
            $this->cliente_nome = (string) $sid->getNode('cliente_nome');
            $this->cliente_fullnome = (string) $sid->getNode('cliente_fullnome');
            $this->assign('cliente_nome', $this->cliente_nome);
            $this->assign('cliente_email', $this->cliente_email);
            $this->assign('cliente_msg', 'acesse aqui sua conta.');
            $this->assign('logged', 'true');
        } else {
            $this->assign('cliente_nome', 'visitante');
            $this->assign('cliente_msg', 'faça seu login ou cadastre-se.');
            $this->assign('logged', 'false');
        }
        $qtdeITem = 0;
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) >= 1) {
            $qtdeITem = count($_SESSION['cart']);
            $cart = new Carrinho;
            $cart->getTotal();
            $cart->total_compra = @number_format($cart->total_compra, 2, ",", ".");
            $this->assign('cartTotal', "R$ " . $cart->total_compra);
        }
        $this->assign('qtdeItem', $qtdeITem);

        $this->select()
                ->from('config')
                ->execute();
        if ($this->result()) {
            $this->config = (object) $this->data[0];
            $this->assignAll();
        }

        $this->select()
                ->from('social')
                ->execute();
        if ($this->result()) {
            $this->social = (object) $this->data[0];
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
                $this->assign('social_insta', str_replace('@','',$this->social->social_in));
            }             
            if ($this->config->config_site_cnpj == "") {
                $this->assign('cnpjSH', 'hide');
            }
            $this->assignAll();
        }
    }

    public function welcome() {
        $this->tpl('public/pagina.html');
        $this->page_url = $this->uri_segment[1];
        $this->select()->from('page')->where("page_url = '$this->page_url'")->execute();
        if ($this->result()) {
            $this->data[0]['page_content'] = stripslashes($this->data[0]['page_content']);
            $this->getMenu();
            $this->assignAll();
            $this->render();
        } else {
            $this->redirect("$this->baseUri/");
        }
    }

    public function getMenu() {
        $this->menu = new Menu;
        $menu = $this->menu->getAll();
        $this->fetch('cat', $menu[0]);
        if (!$this->check_agent('mobile')) {
            //$this->fetch('cat', $menu[0]);
        } else {
            //$this->fetch('depto', $menu[1]);
        }
        $this->fetch('f', $this->menu->getFooter());
    }

}

/*end file*/
