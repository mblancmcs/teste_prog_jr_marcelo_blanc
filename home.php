<?php

    require_once('conexao_bd.php');
    require_once('bd_queries.php');
    
    $estados = selectUf();
    $tabela_pessoas = mostrarCadastros();

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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--JQuery-->
    <script src="./jquery/jquery-3.6.0.min.js" ></script>
    
    <link rel="stylesheet" href="./assets/css/style.css" type="text/css" />

    <!-- Mascara JQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.11/jquery.mask.min.js"></script>

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <title>Pag. de Login</title>
    <script>

        $(document).ready(function(){

            $('#btn_registrar').click(function(){

                if($('.uf').val() == '0'){
                    alert('Preencha o estado');
                    return false;
                }
                /*
                $.ajax({
                    url:'crud_pessoas.php',
                    method:'post',
                    data: $('#form-cadastro').serialize(),
                    success: function(data){
                        alert('Registro concluído');
                    }
                });
                */
            });

            $('.telefone').mask('(00)00000-0000');
            $('.rg').mask('00.000.000-0');
            $('.cpf').mask('000.000.000-00');
            $('.cep').mask('00.000-000');

        });
        /*
        function atzCadastro(cont){

            let idCadastro = '#form_atualizar_deletar' + cont;
            $.ajax({
                url: 'atualizarCadastro.php',
                method: 'post',
                data: $(idCadastro).serialize(),

                success: function(data){
                    const resultado = JSON.parse(data);
                    $('#nome'+cont).val(resultado.nome);
                    $('#cpf'+cont).val(resultado.cpf);
                    $('#rg'+cont).val(resultado.rg);
                    $('#data_nascimento'+cont).val(resultado.data_nascimento);
                    $('#data_cadastro'+cont).val(resultado.data_cadastro);
                    $('#data_atualizacao'+cont).html(resultado.data_atualizacao);
                    $('#data_exclusao'+cont).html(resultado.data_exclusao);
                    $('#telefone'+cont).html(resultado.telefone);
                    $('#cep'+cont).html(resultado.cep);
                    $('#endereco'+cont).html(resultado.endereco);
                    $('#numero'+cont).html(resultado.numero);
                    $('#uf'+cont).html(resultado.uf);
                }
            })
        }
        */
        function showModal(id){
            $("#modal"+id).modal("show");
        }

    </script>
</head>
<body>
    <div class="cabecalho" >
        <span>Teste para programador júnior da WebDec - Marcelo Blanc </span>
    </div>
    <div class="container">
        <div class="container2">
            <form id="form-cadastro" action="crud_pessoas.php" method="post">

                <h1>Cadastro de pessoas:</h1>

                <label class="espaco-label" for="nome">Nome:
                <input id="nome" name="nome" type="text" maxlength="255" required /></label>
                <label class="espaco-label" for="cpf" >CPF:
                <input id="cpf" class="cpf" name="cpf" type="text" pattern="([0-9]{3}\.){2}[0-9]{3}-[0-9]{2}" required /></label>
                <label class="espaco-label" for="rg" >RG:
                <input id="rg" class="rg" name="rg" type="text" pattern="[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[0-9]{1}"  /></label>
                <label class="espaco-label" for="data_nascimento" >Data de nascimento:
                <input id="data_nascimento" name="data_nascimento" type="date" required /></label>
                <label class="espaco-label" for="telefone" >Telefone
                <input id="telefone" class="telefone" name="telefone" type="text" pattern="\([0-9]{2}\)[0-9]{5}-[0-9]{4}"  /></label>
                
                <fieldset>
                    <legend>Endereço</legend>
                    <label for="cep" >CEP:</label>
                    <input id="cep" class="cep" name="cep" type="text" pattern="[0-9]{2}\.[0-9]{3}-[0-9]{3}"  />
                    <label for="uf" >Estado:</label>
                    <select id="uf" class="uf" name="uf">
                        <option value="0">UF</option>
                        <?php
                            foreach($estados as $estado){
                                echo '<option value="'. $estado['id'] .'" >'. $estado['uf'] .'</option>';
                            }
                        ?>
                    </select>
                    <label for="endereco" >Endereço:</label>
                    <input id="endereco" name="endereco" type="text" maxlength="255" required />
                    <label for="numero" >Numero:</label>
                    <input id="numero" name="numero" type="text" maxlength="255" required />
                </fieldset>
                <br />
                <button id="btn_registrar" type="submmit" name="action" value="Registrar" >Registrar</button>
            </form>
        </div>
        
        <?php
            if(isset($_GET['erro'])) {
                switch($_GET['erro']){
                    case 0:
                        echo '<p style="color:red;text-align: center;">Não é possível excluir os dados da tabela "enderecos", pois há uma chave estrangeira dessa tabela na tabela "pessoas", porém seria possível se excluíssemos a tabela "pessoas" antes da "enderecos", mas não daria para ver a data de exclusão, sendo assim só está sendo excluído o registro da tabela "telefones".</p>';
                        break;
                }
            } else if(isset($_GET['msg'])){
                switch($_GET['erro']){
                    case 0:
                        echo '<p style="color:green;text-align: center;">Operação concluída.</p>';
                        break;
                }
            }
        ?>

        <div class="tabela-responsiva">
            <h2>Cadastros realizados (atualizar / deletar)</h2>
            <table rules="all">
                <thead>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>RG</th>
                    <th>Data de nasc.</th>
                    <th>Data de cadastro</th>
                    <th>Data de atualização</th>
                    <th>Data de exclusão</th>
                    <th>Telefone</th>
                    <th>CEP</th>
                    <th>Endereço</th>
                    <th>Número</th>
                    <th>UF</th>
                    <th>Atz.</th>
                    <th>Del.</th>
                </thead>
                <tbody>

                    <?php for($i=0; $i < count($tabela_pessoas); $i++) { ?>
                    <tr>
                        <form id="form_atualizar_deletar<?=$i?>" method="post" action="crud_pessoas.php">
                            <input type="hidden" name="pessoa_id" value="<?= $tabela_pessoas[$i]['id'] ?>" />
                            <input type="hidden" name="endereco_id" value="<?= $tabela_pessoas[$i][10] ?>" />
                            <input type="hidden" name="telefone_id" value="<?= $tabela_pessoas[$i][8] ?>" />
                            <td><input id="nome<?=$i?>" class="input-tabela" type="text" name="nome" value="<?= $tabela_pessoas[$i]['nome'] ?>" /></td>
                            <td><input id="cpf<?=$i?>" class="input-tabela cpf" type="text" name="cpf" value="<?= $tabela_pessoas[$i]['cpf'] ?>" /></td>
                            <td><input id="rg<?=$i?>" class="input-tabela rg" type="text" name="rg" value="<?= $tabela_pessoas[$i]['rg'] ?>" /></td>
                            <td><input id="data_nascimento<?=$i?>" style="width:105px" type="date" name="data_nascimento" value="<?= $tabela_pessoas[$i]['data_nascimento'] ?>" /></td>
                            <td><input id="data_cadastro<?=$i?>" style="width:150px; background: lightgrey;" type="text" name="data_cadastro" readonly  value="<?= $tabela_pessoas[$i]['data_cadastro'] ?>" /></td>
                            <td><input id="data_atualizacao<?=$i?>" style="width:150px; background: lightgrey;" type="text" name="data_atualizacao" readonly value="<?= $tabela_pessoas[$i]['data_atualizacao'] ?>" /></td>
                            <td><input id="data_exclusao<?=$i?>" style="width:150px; color:red; background: lightgrey;" type="text" name="data_exclusao" readonly value="<?= $tabela_pessoas[$i]['data_exclusao'] ?>" /></td>
                            <td><input id="telefone<?=$i?>" class="input-tabela telefone" type="text" name="telefone" <?php if(!empty($tabela_pessoas[$i]['telefone'])){ echo 'value="'.$tabela_pessoas[$i]['telefone'].'"'; } else { echo 'style="color:red" value="(00)00000-0000"'; } ?> /></td>
                            <td><input id="cep<?=$i?>" class="input-tabela cep" type="text" name="cep" value="<?= $tabela_pessoas[$i]['cep'] ?>" /></td>
                            <td><input id="endereco<?=$i?>" class="input-tabela" type="text" name="endereco" value="<?= $tabela_pessoas[$i]['endereco'] ?>" /></td>
                            <td><input id="numero<?=$i?>" class="input-tabela" type="text" name="numero" value="<?= $tabela_pessoas[$i]['numero'] ?>" /></td>
                            <td>
                                <select id="uf<?=$i?>" class="uf" name="uf">
                                    <option value="0">UF</option>
                                    <?php
                                        foreach($estados as $estado){
                                            if($tabela_pessoas[$i]['uf'] == $estado['uf']){
                                                echo '<option selected value="'. $estado['id'] .'" >'. $estado['uf'] .'</option>';
                                                continue;
                                            }
                                            echo '<option value="'. $estado['id'] .'" >'. $estado['uf'] .'</option>';
                                        }
                                    ?>
                                </select>
                            </td>
                            <td><button id="id_pessoa<?=$i?>"  class="img-button" name="action" onclick="return confirm('Deseja atualizar o registro ?')" value="Atualizar"><img src="assets/img/rotate.png" width="20px" /></button></td>
                            <td><button id="id_pessoa<?=$i?>" name="action" class="img-button" value="Deletar" onclick="return confirm('Realmente deseja apagar o registro ? A operação não poderá ser desfeita.')"><img src="assets/img/remove.png" width="20px" /></button></td>
                        </form>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!----- Modal ----->
    <div class="modal fade" id="modalAtzDelPessoa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Atualizar ou deletar um cadastro</h2>
                </div>
                <div class="modal-body">

                    <form action="crud_nf.php" method="post" >
                        <label for="nome_modal">Nome:</label>
                        <input id="nome_modal" name="nome" type="text" maxlength="255" required />
                        <br />
                        <label for="cpf_modal" >CPF:</label>
                        <input id="cpf_modal" name="cpf" type="text" pattern="([0-9]{3}\.){2}[0-9]{3}-[0-9]{2}" required />
                        <br />
                        <label for="rg_modal" >RG:</label>
                        <input id="rg_modal" name="rg" type="text" pattern="[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[0-9]{1}"  />
                        <br />
                        <label for="data_nascimento_modal" >Data de nascimento:</label>
                        <input id="data_nascimento_modal" name="data_nascimento" type="date" required />
                        <br />
                        <label for="telefone_modal" >Telefone</label>
                        <input id="telefone_modal" name="telefone" type="text" pattern="\([0-9]{2}\)[0-9]{5}-[0-9]{4}"  />
                        
                        <fieldset>
                            <legend>Endereço</legend>
                            <label for="cep_modal" >CEP:</label>
                            <input id="cep_modal" name="cep" type="text" pattern="[0-9]{2}\.[0-9]{3}-[0-9]{3}"  />
                            <br />
                            <label for="uf_modal" >Estado:</label>
                            <select id="uf_modal" name="uf">
                                <option value="0">UF</option>
                                <?php
                                    foreach($estados as $estado){
                                        echo '<option value="'. $estado['id'] .'" >'. $estado['uf'] .'</option>';
                                    }
                                ?>
                            </select>
                            <br />
                            <label for="endereco_modal" >Endereço:</label>
                            <input id="endereco_modal" name="endereco" type="text" maxlength="255" required />
                            <br />
                            <label for="numero_modal" >Numero:</label>
                            <input id="numero_modal" name="numero" type="text" maxlength="255" required />
                            <br />
                        </fieldset>
                        <br />
                        
                        <div class="modal-footer">
                            <!--<button type="submit" name="action" value="Registrar">Registrar</button>-->
                            <button type="submit" name="action" value="Atualizar" onclick="return confirm('Deseja atualizar esse registro ?')">Atualizar</button>
                            <button type="submit" name="action" value="Deletar" onclick="return confirm('Deseja excluir esse registro ?')">Deletar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!----- FIM Modal ----->

</body>
</html>