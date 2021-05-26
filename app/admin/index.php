<?php

class Index extends PHPFrodo
{
    private $user_login;
    private $user_id;
    private $user_name;
    private $user_level;

    public function __construct()
    {
        parent::__construct();
        $sid = new Session;
        $sid->start();
        if ( !$sid->check() || $sid->getNode( 'user_id' ) <= 0 )
        {
            $this->redirect( "$this->baseUri/admin/login/logout/" );
            exit;
        }

        $this->user_login = @$sid->getNode( 'user_login' );
        $this->user_id = @$sid->getNode( 'user_id' );
        $this->user_name = $sid->getNode( 'user_name' );
        $this->user_level = ( int ) $sid->getNode( 'user_level' );
        $this->assign( 'user_name', $this->user_name );
        $this->select()
                ->from( 'config' )
                ->execute();
        if ( $this->result() )
        {
            $this->config = ( object ) $this->data[0];
            $this->assignAll();
        }
        if ( $this->user_name == "" )
        {
            $this->redirect( "$this->baseUri/admin/login/logout/" );
        }

        if ( $this->user_level == 1 )
        {
            $this->assign( 'showhide', 'hide' );
        }
    }

    public function welcome()
    {
        if(file_exists('app/admin/update.php')){
            $this->redirect("$this->baseUri/admin/update/");
        }
        $this->select()->from( 'versao' )->execute();
        $versao = ( object ) $this->data[0];
        $current = $versao->versao_update;
        $data = $versao->versao_data;
        $this->tpl( 'admin/dashboard.html' ); 
        $this->assign( 'versao', "Versão [$current] *** Atualizada em $data" );
        $this->render();
    }
}
/*end file*/
