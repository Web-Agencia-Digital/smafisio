<?php

/*
<option value="04510">PAC</option>
<option value="04014">SEDEX</option>
<option value="40215">SEDEX 10</option>
<option value="40045">SEDEX a Cobrar</option>
<option value="40290">SEDEX HOJE</option>
<option value="81019">e-SEDEX</option>
<option value="44105">MALOTE</option>
<option value="85480">AEROGRAMA</option>
<option value="10030">CARTA SIMPLES</option>
<option value="10014">CARTA REGISTRADA</option>
<option value="16012">CART&Atilde;O POSTAL</option>
<option value="20010">IMPRESSO</option>
<option value="14010">MALA DIRETA</option>
 */

class Frete extends PHPFrodo
{
    public $config_cep = array();
    public $cep_origem;
    public $cep;
    public $cidade_origem;
    public $uf_origem;
    public $valor_frete = null;
    public $error = null;
    public $prazo_frete = null;
    public $cliente_cep = null;
    public $item_peso = null;
    public $item_altura = null;
    public $item_largura = null;
    public $item_comprimento = null;
    public $valor_frete_formatado = null;
    public $frete_opcoes = array();
    public $erros = array(
        '0' => 'Processamento com sucesso',
        '-1' => 'Código de serviço inválido',
        '-2' => 'CEP de origem inválido',
        '-3' => 'CEP de destino inválido',
        '-4' => 'Peso excedido',
        '-5' => 'O Valor Declarado não deve exceder R$ 10.000,00',
        '-6' => 'Serviço indisponível para o trecho informado',
        '-7' => 'O Valor Declarado é obrigatório para este serviço',
        '-8' => 'Este serviço não aceita Mão Própria',
        '-9' => 'Este serviço não aceita Aviso de Recebimento',
        '-10' => 'Precificação indisponível para o trecho informado',
        '-11' => 'Para definição do preço deverão ser informados, também, o comprimento, a largura e altura do objeto em centmetros (cm)',
        '-12' => 'Comprimento inválido',
        '-13' => 'Largura inválida',
        '-14' => 'Altura inválida',
        '-15' => 'O comprimento não pode ser maior que 105 cm',
        '-16' => 'A largura não pode ser maior que 105 cm',
        '-17' => 'A altura não pode ser maior que 105 cm',
        '-18' => 'A altura não pode ser inferior a 2 cm',
        '-20' => 'A largura não pode ser inferior a 11 cm',
        '-22' => 'O comprimento não pode ser inferior a 16 cm',
        '-23' => 'A soma resultante do comprimento + largura + altura não deve superar a 200 cm',
        '-24' => 'Comprimento inválido',
        '-25' => 'diâmetro inválido',
        '-26' => 'Informe o comprimento',
        '-27' => 'Informe o diâmetro',
        '-28' => 'O comprimento não pode ser maior que 105 cm',
        '-29' => 'O diâmetro não pode ser maior que 91 cm',
        '-30' => 'O comprimento não pode ser inferior a 18 cm',
        '-31' => 'O diâmetro não pode ser inferior a 5 cm',
        '-32' => 'A soma resultante do comprimento + o dobro do diâmetro não deve superar a 200 cm',
        '-33' => 'Sistema temporariamente fora do ar. Favor tentar mais tarde',
        '-34' => 'Código Administrativo ou Senha inválidos',
        '-35' => 'Senha incorreta',
        '-36' => 'Cliente não possui contrato vigente com os Correios',
        '-37' => 'Cliente não possui Serviço ativo em seu contrato',
        '-38' => 'Serviço indisponível para este Código administrativo',
        '-39' => 'Peso excedido para o formato envelope',
        '-40' => 'Para definicao do preco deverao ser informados, tambem, o comprimento e a largura e altura do objeto em centimetros (cm)',
        '-41' => 'O comprimento nao pode ser maior que 60 cm',
        '-42' => 'O comprimento nao pode ser inferior a 16 cm',
        '-43' => 'A soma resultante do comprimento + largura nao deve superar a 120 cm',
        '-44' => 'A largura nao pode ser inferior a 11 cm',
        '-45' => 'A largura nao pode ser maior que 60 cm',
        '-888' => 'Erro ao calcular a tarifa',
        '006' => 'Localidade de origem não abrange o Serviço informado',
        '007' => 'Localidade de destino não abrange o Serviço informado',
        '008' => 'Serviço indisponível para o trecho informado',
        '009' => 'CEP inicial pertencente a ?rea de Risco',
        '010' => 'CEP final pertencente a ?rea de Risco. A entrega será realizada, temporariamente, na agência mais próxima do endere?o do destinatário',
        '011' => 'CEP inicial e final pertencentes a área de Risco',
        '7' => 'Serviço indisponível, tente mais tarde',
        '99' => 'Outros erros diversos do .Net');
    public $regiao = array();

    public function __construct()
    {
        parent:: __construct();
        $sid = new Session;
        @$sid->start();
        $this->select()
            ->from('frete')
            ->execute();
        if ($this->result()) {
            $this->config_cep = null;
            $this->config_cep = (object)$this->data[0];
            $_SESSION['FRETE'] = $this->config_cep;
            $_SESSION['FRETE_CEP'] = $this->config_cep->frete_cep_origem;
        }
        //$this->config_cep = $_SESSION['FRETE'];
        $this->regiao['sul'] = array('SP', 'MG', 'RJ', 'PR');
        $this->regiao['outros'] = array('ES', 'RS', 'SC', 'DF', 'ES', 'GO', 'MS', 'TO', 'AL', 'BA', 'CE', 'PB', 'PE', 'MA', 'MT', 'SE');
        $this->cep_origem = $_SESSION['FRETE_CEP'];
    }

    public function welcome()
    {
        echo 'PHP STAFF', $this->uf_origem, $this->cidade_origem;
    }

    public function buscaRetirada()
    {
        if ($this->config_cep->frete_opcoes == 1) {
            $cb = '';
            $this->select()
                ->from('retirada')
                ->orderby('retirada_local asc')
                ->execute();
            if ($this->result()) {
                $ret = $this->data;
                foreach ($ret as $obj) {
                    $obj = (object)$obj;
                    $cb .= "<table  class='table table-hover table-no-border'>";
                    $cb .= '<tr>';
                    $cb .= '<td width=30>';
                    $cb .= "<input type='radio' class='btn-update-frete' name='tipo_frete[]' id='ret-$obj->retirada_id' t='' value='0|0' v='0' p='0' />";
                    $cb .= '</td>';
                    $cb .= '<td width=100>';
                    $cb .= "<label for='ret-$obj->retirada_id'>";
                    $cb .= "<b class='f-gray'>Grátis</b>";
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td width=200>';
                    $cb .= "<label for='ret-$obj->retirada_id'>";
                    $cb .= "<b class='f-gray'>$obj->retirada_local <br> $obj->retirada_cidade - $obj->retirada_uf</b>";
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';

                    $cb .= "<label for='ret-$obj->retirada_id'>";
                    $cb .= "Retirar no local";
                    $cb .= '</label>';

                    $cb .= '</td>';
                    $cb .= '</tr>';
                    $cb .= '</table>';
                }
                echo $cb;
            }
        }
    }

    public function buscaFreteGratis()
    {
        if (isset($_POST['uf']) && !empty($_POST['uf']) && in_array($_POST['uf'], $this->regiao['sul'])) {
            if ($_SESSION['__TOTAL__COMPRA__'] >= $this->config_cep->frete_sul && $this->config_cep->frete_sul > 0) {
                $_SESSION['mycep_frete'] = "0.00";
                $this->nomeEntrega = 'Encomenda Normal';
                $this->ValorEntrega = 0;
                $this->PrazoEntrega = $this->config_cep->frete_prazo;
                $_SESSION['mycep_tipo_frete'] = " Frete Grátis ";
                $_SESSION['mycep_prazo'] = $this->PrazoEntrega;
                $_SESSION['mycep_name'] = $this->nomeEntrega;
                $_SESSION['mycep_frete'] = 0.00;
                $cb = '';
                $cb .= "<table  class='table table-hover table-no-border'>";
                $cb .= '<tr>';
                $cb .= '<td >';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="001-diff"  t="' . $this->nomeEntrega . '" value="' . $this->ValorEntrega . '|' . $this->PrazoEntrega . '" v="' . $this->double($this->ValorEntrega) . '" p="' . $this->PrazoEntrega . '" />';
                $cb .= '</td>';
                $cb .= '<td width=100>';
                $cb .= '<label for="001-diff">';
                $cb .= '<b class="f-gray">Frete Grátis</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td width=200>';
                $cb .= '<label for="001-diff">';
                $cb .= '<b class="f-gray">' . $this->nomeEntrega . '</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="001-diff">';
                if ($this->PrazoEntrega > 1) {
                    $cb .= "até $this->PrazoEntrega dias úteis";
                } else {
                    $cb .= "$this->PrazoEntrega dia útil";
                }
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '</tr>';
                $cb .= '</table>';
                echo $cb;
            }
        }

        if (isset($_POST['uf']) && !empty($_POST['uf']) && in_array($_POST['uf'], $this->regiao['outros'])) {
            if ($_SESSION['__TOTAL__COMPRA__'] >= $this->config_cep->frete_apt && $this->config_cep->frete_apt > 0) {
                $_SESSION['mycep_frete'] = "0.00";
                $this->nomeEntrega = 'Encomenda Normal';
                $this->ValorEntrega = 0;
                $this->PrazoEntrega = $this->config_cep->frete_prazo;
                $_SESSION['mycep_tipo_frete'] = " Frete Grátis ";
                $_SESSION['mycep_prazo'] = $this->PrazoEntrega;
                $_SESSION['mycep_name'] = $this->nomeEntrega;
                $_SESSION['mycep_frete'] = 0.00;
                $cb = '';
                $cb .= "<table  class='table table-hover table-no-border'>";
                $cb .= '<tr>';
                $cb .= '<td >';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="001-diff"  t="' . $this->nomeEntrega . '" value="' . $this->ValorEntrega . '|' . $this->PrazoEntrega . '" v="' . $this->double($this->ValorEntrega) . '" p="' . $this->PrazoEntrega . '" />';
                $cb .= '</td>';
                $cb .= '<td width=100>';
                $cb .= '<label for="001-diff">';
                $cb .= '<b class="f-gray">Frete Grátis</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td width=200>';
                $cb .= '<label for="001-diff">';
                $cb .= '<b class="f-gray">' . $this->nomeEntrega . '</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="001-diff">';
                if ($this->PrazoEntrega > 1) {
                    $cb .= "até $this->PrazoEntrega dias úteis";
                } else {
                    $cb .= "$this->PrazoEntrega dia útil";
                }
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '</tr>';
                $cb .= '</table>';
                echo $cb;
            }
        }

        if (isset($_POST['uf']) && isset($_POST['cidade'])) {
            $this->uf = strtoupper($_POST['uf']);
            $this->cidade = addslashes(($_POST['cidade']));
            if (isset($_POST['bairro'])) {
                $this->bairro = addslashes(($_POST['bairro']));
            }
            $this->cep = $_POST['cep'];
            $cond = " entrega_uf = '$this->uf' AND
			entrega_cidade = '$this->cidade' AND
			entrega_bairro = '$this->bairro' AND
			entrega_tipo = 3 OR ";
            $cond .= "entrega_uf = '$this->uf' AND
			entrega_cidade = '$this->cidade' AND
			entrega_tipo = 2 OR ";
            $cond .= "entrega_uf = '$this->uf' AND  entrega_tipo = 1  ";
            $this->select()
                ->from('entrega')
                ->where("$cond")
                ->execute();
            if ($this->result()) {
                $_SESSION['mycep_tipo_frete'] = " (Frete diferenciado) ";
                $_SESSION['mycep_frete'] = (string)preg_replace('/,/', '.', $this->data[0]['entrega_valor']);
                $_SESSION['mycep_prazo'] = $this->data[0]['entrega_prazo'];
                $_SESSION['mycep_name'] = $this->data[0]['entrega_desc'];
                if (isset($this->uri_segment) && in_array('no-cf', $this->uri_segment)) {
                    $_SESSION['mycep_frete'] = "0.00";
                }
                $this->PrazoEntrega = $_SESSION['mycep_prazo'];
                $this->ValorEntrega = $_SESSION['mycep_frete'];
                $this->nomeEntrega = $_SESSION['mycep_name'];
                $cb = '';
                $cb .= "<table class='table table-hover table-no-border'>";
                $cb .= '<tr>';
                $cb .= '<td width=20>';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="003-diff"  t="' . $this->nomeEntrega . '"  value="' . $this->ValorEntrega . '|' . $this->PrazoEntrega . '" v="' . $this->double($this->ValorEntrega) . '" p="' . $this->PrazoEntrega . '" />';
                $cb .= '</td>';
                $cb .= '<td width=100>';
                $cb .= '<label for="003-diff">';
                if ($this->ValorEntrega >= 1) {
                    $cb .= "R$ $this->ValorEntrega";
                } else {
                    $cb .= 'Frete Grátis';
                }
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td width=200>';
                $cb .= '<label for="003-diff">';
                $cb .= '<b class="f-gray">' . $this->nomeEntrega . '</b>';
                //$cb .= '<img src="images/layout/frete_manual.png" />';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="003-diff">';
                if ($this->PrazoEntrega > 1) {
                    $cb .= "$this->PrazoEntrega dia(s)";
                } else {
                    $cb .= "$this->PrazoEntrega dia útil";
                }
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '</tr>';
                $this->frete_opcoes[] = $cb;
            } else {
                $cb = '';
                $cb .= "<table class='table table-hover table-no-border'>";
                $this->frete_opcoes[] = $cb;
            }
            $this->frete_opcoes[] = (new Transportadora)->faixaFrete();
        }
    }

    public function correios()
    {
        $CEPorigem = $this->config_cep->frete_cep_origem;
        $CEPdestino = $_POST['cep'];
        $peso = $_POST['peso'];
        $altura = $_POST['altura'];
        $largura = $_POST['largura'];
        $comprimento = $_POST['comprimento'];
        $_SESSION['mycep'] = (string)$_POST['cep'];

        $data['nCdEmpresa'] = '08082650';
        $data['sDsSenha'] = '564321';
        $data['nCdFormato'] = '1';
        $data['nVlPeso'] = '1';
        $data['nVlComprimento'] = '16';
        $data['nVlAltura'] = '2';
        $data['nVlLargura'] = '11';

        $data['sCepOrigem'] = $CEPorigem;
        $data['sCepDestino'] = $CEPdestino;

        $data['nVlPeso'] = $peso;
        $data['nVlComprimento'] = $comprimento;
        $data['nVlAltura'] = $altura;
        $data['nVlLargura'] = $largura;

        $data['nVlDiametro'] = '0';
        $data['sCdMaoPropria'] = 'n';
        $data['nVlValorDeclarado'] = '0';
        $data['sCdAvisoRecebimento'] = 'n';
        $data['StrRetorno'] = 'xml';
        $servs = array();
        if ($this->config_cep->frete_pac == 1) {
            $servs[] = "04510";
        }
        if ($this->config_cep->frete_sedex == 1) {
            $servs[] = "04014";
        }
        if ($this->config_cep->frete_sedex10 == 1) {
            $servs[] = "40215";
        }
        if (isset($this->config_cep->frete_impresso)) {
            if ($this->config_cep->frete_impresso == 1) {
                $servs[] = "20010";
            }
        }
        $data['nCdServico'] = implode(",", $servs);
        $data = http_build_query($data);
        $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

        $curl = curl_init($url . '?' . $data);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        $result = curl_exec($curl);
        $curl_info = curl_getinfo($curl);
        $resp_code = $curl_info['http_code'];
        if ($resp_code != '200') {
            echo -1;
            exit;
        }
        curl_close($curl);
        $result = @simplexml_load_string($result);
        $cb = "";
        $flag_erro = false;
        if ($result->cServico->Erro == '011') {
            $msg = explode('.', $result->cServico->MsgErro);
            echo '<p><strong>' . $msg[0] . '. </strong></p>';
        }
        foreach ($result->cServico as $row) {
            if ($row->Erro == 0 || $row->Erro == '010' || $row->Erro == '011') {
                switch ($row->Codigo) {
                    case '04510' :
                        $servico = 'Pac';
                        break;
                    case '04014' :
                        $servico = 'Sedex';
                        break;
                    case '40215' :
                        $servico = 'Sedex 10';
                        break;
                    case '20010' :
                        $servico = 'Impresso Normal';
                        break;
                }
                if ($this->config_cep->frete_pac == 0 && $this->config_cep->frete_sedex10 == 0 && $this->config_cep->frete_sedex == 0) {
                    echo "<p class='alert alert-danger'>Não há nenhum método de envio disponível!</p>";
                    break;
                }
                if (isset($this->uri_segment) && in_array('no-cf', $this->uri_segment) && $row->Codigo == '04510') {
                    $_SESSION['mycep_frete'] = "0.00";
                    $servico = 'Encomenda Normal';
                    $row->Valor = "";
                }
                $cb .= '<tr>';
                $cb .= '<td width=20>';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $row->Codigo . '"  t="' . $servico . '" value="' . $row->Valor . '|' . $row->PrazoEntrega . '" v="' . $this->double($row->Valor) . '" p="' . $row->PrazoEntrega . '" />';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $row->Codigo . '">';
                if ($row->Valor == "") {
                    $cb .= 'Frete Grátis';
                } else {
                    $cb .= "R$ " . $row->Valor;
                }
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $row->Codigo . '">';
                $cb .= '<b class=""> ' . $servico . '</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> $row->PrazoEntrega dia(s)</label>";
                $cb .= '</td>';
                $cb .= '</tr>';
            } else {
                if ($flag_erro == false) {
                    switch ($row->Codigo) {
                        case '04510' :
                            $servico = 'Pac';
                            break;
                        case '04014' :
                            $servico = 'Sedex';
                            break;
                        case '40215' :
                            $servico = 'Sedex 10';
                            break;
                        case '20010' :
                            $servico = 'Impresso Normal';
                            break;
                    }
                    if ($this->config_cep->frete_pac == 1 && $row->Codigo == '04510') {
                        $cb .= " &nbsp; &nbsp;  &nbsp;  <small>$servico: $row->MsgErro</small>";
                    }
                    if ($this->config_cep->frete_sedex == 1 && $row->Codigo == '04014') {
                        $cb .= " &nbsp; &nbsp;  &nbsp;  <small>$servico: $row->MsgErro</small>";
                    }
                    if ($this->config_cep->frete_sedex10 == 1 && $row->Codigo == '40215') {
                        // $cb .= " &nbsp; &nbsp;  &nbsp;  <small>$servico: $row->MsgErro</small>";
                    }
                }
            }
        }
        $cb .= "</table>";
        $this->buscaRetirada();
        $this->buscaFreteGratis();
        // NOVAS TRANSPORTADORAS
        $this->frete_opcoes[] = $this->braspress();
        $this->frete_opcoes[] = (new Transportadora)->jamef();
        $this->frete_opcoes[] = (new Transportadora)->tnt();
        $this->frete_opcoes[] = (new Transportadora)->dlog();
        $this->frete_opcoes[] = (new Transportadora)->redcargo();
        $this->frete_opcoes[] = $this->jadlog();
        $this->frete_opcoes[] = $cb;
        echo implode("", $this->frete_opcoes);
    }

    public function braspress()
    {
        if ($this->config_cep->frete_braspress_ativo > 0) {
            $servico = $this->config_cep->frete_braspress_nome;
            $cnpj = $this->config_cep->frete_braspress;
            $dest = preg_replace('/\-/', '', $_POST['cep']);
            $orig = $this->config_cep->frete_cep_origem;
            $_SESSION['mycep'] = (string)$_POST['cep'];
            $tipofrete = 1; //1 CIF - 2 FOB
            $peso = str_replace(',', '.', $_POST['peso']);
            $valornf = 1.00;
            $volume = 1;
            $emporigem = 2;
            $modal = 'R';
            $url = "http://www.braspress.com.br/cotacaoXml?param=";
            $url .= "$cnpj,$emporigem,$orig,$dest,$cnpj,$cnpj,$tipofrete,$peso,$valornf,$volume,$modal";
            $cURL = curl_init();
            curl_setopt_array($cURL, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'cURL Request'
            ));
            $result = utf8_encode(trim(curl_exec($cURL)));
            $frete = simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
            if ($frete->erro) {
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<i class=""> ' . $servico . ' indisponível</i>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> </label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            }
            if ($frete->MSGERRO == 'OK') {
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
        	t="' . $servico . '" value="' . $frete->TOTALFRETE . '|' . $frete->PRAZO . '"
        	v="' . $this->double($frete->TOTALFRETE) . '" p="' . $frete->PRAZO . '" />';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= 'R$ ' . $frete->TOTALFRETE;
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<b class=""> ' . $servico . '</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> $frete->PRAZO dia(s)</label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            }
        }
    }
    public function jadlog()
    {
        if ($this->config_cep->frete_jadlog_ativo > 0) {
            $servico = $this->config_cep->frete_jadlog_nome;
            $vModalidade = 5; //modalidade de entrega
            $password = $this->config_cep->frete_jadlog_senha;
            $seguro = 'N';
            $valordec = "1,00";
            $valorColeta = "0,00";
            $orig = $this->config_cep->frete_cep_origem;
            $dest = preg_replace('/\-/', '', $_POST['cep']);
            $_SESSION['mycep'] = (string)$_POST['cep'];
            $peso = str_replace(',', '.', $_POST['peso']);
            $vFrap = 'N';
            $vEntrega = 'D';
            $cnpj = $this->config_cep->frete_jadlog_cnpj;
            $url = "http://www.jadlog.com.br:8080/JadlogEdiWs/services/ValorFreteBean?method=valorar";
            $url .= "&vModalidade=$vModalidade&Password=$password&vSeguro=$seguro&vVlDec=$valordec&vVlColeta=$valorColeta&vCepOrig=$orig&vCepDest=$dest&vPeso=$peso&vFrap=$vFrap&vEntrega=$vEntrega&vCnpj=$cnpj";

            $cURL = curl_init();
            curl_setopt_array($cURL, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'cURL Request'
            ));
            $result = preg_replace('/\s+/', '', utf8_encode(trim(curl_exec($cURL))));
            $result = explode("Retorno", $result);
            $result = $result[1];
            $frete = new stdClass;
            $frete->Retorno = preg_replace(['/[a-zA-Z]/i', '/&;/', '/\//'], ['', '', ''], trim($result));
            if ($frete->Retorno < 0) {
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<i class=""> ' . $servico . ' indisponível</i>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> </label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            }

            $resultado = self::busca_cep($dest);
            $prazos = [
                'AC' => '19 à 25 dia(s)',
                'AL' => '8 à 13 dia(s)',
                'AM' => '21 à 31 dia(s)',
                'AP' => '18 à 30 dia(s)',
                'BA' => '05 à 20 dia(s)',
                'CE' => '07 à 20 dia(s)',
                'DF' => '03 à 08 dia(s)',
                'ES' => '04 à 15 dia(s)',
                'GO' => '02 à 13 dia(s)',
                'MA' => '09 à 20 dia(s)',
                'MG' => '04 à 14 dia(s)',
                'MS' => '07 à 21 dia(s)',
                'MT' => '11 à 24 dia(s)',
                'PA' => '06 à 25 dia(s)',
                'PB' => '09 à 14 dia(s)',
                'PI' => '11 à 17 dia(s)',
                'PR' => '02 à 07 dia(s)',
                'PE' => '09 à 15 dia(s)',
                'RJ' => '02 à 07 dia(s)',
                'RN' => '12 à 18 dia(s)',
                'RO' => '12 à 22 dia(s)',
                'RR' => '18 à 27 dia(s)',
                'RS' => '03 à 15 dia(s)',
                'SC' => '04 à 12 dia(s)',
                'SE' => '04 à 15 dia(s)',
                'SP' => '02 à 14 dia(s)',
                'TO' => '04 à 17 dia(s)'
            ];
            $prazoFrete = $prazos[strtoupper($resultado['uf'])];
            $frete->PRAZO = $prazoFrete;
            if ($frete->Retorno > 0) {
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
        	t="' . $servico . '" value="' . $frete->Retorno . '|' . $frete->PRAZO . '"
        	v="' . $this->double($frete->Retorno) . '" p="' . $frete->PRAZO . '" />';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= 'R$ ' . $frete->Retorno;
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<b class=""> ' . $servico . '</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> $frete->PRAZO</label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            }
        }
    }
    public function busca_cep($cep)
    {
        $resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep=' . urlencode($cep) . '&formato=query_string');
        if (!$resultado) {
            $resultado = "&resultado=0&resultado_txt=erro+ao+buscar+cep";
        }
        parse_str($resultado, $retorno);
        return $retorno;
    }

    public function double($str)
    {
        return preg_replace('/,/', '.', $str);
    }
}