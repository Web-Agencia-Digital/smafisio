<?php

class Cliente extends PHPFrodo {

    public $login = null;
    public $user_login;
    public $user_id;
    public $user_name;
    public $user_level;
    public $cliente_id;
    public $cliente_cpf;
    public $cliente_nome;
    public $cliente_email;
    public $status_pat = array('/1/', '/2/', '/3/', '/4/', '/5/', '/6/', '/7/');
    public $status_rep = array('Aguardando pagamento', 'Em análise', 'Aprovado', 'Disponível', 'Em disputa', 'Devolvida', 'Cancelada');
    public $status_rep_icon = array('away.png', 'away.png', 'on.png', 'on.png', 'away.png', 'busy.png', 'busy.png');

    public function __construct() {
        parent::__construct();
        $sid = new Session;
        $sid->start();
        if (!$sid->check() || $sid->getNode('user_id') <= 0) {
            $this->redirect("$this->baseUri/admin/login/logout/");
            exit;
        }
        $this->select()
                ->from('config')
                ->execute();
        if ($this->result()) {
            $this->config = (object) $this->data[0];
            $this->assignAll();
        }
        $this->user_login = $sid->getNode('user_login');
        $this->user_id = $sid->getNode('user_id');
        $this->user_name = $sid->getNode('user_name');
        $this->user_level = (int) $sid->getNode('user_level');
        $this->assign('user_name', $this->user_name);
        if ($this->user_level == 1) {
            $this->assign('showhide', 'hide');
        }
    }

    public function welcome() {
        $this->pagebase = "$this->baseUri/admin/cliente";
        $this->tpl('admin/cliente.html');
        $this->select()
                ->from('cliente')
                ->join('endereco', 'cliente_id = endereco_cliente', 'INNER')
                ->where('endereco_tipo = 1')
                ->paginate(25)
                ->orderby('cliente_nome asc')
                ->execute();
        if ($this->result()) {
            $this->fetch('cl', $this->data);
            $this->assign('item_qtde', $this->getTotalCliente());
        }
        $this->render();
    }

    public function getTotalCliente() {
        $this->select()->from('cliente')->execute();
        if ($this->result()) {
            return count($this->data);
        } else {
            return 0;
        }
    }

    public function editar() {
        if (isset($this->uri_segment[2])) {
            $this->cliente_id = $this->uri_segment[2];
            $this->tpl('admin/cliente_editar.html');

            $this->select()
                    ->from('cliente')
                    ->where("cliente_id = $this->cliente_id")
                    ->execute();
            $this->assignAll();


            $this->select()
                    ->from('endereco')
                    ->where("endereco_cliente = $this->cliente_id")
                    ->execute();
            $this->fetch('addr', $this->data);

            $this->render();
        }
    }

    public function editar_pjuridica() {
        if (isset($this->uri_segment[2])) {
            $this->cliente_id = $this->uri_segment[2];
            $this->tpl('admin/cliente_editar_pjuridica.html');

            $this->select()
                ->from('cliente')
                ->where("cliente_id = $this->cliente_id")
                ->execute();
            $this->assignAll();


            $this->select()
                ->from('endereco')
                ->where("endereco_cliente = $this->cliente_id")
                ->execute();
            $this->fetch('addr', $this->data);

            $this->render();
        }
    }

    public function imprimir() {
        if (isset($this->uri_segment[2])) {

            $this->cliente_id = $this->uri_segment[2];


            $this->select()
                    ->from('cliente')
                    ->where("cliente_id = $this->cliente_id")
                    ->execute();
            $this->assignAll();



            if($this->data[0]['cliente_cpf'] != ""){
                $this->tpl('admin/cliente_impressao.html');
            }else{
                $this->tpl('admin/cliente_impressao_pjuridica.html');
            }

            $this->select()
                    ->from('endereco')
                    ->where("endereco_cliente = $this->cliente_id")
                    ->execute();
            $this->fetch('addr', $this->data);

            $this->render();
        }
    }


    public function atualizar() {
        $valid = array(
            'cliente_id' => 'string',
            'cliente_nome' => 'string'
        );
        if ($this->postIsValid($valid)) {
            $this->cliente_cpf = $this->postGetValue('cliente_cpf');
            $this->cliente_id = $this->postGetValue('cliente_id');
            $this->cliente_email = $this->postGetValue('cliente_email');
            $pass = $this->postGetValue('cliente_password');
            if ($pass == "") {
                $this->postIndexDrop('cliente_password');
            } else {
                $this->postValueChange('cliente_password', md5($this->postGetValue('cliente_password')));
            }
            $this->update('cliente')->set()->where("cliente_id = $this->cliente_id")->execute();
        } else {
            $this->pageError();
        }
        $this->redirect("$this->baseUri/admin/cliente/");
        //$this->render();
    }

    public function enderecoAtualizar() {
        $valid = array(
            'endereco_cep' => 'string',
            'endereco_rua' => 'string',
            'endereco_num' => 'string',
            'endereco_bairro' => 'string',
            'endereco_cidade' => 'string',
            'endereco_uf' => 'string'
        );
        if ($this->postIsValid($valid)) {
            $this->endereco_cliente = $this->postGetValue('endereco_cliente');
            $this->endereco_id = $this->postGetValue('endereco_id');
            $this->update('endereco')
                    ->set()
                    ->where("endereco_id = $this->endereco_id AND endereco_cliente = $this->endereco_cliente")
                    ->execute();
            $this->redirect("$this->baseUri/admin/cliente/editar/$this->endereco_cliente/");
        } else {
            $this->pageError();
        }
    }

    public function checkCPF() {
        if ($this->login != null) {
            $cond = "cliente_cpf = '$this->cliente_cpf' AND cliente_id <> $this->cliente_id";
        } else {
            $cond = "cliente_cpf = '$this->cliente_cpf'";
        }
        $this->select()
                ->from('cliente')
                ->where("$cond")
                ->execute();
        if ($this->result()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkMail() {
        if ($this->login != null) {
            $cond = "cliente_email = '$this->cliente_email' AND cliente_id <> $this->cliente_id";
        } else {
            $cond = "cliente_email = '$this->cliente_email'";
        }
        $this->select()
                ->from('cliente')
                ->where("$cond")
                ->execute();
        if ($this->result()) {
            return true;
        } else {
            return false;
        }
    }

    public function remover() {
        if (isset($this->uri_segment[2])) {
            $this->cliente_id = $this->uri_segment[2];
            $this->delete()
                    ->from('cliente')
                    ->where("cliente_id = $this->cliente_id")
                    ->execute();
            $this->redirect("$this->baseUri/admin/cliente/");
        }
    }

    public function fillDados() {
        $this->select()
                ->from('cliente')
                ->where("cliente_id = $this->cliente_id")
                ->execute();
        if ($this->result()) {
            $this->assignAll();
        }
    }

    public function pageError() {
        echo $this->response;
    }

    public function pedido() {
        $this->cliente_id = $this->uri_segment[2];
        $this->pagebase = "$this->baseUri/admin/cliente/pedido";
        $this->tpl('admin/pedido.html');
        $this->select()
                ->from('pedido')
                ->join('lista', 'lista_pedido = pedido_id', 'INNER')
                ->join('cliente', 'cliente_id = pedido_cliente', 'INNER')
                ->where("pedido_cliente = $this->cliente_id")
                ->paginate(15)
                ->groupby('pedido_id')
                ->orderby('pedido_id desc')
                ->execute();
        if ($this->result()) {
              foreach ($this->data as $k => $v) {
                  $this->data[$k]['pedido_total_frete'] = ($this->data[$k]['pedido_total_produto'] - $this->data[$k]['pedido_cupom_desconto']) + $this->data[$k]['pedido_frete'];
              }
              $this->money('pedido_total_frete');
              $this->addkey('staticon', '', 'pedido_status');
              $this->preg($this->status_pat, $this->status_rep_icon, 'staticon');
              $this->preg($this->status_pat, $this->status_rep, 'pedido_status');
              $this->fetch('cart', $this->data);
            $this->assign('para', 'para: ' . $this->data[0]['cliente_nome']);
        } else {
            $this->assign('showHide', 'hide');
            $this->assign('msg_pedido', '<h5 class="alert">Nenhum pedido na lista.</h5>');
        }
        $this->render();
    }

}

/*end file*/
