<?php

    require_once('conexao_bd.php');
    require_once('bd_queries.php');

    $objDb = new db;
    $link = $objDb->conecta_db();

    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $data_nascimento = $_POST['data_nascimento'];
    $telefone = $_POST['telefone'];
    $cep = $_POST['cep'];
    $uf = $_POST['uf'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];

    if($_POST['action'] == 'Registrar'){

        registraPessoa($nome, $cpf, $rg, $data_nascimento, $telefone, $cep, $uf, $endereco, $numero);

        header('location: home.php?msg=0');

    } else if($_POST['action'] == 'Atualizar') {
        
        $pessoa_id = $_POST['pessoa_id'];
        $endereco_id = $_POST['endereco_id'];
        $telefone_id = $_POST['telefone_id'];

        date_default_timezone_set('America/Sao_Paulo');
        $data_atualizacao = date('Y-m-d H:i:s');

        atualizarCadastro($pessoa_id, $endereco_id, $telefone_id, $data_atualizacao, $nome, $cpf, $rg, $data_nascimento, $telefone, $cep, $uf, $endereco, $numero);

        header('location: home.php?msg=0');
        // Estou acostumado a fazer dessa forma, mas pelo que eu pude pesquisar sobre o padrão MVC, deve ter um script intermediário entre o model e o view, correto ? por isso criei uma classe chamada 'controller.js' onde ele é responsável por fazer essa ligação entre essas duas camadas.

    } else if($_POST['action'] == 'Deletar') {
        
        $pessoa_id = $_POST['pessoa_id'];
        $endereco_id = $_POST['endereco_id'];
        $telefone_id = $_POST['telefone_id'];

        date_default_timezone_set('America/Sao_Paulo');
        $data_exclusao = date('Y-m-d H:i:s');

        //******** */ Não estava redirecionando na funcão, então retornei para definir o redirecionamento
        $resultado_query = deletarCadastro($pessoa_id, $endereco_id, $telefone_id, $data_exclusao);
        
        //******** */ Não estava redirecionando na funcão, então retornei para definir o redirecionamento
        if($resultado_query){
            header('location:home.php?msg=0');
        } else {
            header('location:home.php?erro=0');
        }

        //header('location: home.php?msg=Operação concluída.');

        // Estou acostumado a fazer dessa forma, mas pelo que eu pude pesquisar sobre o padrão MVC, deve ter um script intermediário entre o model e o view, correto ? por isso criei uma classe chamada 'controller.js' onde ele é responsável por fazer essa ligação entre essas duas camadas.

    }

?>