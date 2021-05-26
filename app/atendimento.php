<?php

class Atendimento extends PHPFrodo {

    public $config = array();
    public $smtp = array();
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
            $this->getCliente();
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

        $this->select()->from('smtp')->execute();
        if ($this->result()) {
            $this->assignAll();
            $this->smtp = (object) $this->data[0];
        }
    }

    public function welcome() {
        $this->tpl('public/atendimento.html');

        if (isset($this->uri_segment) && in_array('enviado', $this->uri_segment)) {
            $this->assign('msg_onload', 'messageOk()');
        }
        if (isset($this->uri_segment) && in_array('nao-enviado', $this->uri_segment)) {
            $this->assign('msg_onload', 'messageError()');
        }
        $this->getMenu();
        //redes sociais footer
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

        if (isset($_SESSION['FLUX_SOB_CONSULTA'])) {
            $flux_sob_consulta = $_SESSION['FLUX_SOB_CONSULTA'];
            $this->assign('sob_consulta_msg', "Olá, gostaria de receber mais informações sobre: " . $flux_sob_consulta);
            $this->assign('sob_consulta_assunto', $flux_sob_consulta);
        }
        $this->render();
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

    public function enviar() {
        $nome = strip_tags($_POST['nome']);
        $email = strip_tags($_POST['email']);
        $assunto = strip_tags($_POST['assunto']);
        $text = strip_tags($_POST['mensagem']);
        $fone = strip_tags($_POST['telefone']);
        $mensagem = '<html><body>';
        $mensagem .= '<h1 style="font-size:15px;">Atendimento ' . $assunto . '</h1>';
        $mensagem .= '<table style="border-color: #666; font-size:11px" cellpadding="10">';
        $mensagem .= '<tr style="background: #eee;"><td><strong>Nome:</strong> </td><td>' . $nome . '</td></tr>';
        $mensagem .= '<tr style="background: #fff;"><td><strong>Email:</strong> </td><td>' . $email . '</td></tr>';
        $mensagem .= '<tr style="background: #eee;"><td><strong>Telefone:</strong> </td><td>' . $fone . '</td></tr>';
        $mensagem .= '<tr style="background: #fff;"><td><strong>Mensagem:</strong> </td><td>' . nl2br($text) . '</td></tr>';
        $mensagem .= '</table>';
        $mensagem .= '</body></html>';

        $n = array(
            'subject' => utf8_decode("$assunto"),
            'body' => $mensagem
        );
        $m = new sendmail;
        if ($m->sender($n)) {
            $this->redirect("$this->baseUri/atendimento/enviado/");
        } else {
            $this->redirect("$this->baseUri/atendimento/nao-enviado/");
        }
    }

    public function getCliente() {
        $this->select()
                ->from('cliente')
                ->where("cliente_id = $this->cliente_id")
                ->execute();
        if ($this->result()) {
            $this->map($this->data[0]);
            $this->config = (object) $this->data[0];
            $this->assignAll();
        }
    }

}

/*end file*/
