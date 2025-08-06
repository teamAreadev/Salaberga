<?php

require_once(__DIR__ . '/../config/Database.php');

class select_model extends connect
{
    public function __construct()
    {
        parent::__construct();
    }

    public function select_curso(){
        $queryStr = "SELECT * FROM curso";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function select_turmas(){
        $queryStr = "SELECT * FROM turma";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function select_alunos()
    {
        $queryStr = "SELECT * FROM aluno";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function select_alunosE()
    {
        try {
            $queryStr = "SELECT * FROM aluno WHERE id_turma IN (9, 10, 11, 12)";
            $query = $this->connect->query($queryStr);
            $result = $query->fetchAll(PDO::FETCH_ASSOC);
            error_log("Selecionados " . count($result) . " alunos do 3º ano");
            return $result;
        } catch (PDOException $e) {
            error_log("Erro ao selecionar alunos do 3º ano: " . $e->getMessage());
            return [];
        }
    }

    public function saida_estagio_3A()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 9 
                    AND DATE(s.dae) = CURDATE() 
                    ORDER BY s.dae DESC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3B()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 10 
                    AND DATE(s.dae) = CURDATE()
                    ORDER BY s.dae DESC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3C()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 11 
                    AND DATE(s.dae) = CURDATE()
                    ORDER BY s.dae DESC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3D()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 12 
                    AND DATE(s.dae) = CURDATE()
                    ORDER BY s.dae  DESC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3A_relatorio()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 9 
                    AND DATE(s.dae) = CURDATE() 
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3B_relatorio()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 10 
                    AND DATE(s.dae) = CURDATE()
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3C_relatorio()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 11 
                    AND DATE(s.dae) = CURDATE()
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3D_relatorio()
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 12 
                    AND DATE(s.dae) = CURDATE()
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function saida_estagio_3A_relatorio_dia($data)
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 9 
                    AND DATE(s.dae) = '$data' 
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3B_relatorio_dia($data)
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 10 
                    AND DATE(s.dae) = '$data'
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3C_relatorio_dia($data)
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 11 
                    AND DATE(s.dae) = '$data'
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    public function saida_estagio_3D_relatorio_dia($data)
    {
        $queryStr = "SELECT a.nome, s.dae FROM aluno a 
                    JOIN saida_estagio s ON a.id_aluno = s.id_aluno 
                    WHERE a.id_turma = 12 
                    AND DATE(s.dae) = '$data'
                    ORDER BY a.nome ASC";
        $query = $this->connect->query($queryStr);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSaidasEstagioPorTurma($id_turma, $data)
    {
        try {
            $sql = "SELECT a.nome, se.data_saida, se.hora_saida 
                    FROM saida_estagio se 
                    INNER JOIN alunos a ON se.id_aluno = a.id 
                    WHERE a.id_turma = :id_turma 
                    AND DATE(se.data_saida) = :data 
                    ORDER BY a.nome";

            $stmt = $this->connect->prepare($sql);
            $stmt->bindParam(':id_turma', $id_turma);
            $stmt->bindParam(':data', $data);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar saídas de estágio: " . $e->getMessage());
            return [];
        }
    }
};
