<?php
    class connection{
        protected $pdo;
        
        public function __construct(){
           $this->connect_database();
        }
        public function connect_database(){
            // Configurações do banco de dados local
            $local_host = "localhost";
            $local_dbname = "estoque"; // Altere para o nome do seu banco de dados local
            $local_user = "root";
            $local_pass = "";

            // Configurações do banco de dados da hospedagem
            $hosted_host = "localhost";
            $hosted_dbname = "u750204740_estoque";
            $hosted_user = "u750204740_estoque";
            $hosted_pass = "paoComOvo123!@##";

            try{
                // Tenta conectar ao banco de dados local primeiro
                $this->pdo = new PDO("mysql:host={$local_host};dbname={$local_dbname}", $local_user, $local_pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "Conexão local estabelecida com sucesso!<br>";
            }catch(PDOException $e){
                echo "Falha na conexão local: ".$e->getMessage()."<br>Tentando conexão com hospedagem...<br>";
                try{
                    // Se a conexão local falhar, tenta a conexão com a hospedagem
                    $this->pdo = new PDO("mysql:host={$hosted_host};dbname={$hosted_dbname}", $hosted_user, $hosted_pass);
                    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo "Conexão com hospedagem estabelecida com sucesso!<br>";
                }catch(PDOException $e){
                    echo "Erro: Não foi possível conectar a nenhum banco de dados. " .$e->getMessage();
                }
            }
        }
    }
?>