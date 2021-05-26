<?php

class Configuracao extends PHPFrodo {

    public $user_login;
    public $user_id;
    public $user_name;
    public $user_level;
    public $frete_param;

    public function __construct() {
        parent::__construct();
        $sid = new Session;
        $sid->start();
        if (!$sid->check() || $sid->getNode('user_id') <= 0) {
            $this->redirect("$this->baseUri/admin/login/logout/");
            exit;
        }
        $this->user_login = $sid->getNode('user_login');
        $this->user_id = $sid->getNode('user_id');
        $this->user_name = $sid->getNode('user_name');
        $this->user_level = (int) $sid->getNode('user_level');
        $this->assign('user_name', $this->user_name);
        $this->select()
                ->from('config')
                ->execute();
        if ($this->result()) {
            $this->config = (object) $this->data[0];
            $this->assignAll();
        }
        if (isset($this->uri_segment) && in_array('process-ok', $this->uri_segment)) {
            $this->assign('msgOnload', 'notify("<h1>Procedimento realizado com sucesso</h1>")');
        }
        if ($this->user_level == 1) {
            $this->assign('showhide', 'hide');
        }
    }

    public function welcome() {
        $this->tpl('admin/configuracao.html');
        $this->select()
                ->from('config')
                ->execute();
        if ($this->result()) {
            $this->assignAll();
        }
        $this->render();
    }

    public function chat() {
        $this->tpl('admin/configuracao_chat.html');
        $this->select()
                ->from('config')
                ->execute();
        if ($this->result()) {
            $this->assignAll();
        }
        $this->render();
    }

    public function tema() {
        $this->tpl('admin/configuracao_tema.html');
        $this->select()
                ->from('config')
                ->execute();
        if ($this->result()) {
            $this->assignAll();
        }
        $this->render();
    }

    public function atualizar() {
        if ($this->postIsValid(array('config_id' => 'int'))) {
            $this->postValueChange('config_chat', addslashes($this->postGetValue('config_chat')));
            $this->update('config')->set()->execute();
            if (in_array('chat', $this->uri_segment)) {
                $this->redirect("$this->baseUri/admin/configuracao/chat/process-ok/");
            }
            $this->redirect("$this->baseUri/admin/configuracao/process-ok/");
        }
    }

    public function atualizarTema() {
        if ($this->postIsValid(array('config_id' => 'int'))) {
            $this->postValueChange('config_color_bd', preg_replace(array('/#/'), array(''), $this->postGetValue('config_color_bd')));
            $this->postValueChange('config_color_bh', preg_replace(array('/#/'), array(''), $this->postGetValue('config_color_bh')));
            $this->postValueChange('config_color_cd', preg_replace(array('/#/'), array(''), $this->postGetValue('config_color_cd')));
            $this->postValueChange('config_color_ch', preg_replace(array('/#/'), array(''), $this->postGetValue('config_color_ch')));
            $this->postValueChange('config_color_top', preg_replace(array('/#/'), array(''), $this->postGetValue('config_color_top')));
            $this->update('config')->set()->execute();
            $this->redirect("$this->baseUri/admin/configuracao/tema/process-ok/");
        }
    }

    public function atualizarAparencia() {
        if ($this->postIsValid(array('config_id' => 'int'))) {
            $this->update('config')->set()->execute();
            $this->redirect("$this->baseUri/admin/configuracao/tema/process-ok/");
        }
    }



    public function atualizarLogo() {
        if (isset($_FILES['filedata']) && strlen($_FILES['filedata']['name']) >= 1) {
            $this->upload_logo();
        }
        $this->redirect("$this->baseUri/admin/configuracao/tema/process-ok/");
    }


    public function atualizarFav() {
        if (isset($_FILES['filedata']) && strlen($_FILES['filedata']['name']) >= 1) {
            $this->upload_fav();
        }
        $this->redirect("$this->baseUri/admin/configuracao/tema/process-ok/");
    }

    public function upload_logo() {
        $dir_dest = 'app/images/layout';
        if (isset($_FILES['filedata']) && strlen($_FILES['filedata']['name']) >= 1) {
            $file = $_FILES['filedata'];
            $handle = new Upload($file);
            if ($handle->uploaded) {
                $handle->file_overwrite = true;
                //$handle->image_convert = 'png';
                $handle->file_new_name_body = "logo";
                $handle->Process($dir_dest);
                if ($handle->processed) {
                    $this->logo = $handle->file_dst_name;
                }
            }
        }
    }

    public function upload_fav() {
        $dir_dest = 'app/images/layout';
        if (isset($_FILES['filedata']) && strlen($_FILES['filedata']['name']) >= 1) {
            $file = $_FILES['filedata'];
            $handle = new Upload($file);
            if ($handle->uploaded) {
                $handle->file_overwrite = true;
                $handle->image_convert = 'png';
                $handle->file_new_name_body = "favicon";
                @$handle->Process($dir_dest);
                if ($handle->processed) {
                    $this->fav = $handle->file_dst_name;
                    //return true;
                } else {
                    //echo $handle->error;
                    //return false;
                }
            }
        }
    }

}

/*end file*/