<?php
$this->select()->from('pay')->where('pay_name = "PagSeguro"')->execute();
$this->map($this->data[0]);
$pagPay = (object)$this->data[0];
$pagPay->hash = $_POST['sender_hash'];
$pagUri = new stdClass;
$pagUri->base = $this->baseUri;
if ($this->pedido_id >= 1) {
    $this->select()
        ->from('cliente')
        ->join('endereco', 'endereco_cliente = cliente_id', 'INNER')
        ->where("cliente_id = $this->cliente_id and endereco_tipo = 1")
        ->execute();
    $this->encode('endereco_uf', 'strtoupper');
    $payPedido = (object)$this->data[0];
    $this->map($this->data[0]);
    $this->cliente_telefone = preg_replace('/\W/', '', $this->cliente_telefone);
    $this->cliente_ddd = substr($this->cliente_telefone, 0, 2);
    $this->cliente_telefone = substr($this->cliente_telefone, 2, -1);
    $cliente_nascimento = $this->cliente_datan;
    $this->select()
        ->from('pedido')
        ->where("pedido_cliente = $this->cliente_id AND pedido_id = $this->pedido_id")
        ->execute();
    if ($this->result()) {
        $this->map($this->data[0]);
        $itens_p = array();
        $this->select()
            ->from('lista')
            ->where("lista_pedido = $this->pedido_id")
            ->execute();
        if ($this->result()) {
            $this->cut('lista_title', 60, '...');
            $itens = $this->data;
            $j = 0;

            /*
            foreach ($itens as $i) {
                $j++;
                $this->map($i);
                $this->lista_preco = preg_replace('/\,/', '', $this->lista_preco);
                $itens_p["itemId$j"] = utf8_decode($this->lista_item);
                $itens_p["itemDescription$j"] = utf8_decode("$this->lista_title");
                $itens_p["itemAmount$j"] = $this->lista_preco;
                $itens_p["itemQuantity$j"] = $this->lista_qtde;
            }
            */

            $itens_p["itemId1"] = '1';
            $itens_p["itemDescription1"] = 'Produtos da loja';
            $itens_p["itemAmount1"] = number_format( ($this->pedido_total_frete - $this->pedido_frete), 2, '.', '');
            $itens_p["itemQuantity1"] = 1;


        }
        $cliente_nome = ($this->cliente_cpf != '' && strlen($this->cliente_cpf) >= 5) ? "$this->cliente_nome $this->cliente_sobrenome" : $this->cliente_nome;
        $env = $this->pagseguro_get_env($this->pay_c5);
        $pagUri->trans_url = $env->trans_url;
        $pagUri->env = $this->pay_c5;
        $payPedido->cliente_cpf = $this->cliente_cpf;
        $payPedido->cliente_cnpj = $this->cliente_cnpj;
        $payPedido->cliente_nome = $cliente_nome;
        $payPedido->cliente_ddd = $this->cliente_ddd;
        $payPedido->cliente_telefone = $this->cliente_telefone;
        $payPedido->cliente_email = $this->cliente_email;
        $payPedido->itens_p = $itens_p;
        $payPedido->pedido_id = $this->pedido_id;
        $payPedido->pedido_tipo_frete = $this->pedido_tipo_frete;
        $payPedido->pedido_frete = $this->pedido_frete;
        $pedido_total_parcelado = number_format($_POST['pedido_total_parcelado'], 2, ',', '.');
        $pagPay->token = $_POST['card_token'];
        $total_amount = number_format($_POST['total_amount'], 2, '.', '');
        $pagPay->pay_c1 = $this->pay_c1;
        $pagPay->total_amount = $total_amount;
        $pagPay->cliente_nascimento = $cliente_nascimento;
        $pagPay->cliente_ddd = $this->cliente_ddd;
        $pagPay->cliente_telefone = $this->cliente_telefone;
        require_once 'pay-pagseguro.php';
        $result = prepare_data_c($pagPay, $pagUri, $payPedido);


        $result_info = $result;
        $result = simplexml_load_string($result);
        if (isset($result->error) || $result_info == 'Unauthorized') {
            $this->update('pedido')
                ->set(array('pedido_status', 'pedido_total_parcelado', 'pedido_obs'), array(7, $pedido_total_parcelado, 'Pedido não realizado pelo PagSeguro!'))
                ->where("pedido_id = $this->pedido_id")
                ->execute();
            $this->clear();
            $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
        }
        else {
            $this->url_code = $result->code;
            $pedidoURL = "https://pagseguro.uol.com.br/v2/checkout/payment.html?code=$result->code";
            $this->update('pedido')
                ->set(array('pedido_status','pedido_pay_code', 'pedido_pay_url', 'pedido_pay_gw', 'pedido_total_parcelado'),
                       array($result->status,$result->code, $pedidoURL, 1, $pedido_total_parcelado)
                )
                ->where("pedido_id = $this->pedido_id")
                ->execute();
            $this->notificarAdmin();
            $this->notificarFaturaCliente();
            $this->clear();
            $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
            exit;
        }
    }
}