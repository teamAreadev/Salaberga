<?php
class Database {
    private static $instance = null;
    private $connection = null;
    private $isLocal = false;

    private function __construct() {
        // Configurações do banco de dados local
        $localConfig = [
            'host' => 'localhost',
            'dbname' => 'login_parcial',
            'user' => 'root',
            'pass' => ''
        ];

        // Configurações do banco de dados da hospedagem
        $hostedConfig = [
            'host' => 'localhost', // Substitua pelo host da hospedagem
            'dbname' => 'u750204740_parcial', // Substitua pelo nome do banco na hospedagem
            'user' => 'u750204740_parcial', // Substitua pelo usuário da hospedagem
            'pass' => 'paoComOvo123!@##' // Substitua pela senha da hospedagem
        ];

        try {
            // Tenta conectar primeiro ao banco local
            $this->connection = new PDO(
                "mysql:host={$localConfig['host']};dbname={$localConfig['dbname']};charset=utf8",
                $localConfig['user'],
                $localConfig['pass'],
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            $this->isLocal = true;
            error_log("Conexão local estabelecida com sucesso");
        } catch (PDOException $e) {
            error_log("Falha na conexão local: " . $e->getMessage());
            
            try {
                // Se falhar, tenta conectar ao banco da hospedagem
                $this->connection = new PDO(
                    "mysql:host={$hostedConfig['host']};dbname={$hostedConfig['dbname']};charset=utf8",
                    $hostedConfig['user'],
                    $hostedConfig['pass'],
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );
                $this->isLocal = false;
                error_log("Conexão com hospedagem estabelecida com sucesso");
            } catch (PDOException $e) {
                error_log("Falha na conexão com hospedagem: " . $e->getMessage());
                throw new Exception("Não foi possível conectar a nenhum banco de dados");
            }
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }

    public function isLocalConnection() {
        return $this->isLocal;
    }

    // Previne a clonagem do objeto
    private function __clone() {}

    // Previne a deserialização do objeto
    public function __wakeup() {}
}

// Função helper para obter a conexão
function getConnection() {
    return Database::getInstance()->getConnection();
}

// Função helper para verificar se é conexão local
function isLocalConnection() {
    return Database::getInstance()->isLocalConnection();
} 