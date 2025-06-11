<?php
require_once("../config/connection.php");

class select extends connection
{
    public function __construct()
    {
        parent::__construct();
    }

    public function selectProdutos($barcode)
    {
        $consulta = "SELECT * FROM produtos WHERE barcode = :barcode";

        $query = $this->pdo->prepare($consulta);
        $query->bindValue(":barcode", $barcode);
        $query->execute();

        return $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectSolicitarProdutos($barcode)
    {
        try {
            $query = $this->pdo->query('SELECT barcode, nome_produto FROM produtos ORDER BY nome_produto');
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row['barcode']) . "'>" . htmlspecialchars($row['nome_produto']) . " (Barcode: " . htmlspecialchars($row['barcode']) . ")</option>";      
            }
        } catch (PDOException $e) {
            echo "<option value='' disabled>Erro ao conectar ao banco: " . htmlspecialchars($e->getMessage()) . "</option>";
        }
    }

    public function selectSolicitarResponsaveis($barcode)
    {
        try {
            $query = $this->pdo->query('SELECT nome FROM responsaveis ORDER BY nome');
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row['nome']) . "'>" . htmlspecialchars($row['nome']) . "</option>";
            }
        } catch (PDOException $e) {
            echo "<option value='' disabled>Erro ao conectar ao banco: " . htmlspecialchars($e->getMessage()) . "</option>";
        }
    }


    public function modalRelatorio()
    {
        try {
            $query = $this->pdo->query('SELECT id, nome_produto FROM produtos ORDER BY nome_produto');
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<option value='" . htmlspecialchars($row['id']) . "'>" . strtoupper(htmlspecialchars($row['nome_produto'])) . "</option>";
            }
        } catch (PDOException $e) {
            echo "<option value='' disabled>Erro ao carregar produtos: " . htmlspecialchars($e->getMessage()) . "</option>";
        }
    }
}
?>