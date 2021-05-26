<?php

class Faixacep extends PHPFrodo
{

    public $user_login;
    public $user_id;
    public $user_name;
    public $user_level;
    public $frete_param;
    public $faixacep_id;
    public $faixacep_cpf;
    public $faixacep_nome;
    public $faixacep_email;

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
        $this->user_login = $sid->getNode( 'user_login' );
        $this->user_id = $sid->getNode( 'user_id' );
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
        if ( isset( $this->uri_segment ) && in_array( 'process-ok', $this->uri_segment ) )
        {
            $this->assign( 'msgOnload', 'notify("<h1>Procedimento realizado com sucesso</h1>")' );
        }
        if ( $this->user_level == 1 ) {
            $this->assign('showhide','hide');
        }
    }

    public function welcome()
    {
        $this->tpl( 'admin/faixa_frete.html' );
        $this->select()
            ->from( 'faixacep' )
            ->execute();
        if ( $this->result() )
        {
            $this->fetch( 'addr', $this->data );
        }
        $this->render();
    }

    public function incluir()
    {
        $_POST['faixacep_cep_inicio'] = str_replace('-', '', $_POST['faixacep_cep_inicio']);
        $_POST['faixacep_cep_final'] = str_replace('-', '', $_POST['faixacep_cep_final']);
        if ( $this->postIsValid( array( 'faixacep_cep_inicio' => 'string' ) ) )
        {
            $this->insert( 'faixacep' )->fields()->values()->execute();
            $this->redirect( "$this->baseUri/admin/faixacep/process-ok/" );
        }
    }

    public function atualizar()
    {
        if ( isset( $this->uri_segment[2] ) )
        {
            $_POST['faixacep_cep_inicio'] = str_replace('-', '', $_POST['faixacep_cep_inicio']);
            $_POST['faixacep_cep_final'] = str_replace('-', '', $_POST['faixacep_cep_final']);
            $this->faixacep_id = $this->uri_segment[2];
            if ( $this->postIsValid( array( 'faixacep_cep_inicio' => 'string' ) ) )
            {
                $this->update( 'faixacep' )->set()->where( "faixacep_id = $this->faixacep_id" )->execute();
                $this->redirect( "$this->baseUri/admin/faixacep/process-ok/" );
            }
            else
            {
                $this->redirect( "$this->baseUri/admin/faixacep/proccess-fail/" );
            }
        }
        else
        {
            $this->redirect( "$this->baseUri/admin/faixacep/proccess-fail/" );
        }
    }

    public function remover()
    {
        if ( isset( $this->uri_segment[2] ) )
        {
            $this->faixacep_id = $this->uri_segment[2];
            $this->delete()
                ->from( 'faixacep' )
                ->where( "faixacep_id = $this->faixacep_id" )
                ->execute();
            $this->redirect( "$this->baseUri/admin/faixacep/process-ok/" );
        }
    }

    public function fillDados()
    {
        $this->select()
            ->from( 'faixacep' )
            ->where( "faixacep_id = $this->faixacep_id" )
            ->execute();
        if ( $this->result() )
        {
            $this->assignAll();
        }
    }


    /*
     CREATE TABLE faixacep
(
    faixacep_id int PRIMARY KEY AUTO_INCREMENT,
    faixacep_cep_inicio varchar(20) DEFAULT null ,
    faixacep_cep_final varchar(20) DEFAULT null ,
    faixacep_desc varchar(200) DEFAULT null ,
    faixacep_peso_de varchar(20) DEFAULT null ,
    faixacep_peso_ate varchar(20) DEFAULT null ,
    faixacep_valor varchar(20) DEFAULT null ,
    faixacep_prazo varchar(255) DEFAULT null
);
     */


}

/*end file*/