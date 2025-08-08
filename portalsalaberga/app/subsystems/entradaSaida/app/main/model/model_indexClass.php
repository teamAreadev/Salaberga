<?php

require_once(__DIR__ . '/../config/Database.php');

class MainModel extends connect
{

    public function __construct()
    {
        parent::__construct();
    }

    public function cadastrar($id_turma, $matricula, $nome, $id_curso)
    {
        try {
            $stmt_check = $this->connect->prepare("SELECT matricula FROM aluno WHERE matricula = :matricula");
            $stmt_check->bindValue(':matricula', $matricula, PDO::PARAM_STR);
            $stmt_check->execute();

            if ($stmt_check->rowCount() > 0) {
                // Aluno já cadastrado.
                return false;
            }

            $stmt_cadastrar_aluno = $this->connect->prepare(
                "INSERT INTO `aluno`(`id_turma`, `matricula`, `nome`, `id_curso`) VALUES (:id_turma, :matricula, :nome, :id_curso)"
            );

            $stmt_cadastrar_aluno->bindValue(':id_turma', $id_turma, PDO::PARAM_INT);
            $stmt_cadastrar_aluno->bindValue(':matricula', $matricula, PDO::PARAM_STR);
            $stmt_cadastrar_aluno->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt_cadastrar_aluno->bindValue(':id_curso', $id_curso, PDO::PARAM_INT);

            return $stmt_cadastrar_aluno->execute();
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar aluno: " . $e->getMessage());
            return false;
        }
    }

    public function RegistroEstagio($id_aluno, $date_time)
    {
        try {   
            if (empty($id_aluno) || empty($date_time)) {
                error_log("Erro: id_aluno ou date_time vazios (id_aluno=$id_aluno, date_time=$date_time)");
                return false;
            }

            if (!DateTime::createFromFormat('Y-m-d H:i:s', $date_time)) {
                error_log("Erro: Formato de data e hora inválido ($date_time)");
                return false;
            }

            $registrar = "INSERT INTO saida_estagio (id_aluno, dae) VALUES (:id_aluno, :dae)";
            $query = $this->connect->prepare($registrar);
            $query->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
            $query->bindValue(":dae", $date_time, PDO::PARAM_STR);

            if ($query->execute()) {
                error_log("Saída de estágio registrada: id_aluno=$id_aluno, dae=$date_time");
                return true;
            } else {
                error_log("Erro: Falha ao executar a query para id_aluno=$id_aluno");
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao registrar saída de estágio: " . $e->getMessage());
            return false;
        }
    }

    public function registrarSaida($nome_responsavel, $nome_conducente, $id_tipo_conducente, $id_tipo_responsavel, $date_time, $id_motivo, $id_usuario, $id_aluno)
    {
        try {
            $registrar = "INSERT INTO registro_saida  VALUES (NULL, :nome_responsavel, :nome_conducente, :id_tipo_conducente, :id_tipo_responsavel, :date_time, :id_motivo, :id_usuario, :id_aluno)";
            $query = $this->connect->prepare($registrar);

            // Vincula os parâmetros
            $query->bindValue(":nome_responsavel", $nome_responsavel);
            $query->bindValue(":nome_conducente", $nome_conducente);
            $query->bindValue(":id_tipo_conducente", $id_tipo_conducente);
            $query->bindValue(":id_tipo_responsavel", $id_tipo_responsavel);
            $query->bindValue(":date_time", $date_time);
            $query->bindValue(":id_motivo", $id_motivo);
            $query->bindValue(":id_usuario", $id_usuario);
            $query->bindValue(":id_aluno", $id_aluno);

            $query->execute();
        } catch (PDOException $e) {

            echo "Erro: " . $e->getMessage();
            return false;
        }
    }


    public function registrarEntrada($nome_responsavel,
        $nome_conducente,
         $id_tipo_conducente,
         $id_tipo_responsavel,
         $date_time,
         $id_motivo,
         $id_usuario,
     $id_aluno
    )
    {
        /*try {
            // Verifica se o aluno existe na tabela aluno com base no nome
            $verificarAluno = "SELECT id_aluno FROM aluno WHERE nome = :nome";
            $queryVerificar = $this->connect->prepare($verificarAluno);
            $queryVerificar->bindValue(":nome", $aluno, PDO::PARAM_STR);
            $queryVerificar->execute();

            $verificarAluno = "SELECT id_aluno FROM aluno WHERE id_aluno = :id_aluno";
            $queryVerificar_id = $this->connect->prepare($verificarAluno);
            $queryVerificar_id->bindValue(":id_aluno", $aluno, PDO::PARAM_INT);
            $queryVerificar_id->execute();

            // Verifica se o aluno foi encontrado
            if ($queryVerificar->rowCount() > 0 || $queryVerificar_id->rowCount() > 0) {
                // Recupera o id_aluno
                $row2 = $queryVerificar_id->fetch(PDO::FETCH_ASSOC);
                $row = $queryVerificar->fetch(PDO::FETCH_ASSOC);
                $id_aluno = $row['id_aluno'] ?? $row2['id_aluno'];

                // Verifica se o aluno já foi registrado hoje
                $verificarRegistro = "SELECT id_aluno FROM saida_estagio 
                                    WHERE id_aluno = :id_aluno 
                                    AND DATE(dae) = CURDATE()";
                $queryVerificarRegistro = $this->connect->prepare($verificarRegistro);
                $queryVerificarRegistro->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
                $queryVerificarRegistro->execute();

                if ($queryVerificarRegistro->rowCount() > 0) {

                    return 1;
                }

                // Query SQL para inserir id_aluno e date_time na coluna dae
                $registrar = "INSERT INTO saida_estagio (id_aluno, dae) VALUES (:id_aluno, :dae)";
                $query = $this->connect->prepare($registrar);

                // Vincula os parâmetros
                $query->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
                $query->bindValue(":dae", $date_time, PDO::PARAM_STR);

                $query->execute();

                return 0; 
            } else {

                return 2;
            }
        } catch (PDOException $e) {
            return 3;
        }*/
    }
    public function registrarSaidaEstagio($aluno, $date_time)
    {
        try {
            // Verifica se o aluno existe na tabela aluno com base no nome
            $verificarAluno = "SELECT id_aluno FROM aluno WHERE nome = :nome";
            $queryVerificar = $this->connect->prepare($verificarAluno);
            $queryVerificar->bindValue(":nome", $aluno, PDO::PARAM_STR);
            $queryVerificar->execute();

            $verificarAluno = "SELECT id_aluno FROM aluno WHERE id_aluno = :id_aluno";
            $queryVerificar_id = $this->connect->prepare($verificarAluno);
            $queryVerificar_id->bindValue(":id_aluno", $aluno, PDO::PARAM_INT);
            $queryVerificar_id->execute();

            // Verifica se o aluno foi encontrado
            if ($queryVerificar->rowCount() > 0 || $queryVerificar_id->rowCount() > 0) {
                // Recupera o id_aluno
                $row2 = $queryVerificar_id->fetch(PDO::FETCH_ASSOC);
                $row = $queryVerificar->fetch(PDO::FETCH_ASSOC);
                $id_aluno = $row['id_aluno'] ?? $row2['id_aluno'];

                // Verifica se o aluno já foi registrado hoje
                $verificarRegistro = "SELECT id_aluno FROM saida_estagio 
                                    WHERE id_aluno = :id_aluno 
                                    AND DATE(dae) = CURDATE()";
                $queryVerificarRegistro = $this->connect->prepare($verificarRegistro);
                $queryVerificarRegistro->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
                $queryVerificarRegistro->execute();

                if ($queryVerificarRegistro->rowCount() > 0) {

                    return 1;
                }

                // Query SQL para inserir id_aluno e date_time na coluna dae
                $registrar = "INSERT INTO saida_estagio (id_aluno, dae) VALUES (:id_aluno, :dae)";
                $query = $this->connect->prepare($registrar);

                // Vincula os parâmetros
                $query->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
                $query->bindValue(":dae", $date_time, PDO::PARAM_STR);

                $query->execute();

                return 0; 
            } else {

                return 2;
            }
        } catch (PDOException $e) {
            return 3;
        }
    }
};
