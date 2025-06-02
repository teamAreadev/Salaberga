<?php

require_once '../assets/config/Database.php';

class select_model
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }



    public function select_alunos()
    {
        $pdo = $this->db->connect();

        $queryStr = "SELECT * FROM aluno";
        $query = $pdo->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }




   public function select_alunosE()
{
    try {
        $pdo = $this->db->connect();
        $queryStr = "SELECT * FROM aluno WHERE id_turma IN (9, 10, 11, 12)";
        $query = $pdo->query($queryStr);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        error_log("Selecionados " . count($result) . " alunos do 3º ano");
        return $result;
    } catch (PDOException $e) {
        error_log("Erro ao selecionar alunos do 3º ano: " . $e->getMessage());
        return [];
    }
}
};



