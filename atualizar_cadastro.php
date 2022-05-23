<?php

    require_once('conexao_bd.php');
    require_once('bd_queries.php');

    $objDb = new db;
    $link = $objDb->conecta_db();

    function data_hora_formatada($data_hora){
        $data_formatada = explode('-', $data_hora);
        $data_formatada[2] = explode(' ', $data_formatada[2]);
        $hora_formatada = $data_formatada[2][1];
        $data_formatada[2] = $data_formatada[2][0];

        $data_inicial_formatada = $data_formatada[2] . '/' . $data_formatada[1] . '/' . $data_formatada[0] . ' ' . $hora_formatada;
        return $data_inicial_formatada;
    }

    function data_formatada($data_hora){
        $data_formatada = explode('-', $data_hora);

        $dia = $data_formatada[2];
        $mes = $data_formatada[1];
        $ano = $data_formatada[0];

        $data_inicial_formatada = "$dia/$mes/$ano";
        return $data_inicial_formatada;
    }

    $pessoa_id = $_POST['pessoa_id'];
    $endereco_id = $_POST['endereco_id'];
    $telefone_id = $_POST['telefone_id'];
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $uf = $_POST['uf'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];

    date_default_timezone_set('America/Sao_Paulo');
	$data_atualizacao = date('Y-m-d H:i:s');

    atualizarCadastro($pessoa_id, $endereco_id, $telefone_id, $data_atualizacao, $nome, $cpf, $rg, $data_nascimento, $telefone, $cep, $uf, $endereco, $numero);

    $dados = mostraCadastros($pessoa_id);

    echo json_encode(array(
        "nome" => $dados['nome'],
        "cpf" => $dados['cpf'],
        "rg" => $dados['rg'],
        "data_nascimento" => data_formatada($dados['data_nascimento']),
        "data_cadastro" => data_hora_formatada($dados['data_cadastro']),
        "data_atualizacao" => data_hora_formatada($dados['data_atualizacao']),
        "data_exclusao" => data_hora_formatada($dados['data_exclusao']),
        "telefone" => $dados['telefone'],
        "cep" => $dados['cep'],
        "uf"=> $dados['uf'],
        "endereco" => $dados['endereco'],
        "numero" => $dados['numero']
    ));
    

?>