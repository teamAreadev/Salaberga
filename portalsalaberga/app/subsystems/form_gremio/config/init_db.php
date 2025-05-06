<?php
require_once 'database.php';

class DatabaseInitializer {
    private $db;
    private $log = [];
    
    public function __construct() {
        try {
            $database = new Database();
            $this->db = $database->getConnection();
        } catch (Exception $e) {
            $this->log[] = "Erro ao conectar ao banco de dados: " . $e->getMessage();
            error_log("Erro ao conectar ao banco de dados: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function initialize() {
        try {
            // Criar tabela alunos se não existir (de acordo com a estrutura atual)
            $sqlAlunos = "CREATE TABLE IF NOT EXISTS alunos (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                telefone VARCHAR(20) DEFAULT NULL,
                ano VARCHAR(10) DEFAULT NULL,
                turma VARCHAR(10) DEFAULT NULL,
                data_inscricao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $this->db->exec($sqlAlunos);
            $this->log[] = "Tabela 'alunos' verificada/criada com sucesso.";
            error_log("Tabela 'alunos' verificada/criada com sucesso.");
            
            // Criar tabela inscricoes se não existir (de acordo com a estrutura atual)
            $sqlInscricoes = "CREATE TABLE IF NOT EXISTS inscricoes (
                id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                aluno_id INT(11) NOT NULL,
                modalidade VARCHAR(50) NOT NULL,
                categoria VARCHAR(20) NOT NULL,
                nome_equipe VARCHAR(255) DEFAULT NULL,
                equipe_id INT(11) DEFAULT NULL,
                status VARCHAR(20) DEFAULT 'pendente',
                data_inscricao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                data_aprovacao TIMESTAMP NULL DEFAULT NULL,
                FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
            
            $this->db->exec($sqlInscricoes);
            $this->log[] = "Tabela 'inscricoes' verificada/criada com sucesso.";
            error_log("Tabela 'inscricoes' verificada/criada com sucesso.");
            
            return true;
        } catch (PDOException $e) {
            $this->log[] = "Erro ao inicializar o banco de dados: " . $e->getMessage();
            error_log("Erro ao inicializar o banco de dados: " . $e->getMessage());
            return false;
        }
    }
    
    public function getLogs() {
        return $this->log;
    }
}

// Executar a inicialização quando o script for chamado diretamente
if (basename($_SERVER['SCRIPT_FILENAME']) == basename(__FILE__)) {
    $initializer = new DatabaseInitializer();
    $initializer->initialize();
    foreach ($initializer->getLogs() as $log) {
        echo $log . "<br>";
    }
}
?> 