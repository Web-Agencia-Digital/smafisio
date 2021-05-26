<?php
$this->select()->from('pay')->where('pay_name = "PagSeguro"')->execute();
$pagPay = (object)$this->data[0];
$pagUri = new stdClass;
$pagUri->base = $this->baseUri;
$this->map($this->data[0]);
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
        $pagUri->env = $this->pay_c5;
        $pagUri->trans_url = $env->trans_url;
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
        $total_compra = $_POST['total_produtos'];
        $desconto_boleto = $this->payConfig->_pay['PagSeguro']->pay_fator_juros;

        $desconto = 0;

        if ($desconto_boleto > 0) {
            $desconto = (($total_compra / 100) * $desconto_boleto);
            $desconto = ($desconto - ($desconto * 2));
            $desconto = round($desconto);
        }

        $desconto = floatval($desconto) - 1;
        $desconto = number_format($desconto, 2, '.', '');
        $pagPay->desconto = $desconto;
        require_once 'pay-pagseguro.php';
        $result = prepare_data_b($pagPay, $pagUri, $payPedido);
        $result_info = $result;
        $result = simplexml_load_string($result);
        if (isset($result->error) || $result_info == 'Unauthorized') {
            $this->update('pedido')
                ->set(array('pedido_status', 'pedido_obs'), array(7, 'Pedido não realizado, pelo PagSeguro!'))
                ->where("pedido_id = $this->pedido_id")
                ->execute();
            $this->clear();
            $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
        } else {
            $this->url_code = $result->code;
            $pedidoURL = $result->paymentLink;
            $this->update('pedido')
                ->set(array('pedido_pay_code', 'pedido_pay_url', 'pedido_pay_gw'), array($result->code, $pedidoURL, 5))
                ->where("pedido_id = $this->pedido_id")
                ->execute();
            $this->notificarAdmin();
            $this->notificarFaturaCliente();
            $this->clear();
            $this->redirect("$this->baseUri/cliente/pedido/$this->pedido_id/show/");
        }
    }
}