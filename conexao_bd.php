<?php

    class db{

        private $host = 'localhost';
        private $user = 'root';
        private $senha = '';
        private $database = 'db_teste_marcelo_blanc';

        public function conecta_db(){
            $con = mysqli_connect($this->host, $this->user, $this->senha, $this->database);

            mysqli_set_charset($con, 'utf8');

            if(mysqli_connect_errno()){
                echo 'Erro ao tentar se conectar com o bd MySQL: ' . mysqli_connect_error();
            }

            return $con;
        }

    }
    
?>