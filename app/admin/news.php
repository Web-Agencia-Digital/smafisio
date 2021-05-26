<?php

class News extends PHPFrodo {

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

        $this->select()
                ->from('news')
                ->execute();
        if ($this->result()) {
            $this->news = (object) $this->data[0];
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
        $this->tpl('admin/news.html');
        $this->select()
                ->from('news')
                ->execute();
        if ($this->result()) {
             foreach ($this->data as $k => $v) {
                 $this->data[$k]['news_email'] = strtolower($this->data[$k]['news_email']);
                 $this->data[$k]['news_data'] = date('d-m-Y',  strtotime($this->data[$k]['news_data']));
             }
            $this->fetch('rs', $this->data);
            $this->assignAll();
        }
        $this->render();

    }


    public function exportar() {
        $this->select()
                ->from('news')
                ->execute();
        if ($this->result()) {
            $all = "";
            foreach ($this->data as $k => $v) {
                $this->data[$k]['news_data'] = date('d-m-Y',  strtotime($this->data[$k]['news_data']));
                $all .= utf8_decode($this->data[$k]['news_nome']) . ";";
                $all .= strtolower($this->data[$k]['news_email']) . ";";
                $all .= $this->data[$k]['news_data'] . ";";
                $all .= "\n";
            }
            $FileName = "newsletter-".date("d-m-Y") . '.csv';
            @header('Content-Type: application/csv;charset=utf-8');
            @header('Content-Disposition: attachment; filename="' . $FileName . '"');
            echo  $all;
        }
    }


    public function remover() {
        if (isset($this->uri_segment[2])) {
            $this->news_id = $this->uri_segment[2];
            $this->delete()->from('news')->where("news_id = $this->news_id")->execute();
        }
        $this->redirect("$this->baseUri/admin/news/process-ok/");
    }

}

/*end file*/