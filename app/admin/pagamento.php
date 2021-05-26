<?php

class Pagamento extends PHPFrodo
{
    private $user_login;
    private $user_id;
    private $user_name;
    private $user_level;
    public $msgError;

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
        if ( $this->user_level == 1 )
        {
            $this->assign( 'showhide', 'hide' );
            $this->redirect( "$this->baseUri/admin/" );
        }
    }

    public function welcome()
    {
        //
    }

    public function cartao(){
        $this->tpl( 'admin/pagamento_cartao.html' );
        $this->select('pay_key')->from( 'pay' )->where( 'pay_id = "6"' )->execute();
        if ( $this->result() )
        {
            $this->assign('gatway_name', $this->data[0]['pay_key']);
        }
        $this->select()->from( 'pay' )->where( 'pay_id = "1"' )->execute();
        if ( $this->result() )
        {
            $this->assignAll();
        }
        $this->render();
    }
    public function pagSeguro()
    {
        $this->tpl( 'admin/pagamento_pagseguro.html' );
        $this->modPagSeguro();
        $this->render();
    }
    public function mercadopago()
    {
        $this->tpl( 'admin/pagamento_mercadopago.html' );
        $this->modMercadoPago();
        $this->render();
    }
    public function deposito()
    {
        $this->tpl( 'admin/pagamento_deposito.html' );
        $this->modDeposito();
        $this->render();
    }
    public function boleto()
    {
        $this->tpl( 'admin/pagamento_boleto.html' );
        $this->modBoleto();
        $this->render();
    }

    public function modCielo()
    {
	$this->helper('cielo');
        $this->select()->from( 'pay' )->where( 'pay_name = "Cielo"' )->execute();
        if ( $this->result() )
        {
            $this->assignAll();
        }
    }

    public function modPagSeguro()
    {
        $this->select()->from( 'pay' )->where( 'pay_name = "PagSeguro"' )->execute();
        if ( $this->result() )
        {
            $this->assignAll();
        }
    }

    public function modMercadoPago()
    {
        $this->select()->from( 'pay' )->where( 'pay_name = "MercadoPago"' )->execute();
        if ( $this->result() )
        {
            $this->assignAll();
        }
    }

    public function modDeposito()
    {
        $this->select()->from( 'pay' )->where( 'pay_name = "Deposito"' )->execute();
        if ( $this->result() )
        {
            $this->pay_texto = $this->data[0]['pay_texto'];
            $this->assignAll();
            $this->assign('pay_texto',$this->pay_texto);            
        }
    }

    public function modBoleto()
    {
        $this->select()->from( 'pay' )->where( 'pay_name = "Boleto"' )->execute();
        if ( $this->result() )
        {
            $this->map($this->data[0]);
            $this->pay_texto = $this->data[0]['pay_texto'];
            $this->assignAll();
            $this->assign('pay_texto',$this->pay_texto);            
        }
    }

    public function atualizar()
    {
        if(isset($_POST) && !empty($_POST)){
            foreach($_POST as $k => $v){
                $_POST[$k] = addslashes($v);
            }        
        }
        if ( $this->postIsValid( array( 'pay_id' => 'numeric' ) ) )
        {
            $this->pay_id = $this->postGetValue( 'pay_id' );
            $this->pay_name = $this->uri_segment[2];
            $this->update( 'pay' )->set()->where( "pay_id = $this->pay_id" )->execute();
            $this->redirect( "$this->baseUri/admin/pagamento/$this->pay_name/process-ok/" );
        }
    }

    public function pre($data = null){
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public function pageError()
    {
        $this->tpl( 'admin/error.html' );
        $this->assign( 'msgError', $this->msgError );
        $this->render();
        exit;
    }
}
/*end file*/
