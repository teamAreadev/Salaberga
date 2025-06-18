<?php
class Conexao {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        try {
            // Tentativa de conexão local
            $dsn = "mysql:host=localhost;dbname=financeiro;charset=utf8mb4";
            $username = "root";
            $password = "";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Se falhar, tenta conexão com hospedagem
            $dsn = "mysql:host=localhost;dbname=u750204740_financeiro;charset=utf8mb4";
            $username = "u750204740_financeiro";
            $password = "paoComOvo123!@##";
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Erro na conexão: " . $e->getMessage());
        }
    }

    public static function getConexao() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
?>
