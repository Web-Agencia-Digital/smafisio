<?php

class Transportadora extends Frete
{
    public function __construct()
    {
        parent:: __construct();
    }


    public function faixaFrete()
    {
        $this->cep = $_POST['cep'];
        $cep_formatado = intval(str_replace('-', '', $this->cep));
        $peso = floatval(str_replace(',', '.', $_POST['peso']));
        $this->select()
            ->from('faixacep')
            ->execute();
        if ($this->result()) {
            $data = $this->data;
            foreach ($data as $k) {
                $peso_de = floatval(str_replace(',', '.', $k['faixacep_peso_de']));
                $peso_ate = floatval(str_replace(',', '.', $k['faixacep_peso_ate']));
                if (($cep_formatado >= intval($k['faixacep_cep_inicio']) && $cep_formatado <= intval($k['faixacep_cep_final'])) && ($peso >= $peso_de && $peso <= $peso_ate)) {
                    $valor = $k['faixacep_valor'];
                    $valor_text = 'R$ ';
                    $valor_text .= $valor;
                    if ($valor == '0,00' || intval($valor) <= 0) {
                        $valor_text = 'GrÃ¡tis';
                    }
                    $prazo = $k['faixacep_prazo'];
                    $servico = $k['faixacep_desc'];
                    $cb = '<tr>';
                    $cb .= '<td width=20>';
                    $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
                    t="' . $servico . '" value="' . $valor . '|' . $prazo . '"
                    v="' . $this->double($valor) . '" p="' . $prazo . '" />';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= $valor_text;
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '<b class=""> ' . $servico . '</b>';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= "<label for='003-diff'> $prazo </label>";
                    $cb .= '</td>';
                    $cb .= '<tr>';
                    return $cb;
                    break;
                }
            }
        }
    }

    public function jamef()
    {
        if ($this->config_cep->frete_jamef_ativo > 0) {
            if (!isset($_SESSION['FRETE_CIDADE'])) {
                $origem = (object)$this->busca_cep($this->cep_origem);
                $_SESSION['FRETE_CIDADE'] = $origem->cidade;
                $_SESSION['FRETE_UF'] = $origem->uf;
            }
            $this->cidade_origem = $_SESSION['FRETE_CIDADE'];
            $this->uf_origem = $_SESSION['FRETE_UF'];
            /* CREDENCIAIS JAMEF */
            $cidade_origem = $this->cidade_origem;
            $uf_origem = $this->uf_origem;
            $cnpj = $this->config_cep->frete_jamef_cnpj;
            $user_jamef = $this->config_cep->frete_jamef_user;
            $filial_jamef = $this->config_cep->frete_jamef_filial;
            $nome_jamef = $this->config_cep->frete_jamef_nome;
            /* CREDENCIAIS JAMEF */

            $cont = 0;
            foreach ($_SESSION['cart'] as $k => $v) {
                $qtd = intval($_SESSION['cart'][$k]['item_qtde']);
                $comprimento = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_comprimento'])));
                $val[$cont]['comprimento'] = $comprimento;
                $cont++;
            }
            $comprimento_final = 0;
            foreach ($val as $k) {
                $comprimento_final += $k['comprimento'];
            }

            $peso = str_replace(',', '.', $_POST['peso']);
            $altura = str_replace(',', '.', $_POST['altura']);
            $largura = str_replace(',', '.', $_POST['largura']);
            $comprimento = str_replace(',', '.', $comprimento_final);
            $dest = preg_replace('/\-/', '', $_POST['cep']);
            $_SESSION['mycep'] = (string)$_POST['cep'];
            $peso = str_replace(',', '.', $peso);
            $altura = str_replace(',', '.', ($altura / 100));
            $largura = str_replace(',', '.', ($largura / 100));
            $comprimento = str_replace(',', '.', ($comprimento / 100));
            $metro_cubico = number_format(($altura * $comprimento * $largura), 7, '.', '');
            $valornf = 1.00;
            $servico = $nome_jamef;
            $dia = date('d');
            $mes = date('m');
            $ano = date('Y');
            $url = "https://www.jamef.com.br/frete/rest/v1/1/$cnpj/$cidade_origem/$uf_origem/000004/";
            $url .= "$peso/$valornf/$metro_cubico/$dest/$filial_jamef/$dia/$mes/$ano/$user_jamef/";
            $cURL = curl_init();
            curl_setopt_array($cURL, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'cURL Request'
            ));
            $result = json_decode(utf8_encode(trim(curl_exec($cURL))));
            if (empty($result) && !isset($result->valor) && !isset($result->previsao_entrega)) {
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<i class=""> Entrega ' . $servico . ' indisponÃ­vel</i>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> </label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            } else {
                $today = date('Y-m-d');
                $previsao = explode('/', $result->previsao_entrega);
                $previsao = $previsao[2] . '-' . $previsao[1] . '-' . $previsao[0];
                $diferenca = strtotime($previsao) - strtotime($today);
                $result->previsao_entrega = intval(floor($diferenca / (60 * 60 * 24)));
                $result->valor = number_format($result->valor, 2, '.', '');
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
    		t="' . $servico . '" value="' . $result->valor . '|' . $result->previsao_entrega . '"
    		v="' . $this->double($result->valor) . '" p="' . $result->previsao_entrega . '" />';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= 'R$ ' . str_replace('.', ',', $result->valor);
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<b class=""> ' . $servico . '</b>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> $result->previsao_entrega dia(s)</label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            }
        }
    }

    public function tnt()
    {
        if ($this->config_cep->frete_tnt_ativo > 0) {

            /* CREDENCIAIS TNT */
            $login_tnt = $this->config_cep->frete_tnt_login;
            $remetenteId = $this->config_cep->frete_tnt_remid;
            $remetenteInscEst = $this->config_cep->frete_tnt_ie;
            $tipoServico = $this->config_cep->frete_tnt_tipo; // RNC
            $tipoFrete = $this->config_cep->frete_tnt_tipo_frete; // C
            $situTribu = $this->config_cep->frete_tnt_tributaria; // C
            $codDivisao = $this->config_cep->frete_tnt_divisao; // C


            /* CREDENCIAIS TNT */

            $cont = 0;
            foreach ($_SESSION['cart'] as $k => $v) {
                $qtd = intval($_SESSION['cart'][$k]['item_qtde']);
                $peso = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_peso'])));
                $altura = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_altura'])));
                $largura = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_largura'])));
                $comprimento = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_comprimento'])));

                $val[$cont]['peso'] = $peso;
                $val[$cont]['altura'] = $altura;
                $val[$cont]['largura'] = $largura;
                $val[$cont]['comprimento'] = $comprimento;
                $cont++;
            }
            $peso_final = 0;
            $altura_final = 0;
            $largura_final = 0;
            $comprimento_final = 0;
            foreach ($val as $k) {
                $peso_final += $k['peso'];
                $altura_final += $k['altura'];
                $largura_final += $k['largura'];
                $comprimento_final += $k['comprimento'];
            }

            $peso = str_replace(',', '.', $_POST['peso']);
            $dest = preg_replace('/\-/', '', $_POST['cep']);
            $orig = $this->config_cep->frete_cep_origem;
            $_SESSION['mycep'] = (string)$_POST['cep'];

            $valor = str_replace(',', '.', $_SESSION['__TOTAL__COMPRA__']);
            $servico = $this->config_cep->frete_tnt_nome;
            $xmlr = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ser="http://service.calculoFrete.mercurio.com" xmlns:mod="http://model.vendas.lms.mercurio.com">
<soapenv:Header/>
<soapenv:Body>
<ser:calculaFrete>
<ser:in0>
<mod:login>' . $login_tnt . '</mod:login>
<mod:senha></mod:senha>
<mod:nrIdentifClienteRem>' . $remetenteId . '</mod:nrIdentifClienteRem>
<mod:nrIdentifClienteDest>00000000191</mod:nrIdentifClienteDest>
<mod:tpFrete>' . $tipoFrete . '</mod:tpFrete>
<mod:tpServico>' . $tipoServico . '</mod:tpServico>
<mod:cepOrigem>' . $orig . '</mod:cepOrigem>
<mod:cepDestino>' . $dest . '</mod:cepDestino>
<mod:vlMercadoria>' . $valor . '</mod:vlMercadoria>
<mod:psReal>' . $peso . '</mod:psReal>
<mod:nrInscricaoEstadualRemetente>' . $remetenteInscEst . '</mod:nrInscricaoEstadualRemetente>
<mod:nrInscricaoEstadualDestinatario></mod:nrInscricaoEstadualDestinatario>
<mod:tpSituacaoTributariaRemetente>' . $situTribu . '</mod:tpSituacaoTributariaRemetente>
<mod:tpSituacaoTributariaDestinatario>CO</mod:tpSituacaoTributariaDestinatario>
<mod:cdDivisaoCliente>' . $codDivisao . '</mod:cdDivisaoCliente>
<mod:tpPessoaRemetente>J</mod:tpPessoaRemetente>
<mod:tpPessoaDestinatario>F</mod:tpPessoaDestinatario>
</ser:in0>
</ser:calculaFrete>
</soapenv:Body>
</soapenv:Envelope>';
            // Chama o webservice
            $location_URL = 'http://ws.tntbrasil.com.br/tntws/CalculoFrete?wsdl';
            $uri = 'http://service.calculoFrete.mercurio.com';
            $action_URL = 'http://ws.tntbrasil.com.br/tntws/CalculoFrete';
            $client = new SoapClient(null, array(
                'location' => $location_URL,
                'uri' => $uri,
                'trace' => 1,
            ));
            $xml = $client->__doRequest($xmlr, $location_URL, $action_URL, 1);
            $dom = new DOMDocument('1.0', 'ISO-8859-1');
            $dom->loadXml($xml);
            //$municipio = $dom->getElementsByTagName('nmMunicipioDestino')->item(0)->nodeValue;
            $vltotal = $dom->getElementsByTagName('vlTotalFrete')->item(0)->nodeValue;
            $prazo = $dom->getElementsByTagName('prazoEntrega')->item(0)->nodeValue;

            if (isset($vltotal) && !empty($vltotal)) {
                if (empty($vltotal) && !isset($vltotal)) {
                    $cb = '<tr>';
                    $cb .= '<td width=20>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '<i class=""> Entrega ' . $servico . ' indisponÃ­vel</i>';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= "<label for='003-diff'> </label>";
                    $cb .= '</td>';
                    $cb .= '<tr>';
                    return $cb;
                } else {
                    $cb = '';
                    $prazoEntrega = $prazo;
                    $valorFrete = $vltotal;
                    $cb .= '<tr>';
                    $cb .= '<td width=20>';
                    $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
                t="' . $servico . '" value="' . $valorFrete . '|' . $prazoEntrega . '"
                v="' . $this->double($valorFrete) . '" p="' . $prazoEntrega . '" />';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= 'R$ ' . str_replace('.', ',', $valorFrete);
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '<b class=""> ' . $servico . '</b>';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= "<label for='003-diff'> $prazoEntrega dia(s)</label>";
                    $cb .= '</td>';
                    $cb .= '<tr>';
                    return $cb;
                }
            }
        }
    }

    public function redcargo()
    {
        if ($this->config_cep->frete_redecargo_ativo > 0) {
            /* CREDENCIAIS REDECARGO */
            $chave = $this->config_cep->frete_redecargo_chave;
            /* CREDENCIAIS REDECARGO */
            $cont = 0;
            foreach ($_SESSION['cart'] as $k => $v) {
                $qtd = intval($_SESSION['cart'][$k]['item_qtde']);
                $peso = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_peso'])));
                $altura = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_altura'])));
                $largura = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_largura'])));
                $comprimento = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_comprimento'])));

                $val[$cont]['peso'] = $peso;
                $val[$cont]['altura'] = $altura;
                $val[$cont]['largura'] = $largura;
                $val[$cont]['comprimento'] = $comprimento;
                $cont++;
            }
            $peso_final = 0;
            $altura_final = 0;
            $largura_final = 0;
            $comprimento_final = 0;
            foreach ($val as $k) {
                $peso_final += $k['peso'];
                $altura_final += $k['altura'];
                $largura_final += $k['largura'];
                $comprimento_final += $k['comprimento'];
            }
            $dest = preg_replace('/\-/', '', $_POST['cep']);
            $_SESSION['mycep'] = (string)$_POST['cep'];
            $valor = str_replace(',', '.', $_SESSION['__TOTAL__COMPRA__']);
            $servico = $this->config_cep->frete_redecargo_nome;;
            $url = "http://redcargo.ws.brudam.com.br/cotacao/frete?wsdl";
            $objOpt = array('trace' => 1, 'exceptions' => 0);
            $objCall = array('CalculoFreteRequest' => array(
                "chave" => "$chave",
                "cepdestinatario" => "$dest",
                "volumes" => intval($qtd),
                "peso" => $peso_final,
                "valor" => $valor)
            );
            $result = new SoapClient($url, $objOpt);
            $result = $result->__soapCall("CalculoFrete", $objCall);
            if (isset($result->status) && $result->status == 1) {
                $result = $result->servicos->item;
                if (empty($result) && !isset($result[0])) {
                    $cb = '<tr>';
                    $cb .= '<td width=20>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '<i class=""> ' . $servico . ' indisponÃ­vel</i>';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= "<label for='003-diff'> </label>";
                    $cb .= '</td>';
                    $cb .= '<tr>';
                    return $cb;
                } else {
                    $cb = '';
                    $prazoEntrega = intval($result->prazoEntrega) + 5;
                    $valorFrete = number_format($result->valorFrete, 2, '.', '');
                    $cb .= '<tr>';
                    $cb .= '<td width=20>';
                    $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
                t="' . $servico . '" value="' . $valorFrete . '|' . $prazoEntrega . '"
                v="' . $this->double($valorFrete) . '" p="' . $prazoEntrega . '" />';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= 'R$ ' . str_replace('.', ',', $valorFrete);
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '<b class=""> ' . $servico . '</b>';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= "<label for='003-diff'> $prazoEntrega dia(s)</label>";
                    $cb .= '</td>';
                    $cb .= '<tr>';
                    return $cb;
                }
            }
        }
    }

    public function dlog()
    {
        if ($this->config_cep->frete_dlog_ativo > 0) {
            /* CREDENCIAIS DLOG */
            $login = $this->config_cep->frete_dlog_login;
            $token = $this->config_cep->frete_dlog_token;
            /* CREDENCIAIS DLOG */
            $cont = 0;
            foreach ($_SESSION['cart'] as $k => $v) {
                $qtd = intval($_SESSION['cart'][$k]['item_qtde']);
                $comprimento = ($qtd * floatval(str_replace(',', '.', $_SESSION['cart'][$k]['item_comprimento'])));
                $val[$cont]['comprimento'] = $comprimento;
                $cont++;
            }
            $comprimento_final = 0;
            foreach ($val as $k) {
                $comprimento_final += $k['comprimento'];
            }
            $peso = str_replace(',', '.', $_POST['peso']);
            $altura = str_replace(',', '.', $_POST['altura']);
            $largura = str_replace(',', '.', $_POST['largura']);
            $comprimento = str_replace(',', '.', $comprimento_final);
            $dest = preg_replace('/\-/', '', $_POST['cep']);
            $_SESSION['mycep'] = (string)$_POST['cep'];
            $valor = str_replace(',', '.', $_SESSION['__TOTAL__COMPRA__']);
            $servico = $this->config_cep->frete_dlog_nome;

            $url = "http://www.dlog.com.br/webservice/frete/?ClieCod=189&login=$login&token=$token";
            $url .= "&vPed=$valor&peso=$peso&compr=$comprimento&larg=$largura&alt=$altura&cep=$dest&Format=json";
            $cURL = curl_init();
            curl_setopt_array($cURL, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_FOLLOWLOCATION => 1,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_URL => $url,
                CURLOPT_USERAGENT => 'cURL Request'
            ));
            $result = json_decode(utf8_encode(trim(curl_exec($cURL))));
            $result = $result->Frete;
            if (empty($result) && !isset($result[0])) {
                $cb = '<tr>';
                $cb .= '<td width=20>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= '<label for="' . $servico . '">';
                $cb .= '<i class=""> ' . $servico . ' indisponÃ­vel</i>';
                $cb .= '</label>';
                $cb .= '</td>';
                $cb .= '<td>';
                $cb .= "<label for='003-diff'> </label>";
                $cb .= '</td>';
                $cb .= '<tr>';
                return $cb;
            } else {
                $cb = '';
                foreach ($result as $k) {
                    $k->Prazo = intval($k->Prazo) + 5;
                    $k->FreteValor = number_format($k->FreteValor, 2, '.', '');
                    $cb .= '<tr>';
                    $cb .= '<td width=20>';
                    $cb .= '<input type="radio" class="btn-update-frete" name="tipo_frete[]" id="' . $servico . '"
      			t="' . $servico . '" value="' . $k->FreteValor . '|' . $k->Prazo . '"
  		    	v="' . $this->double($k->FreteValor) . '" p="' . $k->Prazo . '" />';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= 'R$ ' . str_replace('.', ',', $k->FreteValor);
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= '<label for="' . $servico . '">';
                    $cb .= '<b class=""> ' . $servico . '</b>';
                    $cb .= '</label>';
                    $cb .= '</td>';
                    $cb .= '<td>';
                    $cb .= "<label for='003-diff'> $k->Prazo dia(s)</label>";
                    $cb .= '</td>';
                    $cb .= '<tr>';
                }
                return $cb;
            }
        }
    }
}