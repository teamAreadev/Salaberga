<?php

session_start();


require_once '../config/Database.php';

class UserAuth
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function login($email, $senha)
    {
        try {

            $pdo = $this->db->connect();


            $queryStr = "SELECT email, senha, status FROM usuario WHERE email = :email AND senha = :senha";
            $query = $pdo->prepare($queryStr);


            $query->bindValue(":email", $email);
            $query->bindValue(":senha", $senha);

            // Executa a query
            $query->execute();
            $result = $query->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($result)) {
                $_SESSION['login'] = true;
                $_SESSION['status'] = $result[0]['status'];
                $_SESSION['refresh'] = 0;
                return true; // Usuário encontrado
            } else {
                return false; // Usuário não encontrado
            }
        } catch (Exception $e) {
            throw new Exception("Erro ao realizar login: " . $e->getMessage());
        } finally {

            $this->db->closeConnection();
        }
    }
}


class CadastroAluno
{

    public function cadastrar($nome, $turma, $curso, $matricula)
    {
        $pdo = new PDO("mysql:host=localhost;dbname=entrada_saida", "root", "");
        $cadastrar = "INSERT INTO    aluno   VALUES(null, :nome,:turma, :curso, :matricula)";
        $query = $pdo->prepare($cadastrar);
        $query->bindValue(":nome", $nome);
        $query->bindValue(":turma", $turma);
        $query->bindValue(":curso", $curso);
        $query->bindValue(":matricula", $matricula);
        $query->execute();
    }
}


class RegistroAluno
{

    public function registrarSaida($id_aluno, $date_time)
    {
        try {
            // Conexão com o banco de dados
            $pdo = new PDO("mysql:host=localhost;dbname=entradasaida", "root", "", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);

            // Query SQL para inserir id_aluno e date_time na coluna dae
            $registrar = "INSERT INTO saida_estagio (id_aluno, dae) VALUES (:id_aluno, :dae)";
            $query = $pdo->prepare($registrar);

            // Vincula os parâmetros
            $query->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
            $query->bindValue(":dae", $date_time, PDO::PARAM_STR);

            // Executa a query
            $query->execute();

            return true; // Sucesso
        } catch (PDOException $e) {
            // Tratamento de erro
            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

     public function fpdf (){



        
     }

}
