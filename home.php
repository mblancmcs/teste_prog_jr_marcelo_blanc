<?php

    require_once('conexao_bd.php');
    require_once('bd_queries.php');
    require_once('valida_acesso.php');

    error_reporting(0);
    
    $estados = selectUf();
    $tabela_pessoas = mostrarCadastros();

    function data_hora_formatada($data_hora){
        if($data_hora != ''){
            $data_formatada = explode('-', $data_hora);
            $data_formatada[2] = explode(' ', $data_formatada[2]);
            $hora_formatada = $data_formatada[2][1];
            $data_formatada[2] = $data_formatada[2][0];
    
            $data_inicial_formatada = $data_formatada[2] . '/' . $data_formatada[1] . '/' . $data_formatada[0] . ' ' . $hora_formatada;
            return $data_inicial_formatada;
        } else  {
            return '';
        }
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

    <title>Sistema</title>
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

            function limpa_formulário_cep() {
                // Limpa valores do formulário de cep.
                $("#endereco").val("");
                //$("#bairro").val("");
                //$("#cidade").val("");
                $("#uf").val("0");
                //$("#ibge").val("");
            }
            
            //Quando o campo cep perde o foco.
            $("#cep").blur(function() {

                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g, '');

                //Verifica se campo cep possui valor informado.
                if (cep != "") {

                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;

                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {

                        //Preenche os campos com "..." enquanto consulta webservice.
                        $("#endereco").val("...");
                        //$("#bairro").val("...");
                        //$("#cidade").val("...");
                        //$("#uf").val("...");
                        //$("#ibge").val("...");

                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#endereco").val(dados.logradouro);
                                //$("#bairro").val(dados.bairro);
                                //$("#cidade").val(dados.localidade);
                                //$("#uf").val(dados.uf);
                                //$("#ibge").val(dados.ibge);

                                /*
                                let valor_uf = dados.uf;

                                $.ajax({
                                    url:'buscaIdUf.php',
                                    method:'post',
                                    data: { valor_uf: 'valor_uf' },
                                    success: function(data){
                                        const resultado = JSON.parse(data);
                                        $('#numero').val(resultado.id_uf);
                                        alert('valor_uf');
                                    }
                                });
                                */
                            } //end if.
                            else {
                                //CEP pesquisado não foi encontrado.
                                limpa_formulário_cep();
                                alert("CEP não encontrado.");
                            }
                        });
                    } //end if.
                    else {
                        //cep é inválido.
                        limpa_formulário_cep();
                        alert("Formato de CEP inválido.");
                    }
                } //end if.
                else {
                    //cep sem valor, limpa formulário.
                    limpa_formulário_cep();
                }
            });

        });

        function showModal(id){
            $("#modal"+id).modal("show");
        }

    </script>
</head>
<body>
    <div class="cabecalho" >
        <span>Teste para programador júnior da Webdec - Marcelo Blanc </span>
        <a data-toggle="tooltip" data-placement="bottom" title="Sair" style="float:right; text-decoration:none; color:white;" href="sair.php" ><img style="bottom:5px;" src="./assets/img/sairBranco.png" width="25px" /></a>
        <button data-toggle="tooltip" data-placement="bottom" title="Contato" onclick="showModal('Contato')" style="float:right; text-decoration:none; color:white; margin-right:10px;" ><img style="bottom:5px;" src="./assets/img/contactWhite.png" width="25px" /></button>
    </div>
    <div class="container">
        <div class="container2">
            <form id="form-cadastro" action="crud_pessoas.php" method="post">

                <h1 style="font-size:30px;" >Cadastro</h1>

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
                    <label for="cep" >CEP:
                    <input id="cep" class="cep" name="cep" type="text" onblur="pesquisacep(this.value);" pattern="[0-9]{2}\.[0-9]{3}-[0-9]{3}" /></label>
                    <label for="uf" >Estado:
                    <select id="uf" class="uf" name="uf">
                        <option value="0">UF</option>
                        <?php
                            foreach($estados as $estado){
                                echo '<option value="'. $estado['id'] .'" >'. $estado['uf'] .'</option>';
                            }
                        ?>
                    </select></label>
                    <label for="endereco" >Endereço:
                    <input id="endereco" name="endereco" type="text" maxlength="255" required /></label>
                    <label for="numero" >Numero:
                    <input id="numero" name="numero" type="text" maxlength="255" required /></label>
                </fieldset>
                <br />
                <div style="text-align:center;"><button id="btn_registrar" type="submmit" name="action" value="Registrar" >Cadastrar</button></div>
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
            } else {
                echo '<br />';
            }
        ?>

        <div class="tabela-responsiva">
            <h2>Cadastros realizados (atualizar / deletar)</h2>
            <table rules="all">
                <caption style="text-align:center;">
                    <?php if(count($tabela_pessoas) == 0) {
                        echo '<b><p>Não há dados cadastrados no momento.</p></b>';
                    } ?>
                </caption>
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
                        <form method="post" action="crud_pessoas.php">
                            <input type="hidden" name="pessoa_id" value="<?= $tabela_pessoas[$i]['id'] ?>" />
                            <input type="hidden" name="endereco_id" value="<?= $tabela_pessoas[$i][10] ?>" />
                            <input type="hidden" name="telefone_id" value="<?= $tabela_pessoas[$i][8] ?>" />
                            <td><input class="input-tabela" type="text" name="nome" value="<?= $tabela_pessoas[$i]['nome'] ?>" maxlength="255" /></td>
                            <td><input class="input-tabela cpf" type="text" name="cpf" value="<?= $tabela_pessoas[$i]['cpf'] ?>" pattern="([0-9]{3}\.){2}[0-9]{3}-[0-9]{2}" /></td>
                            <td><input class="input-tabela rg" type="text" name="rg" value="<?= $tabela_pessoas[$i]['rg'] ?>" pattern="[0-9]{2}\.[0-9]{3}\.[0-9]{3}-[0-9]{1}" /></td>
                            <td><input style="width:105px" type="date" name="data_nascimento" value="<?= $tabela_pessoas[$i]['data_nascimento'] ?>" /></td>
                            <td><input style="width:150px; background: lightgrey;" type="text" name="data_cadastro" readonly  value="<?= data_hora_formatada($tabela_pessoas[$i]['data_cadastro']) ?>" /></td>
                            <td><input style="width:150px; background: lightgrey;" type="text" name="data_atualizacao" readonly value="<?= data_hora_formatada($tabela_pessoas[$i]['data_atualizacao']) ?>" /></td>
                            <td><input style="width:150px; color:red; background: lightgrey;" type="text" name="data_exclusao" readonly value="<?= data_hora_formatada($tabela_pessoas[$i]['data_exclusao']) ?>" /></td>
                            <td><input class="input-tabela telefone" type="text" name="telefone" pattern="\([0-9]{2}\)[0-9]{5}-[0-9]{4}" <?= !empty($tabela_pessoas[$i]['telefone']) ? 'value="'.$tabela_pessoas[$i]['telefone'].'"' : 'style="color:red" value="(00)00000-0000"'; ?> /></td>
                            <td><input class="input-tabela cep" type="text" name="cep" pattern="[0-9]{2}\.[0-9]{3}-[0-9]{3}" value="<?= $tabela_pessoas[$i]['cep'] ?>" /></td>
                            <td><input class="input-tabela" type="text" name="endereco" maxlength="255" value="<?= $tabela_pessoas[$i]['endereco'] ?>" /></td>
                            <td><input class="input-tabela" type="text" name="numero" maxlength="255" value="<?= $tabela_pessoas[$i]['numero'] ?>" /></td>
                            <td>
                                <select class="uf" name="uf">
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
                            <td><button class="img-button" name="action" onclick="return confirm('Deseja atualizar o registro ?')" value="Atualizar"><img src="assets/img/rotate.png" width="20px" /></button></td>
                            <td><button name="action" class="img-button" value="Deletar" onclick="return confirm('Realmente deseja apagar o registro ? A operação não poderá ser desfeita.')"><img src="assets/img/remove.png" width="20px" /></button></td>
                        </form>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!----- Modal ----->
    <div class="modal fade" id="modalContato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="modal-title" id="exampleModalLabel">Contatos</h2>
                </div>
                <div class="modal-body">
                    <p>E-mail: mblancm.cs@gmail.com</p>
                    <p>LinkedIn:<a href="https://www.linkedin.com/in/marcelo-blanc-moreira-3274a51b1" >Marcelo Blanc Moreira</a></p>
                    <p>Instagram:<a href="https://www.instagram.com/blancoder.biz/" >@blancoder.biz</a></p>
                    <p>Tel. e WhatsApp: (21)96489-6437</p>
                </div>
            </div>
        </div>
    </div>
    <!----- FIM Modal ----->

</body>
</html>