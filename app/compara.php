<?php

class Compara extends PHPFrodo
{

    public $config = array();
    public $config_cep = array();
    public $menu;
    public $item_categoria = null;
    public $item_sub = null;
    public $item_url = null;
    public $item_id = null;
    public $item_title = '';
    public $nota = '';
    public $item = null;
    public $f_foto = null;
    public $f_foto_big = null;
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
        } else {
            $this->assign('cliente_nome', 'visitante');
            $this->assign('cliente_msg', 'fa?a seu login ou cadastre-se.');
            $this->assign('logged', 'false');
        }
        $this->select()
            ->from('config')
            ->execute();
        if ($this->result()) {
            $this->config = (object)$this->data[0];
            $this->assignAll();
        }
        if (isset($this->uri_segment[1]) && isset($this->uri_segment[2]) && isset($this->uri_segment[3]) && isset($this->uri_segment[4])) {
            $this->item_categoria = $this->uri_segment[1];
            $this->item_sub = $this->uri_segment[2];
            $this->item_url = $this->uri_segment[3];
            $this->item_id = $this->uri_segment[4];
        }
//mostra meios de pagamento no rodape
        $this->payConfig = new Pay;
        $this->view_prepend_data = $this->payConfig->getPaysOn();

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
            if ($this->config->config_site_cnpj == "") {
                $this->assign('cnpjSH', 'hide');
            }
            $this->assignAll();
        }
    }

    public function getMenu()
    {
        $this->menu = new Menu;
        $menu = $this->menu->getAll();
        if (!$this->check_agent('mobile')) {
            $this->fetch('cat', $menu[0]);
        } else {
            $this->fetch('depto', $menu[1]);
        }
        $this->fetch('f', $this->menu->getFooter());
    }

    public function welcome()
    {

        if (isset($_SESSION['compara'])) {
            $this->tpl('public/compare.html');
            $this->getMenu();
            $ids = implode(",", $_SESSION['compara']);
            $this->item_id = $ids;

            $this->select()->from('item')
                ->join('foto', 'foto_item = item_id AND foto.foto_pos = ( SELECT MIN( foto_pos ) FROM foto where foto_item = item_id)', 'LEFT')
                ->where("item_id IN ($ids)")->groupby('item_id')
                ->execute();
            if ($this->result()) {

                $data_aux = $this->data;
                $x = [];
                foreach ($data_aux as $k => $v) {
                    $current_id = $data_aux[$k]['item_id'];

                    if ($data_aux[$k]['foto_url'] == "" || strlen($data_aux[$k]['foto_url']) <= 1) {
                        $data_aux[$k]['foto_url'] = 'nopic.jpg';
                    }

                    $this->query = "SELECT atributo_id, atributo_nome
                                        FROM iattr
                                        LEFT JOIN atributo ON atributo_id = iattr_atributo
                                        WHERE iattr_id
                                        IN (SELECT relatrr_iattr FROM relatrr 
                                        WHERE relatrr_item  = $current_id ) GROUP BY atributo_id;
                                        ";
                    $this->execute();
                    $data_aux[$k]['att'] = $this->data;

                    $data_z = $this->data;
                    foreach ($data_z as $j => $l) {
                        $current_atributo =$data_z[$j]['atributo_id'];
                        $this->query = "SELECT iattr_nome FROM iattr
                                        LEFT JOIN atributo ON atributo_id = iattr_atributo
                                        WHERE iattr_id
                                        IN (SELECT relatrr_iattr FROM relatrr 
                                        WHERE relatrr_item  = $current_id 
                                        AND relatrr_atributo = $current_atributo) GROUP BY atributo_id;";
                        $this->execute();

                        $str = "";
                        foreach($this->data as $x => $y){
                            $at_nome =  $data_z[$j]['atributo_nome'];
                            if($at_nome == 'Cores') {
                                $str .= "\"" . $y['iattr_nome'] . "\"" . ",";
                            }else{
                                $str .=  $y['iattr_nome'] .  ",";
                            }
                        }
                        $str = substr($str, 0,-1);

                        $data_aux[$k]['att'][$j]['opt'] = $str;
                    }
                    $x["$current_id"] =  $this->data;
                }

                $this->data = $data_aux;


                $this->money('item_preco');
                $this->fetch('preco', $this->data);
                $this->fetch('desc', $this->data);
                $this->fetch('item', $this->data);
                $this->assignAll();
            }
            $this->render();
        }
        else{
            $this->redirect("$this->baseUri/");
        }
    }

    public function addCompara()
    {

        if (!isset($_SESSION["compara"])) {
            $_SESSION['compara'] = array();
        }

        if (!in_array($_POST['item_id'], $_SESSION['compara']) && (sizeof($_SESSION['compara']) < 3)) {
            array_push($_SESSION['compara'], intval($_POST['item_id']));
        }
        self::welcome();
    }

    public function addComparaIndex()
    {

        if (!isset($_SESSION["compara"])) {
            $_SESSION['compara'] = array();
        }

        if (!in_array($_POST['item_id'], $_SESSION['compara']) && (sizeof($_SESSION['compara']) < 3)) {
            array_push($_SESSION['compara'], intval($_POST['item_id']));
        }
    }

    public function removeComparacoes()
    {
        if (isset($_SESSION['compara'])) {
            unset($_SESSION['compara']);
        }
    }

    public function removeComparacao()
    {
        if (isset($_SESSION['compara'])) {
            $item = $_POST['item_id'];
            $key = array_search($item, $_SESSION['compara']);
            unset ($_SESSION['compara'][$key]);
            if (count($_SESSION['compara']) != 0){
                self::welcome();
            }else{
                unset($_SESSION['compara']);
                $this->redirect("$this->baseUri/");
            }
        }
    }
}
/* end file */
