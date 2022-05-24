<?php

    require_once('conexao_bd.php');

    function dadosUsuario($usuario, $senha){

        $objDb = new db;
        $link = $objDb->conecta_db();

        $sql = "SELECT * FROM usuarios WHERE usuario = '$usuario' AND senha = '$senha'";

        $dados_usuario = array();

        if($resultado_query = mysqli_query($link, $sql)){
            $dados_usuario = mysqli_fetch_array($resultado_query);
            return $dados_usuario;
        } else  {
            die(mysqli_error($link));
        }

    }

    function selectUF(){

        $objDb = new db;
        $link = $objDb->conecta_db();

        $sql = "SELECT * FROM estados";

        $resultado_query = mysqli_query($link, $sql);

        $ufs = array();

        if($resultado_query){
            while($linha = mysqli_fetch_array($resultado_query)){
                $ufs[] = $linha;
            }
            return $ufs;
        } else  {
            die(mysqli_error($link));
        }
        
    }

    function registraPessoa($nome, $cpf, $rg, $data_nascimento, $telefone, $cep, $uf, $endereco, $numero) {

        $objDb = new db;
        $link = $objDb->conecta_db();

        $sql = "INSERT INTO enderecos(estado_id, cep, endereco, numero ) VALUES ('$uf', '$cep', '$endereco', '$numero' )";

        mysqli_query($link, $sql) or die(mysqli_error($link));

        $sql = "SELECT id FROM enderecos WHERE estado_id = '$uf' AND cep = '$cep' AND endereco = '$endereco' AND numero = '$numero'";

        $resultado_query = mysqli_query($link, $sql);
        $id_endereco_array = array();

        if($resultado_query) {
            $id_endereco_array = mysqli_fetch_array($resultado_query);
        } else {
            mysqli_error($link);
        }

        $id_endereco = $id_endereco_array['id'];

        date_default_timezone_set('America/Sao_Paulo');
		$data_cadastro = date('Y-m-d H:i:s');

        $sql = "INSERT INTO pessoas(endereco_id, nome, cpf, rg, data_nascimento, data_cadastro) VALUES('$id_endereco', '$nome', '$cpf', '$rg', '$data_nascimento', '$data_cadastro')";

        mysqli_query($link, $sql) or mysqli_error($link);

        $sql = "SELECT id FROM pessoas WHERE endereco_id = '$id_endereco' AND nome = '$nome' AND cpf = '$cpf' AND rg = '$rg' AND data_nascimento = '$data_nascimento' AND data_cadastro = '$data_cadastro'";

        $resultado_query = mysqli_query($link, $sql);
        $id_pessoa_array = array();

        if($resultado_query) {
            $id_pessoa_array = mysqli_fetch_array($resultado_query);
        } else {
            mysqli_error($link);
        }

        $id_pessoa = $id_pessoa_array['id'];

        $sql = "INSERT INTO telefones(pessoa_id, telefone) VALUES('$id_pessoa', '$telefone')";

        mysqli_query($link, $sql) or mysqli_error($link);

    }

    function mostrarCadastros($pessoa_id = null){

        $where = '';

        if(!empty($pessoa_id)){
            $where = " p.id = $pessoa_id";
        }

        $objDb = new db;
        $link = $objDb->conecta_db();

        $sql = "SELECT p.id, p.nome, p.cpf, p.rg, p.data_nascimento, p.data_cadastro, p.data_atualizacao, p.data_exclusao, tel.id, tel.telefone, e.id, e.cep, e.endereco, e.numero, est.uf FROM pessoas AS p INNER JOIN enderecos AS e ON(p.endereco_id = e.id) LEFT JOIN telefones AS tel ON(p.id = tel.pessoa_id) INNER JOIN estados AS est ON (est.id = e.estado_id) ORDER BY p.id DESC";

        $resultado_query = mysqli_query($link, $sql);
        
        $tabela_pessoas = array();

        if($resultado_query){
            while($linha = mysqli_fetch_array($resultado_query)){
                $tabela_pessoas[] = $linha;
            }
        } else  {
            die(mysqli_error($link));
        }

        return $tabela_pessoas;

    }

    function atualizarCadastro($pessoa_id, $endereco_id, $telefone_id, $data_atualizacao, $nome, $cpf, $rg, $data_nascimento, $telefone, $cep, $uf, $endereco, $numero) {

        $objDb = new db;
        $link = $objDb->conecta_db();

        $sql = "UPDATE enderecos SET cep = '$cep', endereco = '$endereco', numero = '$numero', estado_id = '$uf' WHERE id = '$endereco_id'";

        mysqli_query($link, $sql) or die(mysqli_error($link));

        $sql = "UPDATE pessoas SET nome = '$nome', cpf = '$cpf', rg = '$rg', data_nascimento = '$data_nascimento', data_atualizacao = '$data_atualizacao' WHERE id = '$pessoa_id'";

        mysqli_query($link, $sql) or die(mysqli_error($link));

        $sql = "UPDATE telefones SET telefone = '$telefone' WHERE id = '$telefone_id'";

        mysqli_query($link, $sql) or die(mysqli_error($link));

    }

    function deletarCadastro($pessoa_id, $endereco_id, $telefone_id, $data_exclusao){

        $objDb = new db;
        $link = $objDb->conecta_db();

        $sql = "UPDATE pessoas SET data_exclusao = '$data_exclusao' WHERE id = '$pessoa_id'";

        mysqli_query($link, $sql) or die(mysqli_error($link));

        $sql="DELETE FROM telefones WHERE id = '$telefone_id'";

        mysqli_query($link, $sql) or die(mysqli_error($link));

        $sql="DELETE FROM enderecos WHERE id = '$endereco_id'";

        /* -----Redirecionamento----- NO MAC OS não está funcionando no try catch da função*/
        try{
            mysqli_query($link, $sql);
        } catch(mysqli_sql_exception) {
            die(header('location:home.php?erro=0'));
        } 
        

        //*********** */
        // Se usar o MAC OS, retornar, pois não está redirecionando no try catch da função
        //return mysqli_query($link, $sql);

    }

?>