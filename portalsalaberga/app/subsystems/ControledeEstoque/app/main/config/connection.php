<?php
    class connection{
        protected $pdo;
        
        public function __construct(){
           $this->connect_database();
        }
        public function connect_database(){
            try{
                $this->pdo = new PDO("mysql:host=localhost;dbname=u750204740_estoque", "root", "");
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                echo "Erro: ".$e->getMessage();
            }
        }
        
        public function getPdo(){
            return $this->pdo;
        }

        // Teste duplo de conexão
        public static function testConnections() {
            $configs = [
                [
                    'name' => 'Local',
                    'dsn' => 'mysql:host=localhost;dbname=u750204740_estoque',
                    'user' => 'root',
                    'pass' => ''
                ],
                [
                    'name' => 'Hospedagem',
                    'dsn' => 'mysql:host=HOST_DA_HOSPEDAGEM;dbname=u750204740_estoque', // Substitua pelos dados reais
                    'user' => 'u750204740_estoque', // Substitua pelos dados reais
                    'pass' => 'paoComOvo123!@##'    // Substitua pelos dados reais
                ]
            ];
            foreach ($configs as $config) {
                echo "Testando conexão com o banco: {$config['name']}... ";
                try {
                    $pdo = new PDO($config['dsn'], $config['user'], $config['pass']);
                    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    echo "SUCESSO!<br>";
                } catch (PDOException $e) {
                    echo "FALHOU: ".$e->getMessage()."<br>";
                }
            }
        }
    }
?>