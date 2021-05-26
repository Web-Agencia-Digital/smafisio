<?php

class Depoimento extends PHPFrodo
{
    public $depoimento_id;
    public $depoimento_nome;
    public $depoimento_foto;
    public $depoimento_msg;
    public $depoimento_link;
    public $user_name;
    public $user_id;
    public $user_login;
    public $user_level;

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
        if ( isset( $this->uri_segment ) && in_array( 'process-ok', $this->uri_segment ) )
        {
            $this->assign( 'msgOnload', 'notify("<h1>Procedimento realizado com sucesso</h1>")' );
        }
        if ( isset( $this->uri_segment ) && in_array( 'no-file', $this->uri_segment ) )
        {
            $this->assign( 'msgOnload', 'notify("<h1>Nenhuma imagem foi enviada!</h1>")' );
        }
        if ( $this->user_level == 1 )
        {
            $this->assign( 'showhide', 'hide' );
        }
    }

    public function welcome()
    {
        $this->tpl( 'admin/depoimento.html' );
        $this->select()->from( 'depoimento' )->orderby( 'depoimento_id desc' )->execute();
        if ( $this->result() )
        {
            $this->preg( '/NULL/', '&nbsp;', 'depoimento_nome' );
            $this->preg( '/NULL/', '&nbsp;', 'depoimento_msg' );
            $this->preg( array('/\.jpg/','/\.png/'), array('',''),  'depoimento_foto' );
            $this->fetch( 'rs', $this->data );
        }
        $this->assign( 'depoimento_qtde', count( $this->data ) );
        $this->render();
    }

    public function editar()
    {
        $this->tpl( 'admin/depoimento_editar.html' );
        if ( isset( $this->uri_segment[2] ) )
        {
            $this->depoimento_id = $this->uri_segment[2];
            $this->select()->from( 'depoimento' )->where( "depoimento_id = $this->depoimento_id" )->execute();
            if ( $this->result() )
            {
                $this->addkey( 'depoimento_thumb', '', 'depoimento_foto' );
                $this->preg( array('/\.jpg/','/\.png/'), array('',''),  'depoimento_thumb' );
                $this->data[0]['depoimento_nome'] = $this->mytrim($this->data[0]['depoimento_nome']);
                $this->data[0]['depoimento_msg'] = $this->mytrim($this->data[0]['depoimento_msg']);
                $this->assignAll();
            }
            $this->render();
        }
        else
        {
            $this->redirect( "$this->baseUri/admin/depoimento/" );
        }
    }

    public function novo()
    {
        $this->tpl( 'admin/depoimento_novo.html' );
        $this->render();
    }

    public function incluir()
    {
        //if ( isset( $_FILES['filedata'] ) && strlen( $_FILES['filedata']['name'] ) >= 1 ){
            $this->uploads();
            $this->depoimento_nome = $this->mytrim($_POST['depoimento_nome']);
            $this->depoimento_msg = $this->mytrim($_POST['depoimento_msg']);
            $f = array( 'depoimento_nome', 'depoimento_msg', 'depoimento_foto', 'depoimento_data' );
            $v = array( "$this->depoimento_nome", "$this->depoimento_msg", "$this->depoimento_foto", date('d-m-Y') );
            $this->insert( 'depoimento' )->fields( $f )->values( $v )->execute();
            $this->redirect( "$this->baseUri/admin/depoimento/process-ok/" );
       // }
        //else{
          //  $this->redirect( "$this->baseUri/admin/depoimento/no-file/" );
       // }
    }

    public function mytrim($str){
        return preg_replace('/\s+/',' ',$str);
    }
    public function atualizar()
    {
        $this->depoimento_id = $this->uri_segment[2];
        $this->depoimento_nome = $this->mytrim( $_POST['depoimento_nome'] );
        $this->depoimento_msg = $this->mytrim( $_POST['depoimento_msg'] ) ;
        if ( isset( $_FILES['filedata'] ) && strlen( $_FILES['filedata']['name'] ) >= 1 )
        {
            if ( $this->uploads() )
            {
                $this->removeAtual();
                $f = array( 'depoimento_nome', 'depoimento_msg', 'depoimento_foto');
                $v = array( "$this->depoimento_nome", "$this->depoimento_msg", "$this->depoimento_foto");
            }
        }
        else
        {
            $f = array( 'depoimento_nome', 'depoimento_msg');
            $v = array( "$this->depoimento_nome", "$this->depoimento_msg");
        }
        $this->update( 'depoimento' )->set( $f, $v )->where( "depoimento_id = $this->depoimento_id" )->execute();
        $this->redirect( "$this->baseUri/admin/depoimento/process-ok/" );
    }

    public function remover()
    {
        $this->depoimento_id = $this->uri_segment[2];
        $this->removeAtual();
        $this->delete()->from( 'depoimento' )->where( "depoimento_id = $this->depoimento_id" )->execute();
        $this->redirect( "$this->baseUri/admin/depoimento/process-ok/" );
    }

    public function removeAtual()
    {
        $this->select()->from( 'depoimento' )->where( "depoimento_id = $this->depoimento_id" )->execute();
        if ( $this->result() )
        {
            $this->depoimento_foto_current = "app/fotos/cliente/" . $this->data[0]['depoimento_foto'];
            if ( file_exists( $this->depoimento_foto_current ) )
            {
                @unlink( $this->depoimento_foto_current );
            }
        }
    }

    public function uploads()
    {
        $file_dst_name = "";
        $dir_dest = 'app/fotos/cliente';
        $files = array( );

        if ( isset( $_FILES['filedata'] ) && strlen( $_FILES['filedata']['name'] ) >= 1 )
        {
           	$file = $_FILES['filedata'];
		$handle = new Upload( $file );
		if ( $handle->uploaded )
		{
		    $handle->file_overwrite = true;
		    $handle->image_convert = 'png';
		    $handle->png_compression = 9;
		    if ( $handle->image_src_x > 1200 || $handle->image_y > 700 )
		    {
    			//$handle->image_resize = true;
    			//#$handle->image_ratio_crop = true;
    			//$handle->image_x = 900;
    			//$handle->image_y = 350;
		    }
		    $handle->file_new_name_body = md5( uniqid( $file['name'] ) );
		    $handle->Process( $dir_dest );
		    if ( $handle->processed )
		    {
			$this->depoimento_foto = $handle->file_dst_name;
			return true;
		    }
		    else
		    {
			return false;
			//echo $handle->Error;
		    }
		}
            
        }
        else
        {
            return false;
        }
    }
}
