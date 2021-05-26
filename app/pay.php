<?php

class Pay extends PHPFrodo
{

    public $_pay = array();
    public $_cielo = array();
    public $_boleto = array();
    public $_pagseguro = array();
    public $_deposito = array();

    public function __construct()
    {
        parent::__construct();
        $this->select()->from('pay')->execute();

        if (isset($this->data[0])) {
            foreach ($this->data as $pay) {
                $name = $pay['pay_name'];
                $this->_pay["$name"] = (object)$pay;
            }
            $this->_cielo = (array)$this->_pay["Cielo"];
        }
        $this->helper('cielo');
    }

    public function getPaysOn()
    {
        foreach ($this->_pay as $pay) {
            $pays[] = $pay->pay_name;
        }
        $this->assigndata = array();
        if (!in_array('PagSeguro', $pays)) {
            $this->assign('showPagSeguro', 'hide');
        }
        if (!in_array('PayPal', $pays)) {
            $this->assign('showPayPal', 'hide');
        }
        if (!in_array('Deposito', $pays)) {
            $this->assign('showDeposito', 'hide');
        }
        return $this->assigndata;
    }

    public function parcelamentoTabela($valor, $parcs)
    {
        $tabela = "\n";
        $k = 0;
        $display = '';
        $avail = array();
        foreach ($this->_pay as $p) {
            $avail[] = $p->pay_name;
        }
        if ($this->_pay["Config"]->pay_key == 'cielo') {
            if (in_array("Cielo", $avail)) {
                //calcula usando juros cielo
                $this->map($this->_pay["Cielo"]);
                $master = new Cielo;
                $master->taxa(0);
                $master->juros($this->pay_fator_juros);
                $master->valor($valor);
                //$master->num_parcelas(($parcs <= $this->pay_c3) ? $parcs : $this->pay_c3); //configurado no item
                $master->num_parcelas($this->pay_c3); //configurado no modulo
                $master->desconto_avista($this->pay_c2); //10%
                $master->parcelas_sem_juros($this->pay_c1);
                $master->parcelamento();
                $tabela .= $master->tabela_parcelas();
                return $tabela;
                exit;
            }
        }

        if ($this->_pay["Config"]->pay_id == '6') {
			if ($this->_pay["Config"]->pay_id == '6') {
			           if (in_array("PagSeguro", $avail)) {
			               $fator_padrao = "1.00000, 0.52255, 0.35347, 0.26898, 0.21830, 0.18453, 0.16044, 0.14240, 0.12838, 0.11717, 0.10802, 0.10040";
			               $this->map($this->_pay["PagSeguro"]);
			               $fator = explode(",", $fator_padrao);
			               for ($i = 0; $i <= $this->pay_c6 - 1; $i++) {
			                   if ($i >= $this->pay_c1) {
			                       $resultado = $this->round_up($valor * $fator[$i], $i);
			                       $tabela .= "<span class='b-vezes'>" . $resultado['texto'] . "</span><br>\n";
			                   }else{
			                       $resultado = $this->round_up_freetx($valor, $i+1);
			                       $tabela .= "<span class='b-vezes'>" . $resultado['texto'] . "</span><br>\n";
			                   }
			               }
			               return $tabela;
			               exit;
			           }
			       }
        }
    }

    public function round_up($value, $num, $places = 2)
    {
        $mult = pow(10, $places);
        $parcela = number_format(($value >= 0 ? ($value * $mult) : ($value * $mult)) / $mult, 2, ',', '.');
        $total = number_format($parcela * ($num + 1), 2, ',', '.');
        return array('parcela' => $parcela, 'total' => $total, 'texto' => "<span class='x-vezes'>" . ($num + 1) . "x</span> R$ <span class='x-valor'>" . $parcela . '</span> c/ juros', 'num' => ($num + 1));
    }

    public function round_up_freetx($value, $num)
    {
        $parcela = number_format(($value >= 0 ? ($value) : ($value)) / $num, 2, ',', '.');
        $total = number_format($parcela, 2, ',', '.');
        return array('parcela' => $parcela, 'total' => $total, 'texto' => "<span class='x-vezes'>" . ($num) . "x</span> R$ <span class='x-valor'>" . $parcela . '</span> s/ juros', 'num' => ($num));
    }

}
