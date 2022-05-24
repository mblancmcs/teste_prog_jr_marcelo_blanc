<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/jquery/jquery-3.6.0.min.js" ></script>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css" />
    <title>Pag. de Login</title>
    <script>

        $(document).ready(function(){

            let campo_vazio = false;
            let erro = '';

            $('#btn_logar').click(function(){

                if(($('#usuario').val() == '') && ($('#senha').val() == '')){

                    $('#usuario').css({'border-color' : 'red'});
                    $('#senha').css({'border-color':'red'});
                    campo_vazio = true;
                    erro = 'Usuário e senha em branco';
                    $('#resultado_jquery').css({'color':'red'});
                    $('#resultado_jquery').html(erro);

                } else if($('#usuario').val() == ''){

                    $('#usuario').css({'border-color' : 'red'});
                    $('#senha').css({'border-color':'white'});
                    campo_vazio = true;
                    erro = 'Usuário em branco';
                    $('#resultado_jquery').css({'color':'red'});
                    $('#resultado_jquery').html(erro);

                } else if($('#senha').val() == ''){

                    $('#senha').css({'border-color':'red'});
                    $('#usuario').css({'border-color':'white'});
                    campo_vazio = true;
                    erro = 'Senha em branco';
                    $('#resultado_jquery').css({'color':'red'});
                    $('#resultado_jquery').html(erro);

                } else {

                    $('#senha').css({'border-color':'white'});
                    $('#usuario').css({'border-color':'white'});
                    erro = '';
                    $('#resultado_jquery').html(erro);
                    campo_vazio = false;

                }

                if(campo_vazio){
                    return false;
                }

            });

        });

    </script>
</head>
<body>
    <div class="container-index">
        <div class="container-login">
            <form action="valida_login.php" method="post" >

                <h1 style="font-size: 35px" >Login</h1>

                <label for="usuario">Login:</label>
                <input id="usuario" name="usuario" type="text" />
                <br />
                <label for="senha" >Senha:</label>
                <input id="senha" name="senha" type="password" />

                <div id="resultado_jquery" ></div>

                <?php
                    if(isset($_GET['erro'])) {
                        switch($_GET['erro']){
                            case 0:
                                echo '<span style="color:red"> Usuário ou senha inválido </span>';
                                break;
                            case 1:
                                echo '<span style="color:red" >É preciso fazer login para acessar a páginas protegidas.</span>';
                                break;
                        }
                    } else if(isset($_GET['msg'])){
                        switch($_GET['msg']){
                            case 0:
                                echo '<span style="color:green"> Volte sempre ! </span>';
                                break;
                        }
                    }
                ?>

                <br />
                <button id="btn_logar" type="submit" name="logar" >Logar</button>
                
            </form>
        </div>
    <div>
</body>
</html>