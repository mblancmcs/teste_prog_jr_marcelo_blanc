<?php

    require_once('conexao_bd.php');
    require_once('bd_queries.php');
    session_start();

    $objDb = new db();
    $link = $objDb->conecta_db();

    $usuario = $_POST['usuario'];
    $senha = md5($_POST['senha']);
    
    $dados_usuario = dadosUsuario($usuario, $senha);

    if(isset($dados_usuario['id']) && $dados_usuario['id'] != ''){
        $_SESSION['usuario'] = $usuario;
        $_SESSION['senha'] = $senha;

        header('location:home.php');
    } else  {
        header('location: index.php?erro=0');
    }

?>