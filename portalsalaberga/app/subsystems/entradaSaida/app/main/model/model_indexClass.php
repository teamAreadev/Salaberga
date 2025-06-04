<?php

require_once(__DIR__ . '/../config/Database.php');

class MainModel extends connect
{

    public function __construct()
    {
        parent::__construct();
    }

    public function cadastrar($id_turma, $matricula, $nome, $id_curso, $id_usuario = null)
    {
        try {
            echo "Validando campos: id_turma=$id_turma, matricula=$matricula, nome=$nome, id_curso=$id_curso, id_usuario=$id_usuario<br>";
            if (empty($id_turma) || empty($matricula) || empty($nome) || empty($id_curso)) {
                error_log("Erro: Todos os campos são obrigatórios (id_turma=$id_turma, matricula=$matricula, nome=$nome, id_curso=$id_curso)");
                echo "Erro: Campos obrigatórios vazios<br>";
                return false;
            }

            echo "Validando matrícula: $matricula<br>";
            if (!preg_match('/^\d{7}$/', $matricula)) {
                error_log("Erro: Matrícula inválida ($matricula). Deve conter 7 dígitos.");
                echo "Erro: Matrícula inválida<br>";
                return false;
            }

            $turma_map = [
                '1° ano a' => 1,
                '1° ano b' => 2,
                '1° ano c' => 3,
                '1° ano d' => 4,
                '2° ano a' => 5,
                '2° ano b' => 6,
                '2° ano c' => 7,
                '2° ano d' => 8,
                '3° ano a' => 9,
                '3° ano b' => 10,
                '3° ano c' => 11,
                '3° ano d' => 12
            ];

            $id_turma = strtolower(trim($id_turma));
            echo "Validando turma: $id_turma<br>";
            if (!isset($turma_map[$id_turma])) {
                error_log("Erro: Turma inválida ($id_turma)");
                echo "Erro: Turma inválida<br>";
                return false;
            }
            $id_turma_mapped = $turma_map[$id_turma];

            $curso_map = [
                'enfermagem' => 1,
                'informática' => 2,
                'administração' => 3,
                'edificações' => 4,
                'meio ambiente' => 5
            ];
            $id_curso = strtolower(trim($id_curso));
            echo "Validando curso: $id_curso<br>";
            if (!isset($curso_map[$id_curso])) {
                error_log("Erro: Curso inválido ($id_curso)");
                echo "Erro: Curso inválido<br>";
                return false;
            }
            $id_curso_mapped = $curso_map[$id_curso];

            echo "Verificando matrícula duplicada: $matricula<br>";
            $checkMatricula = $this->connect->prepare("SELECT id_aluno FROM aluno WHERE matricula = :matricula");
            $checkMatricula->bindValue(":matricula", $matricula);
            $checkMatricula->execute();
            if ($checkMatricula->rowCount() > 0) {
                error_log("Erro: Matrícula já cadastrada ($matricula)");
                echo "Erro: Matrícula já cadastrada<br>";
                return false;
            }

            echo "Executando inserção: id_turma=$id_turma_mapped, matricula=$matricula, nome=$nome, id_curso=$id_curso_mapped<br>";
            $cadastrar = "INSERT INTO aluno (id_turma, matricula, nome, id_curso) VALUES (:id_turma, :matricula, :nome, :id_curso)";
            $query = $this->connect->prepare($cadastrar);
            $query->bindValue(":id_turma", $id_turma_mapped, PDO::PARAM_INT);
            $query->bindValue(":matricula", $matricula, PDO::PARAM_STR);
            $query->bindValue(":nome", $nome, PDO::PARAM_STR);
            $query->bindValue(":id_curso", $id_curso_mapped, PDO::PARAM_INT);

            if ($query->execute()) {
                $id_aluno = $this->connect->lastInsertId();
                error_log("Aluno cadastrado com sucesso: id_aluno=$id_aluno, id_turma=$id_turma_mapped, matricula=$matricula, nome=$nome, id_curso=$id_curso_mapped");

                // Inserir na tabela `cadastrar` se id_usuario for fornecido
                if ($id_usuario) {
                    $cadastrar_usuario = "INSERT INTO cadastrar (id_aluno, id_usuario) VALUES (:id_aluno, :id_usuario)";
                    $query_usuario = $this->connect->prepare($cadastrar_usuario);
                    $query_usuario->bindValue(":id_aluno", $id_aluno, PDO::PARAM_INT);
                    $query_usuario->bindValue(":id_usuario", $id_usuario, PDO::PARAM_INT);
                    if ($query_usuario->execute()) {
                        error_log("Registro na tabela cadastrar inserido: id_aluno=$id_aluno, id_usuario=$id_usuario");
                    } else {
                        error_log("Erro ao inserir na tabela cadastrar: id_aluno=$id_aluno, id_usuario=$id_usuario");
                    }
                }

                echo "Inserção bem-sucedida<br>";
                return true;
            } else {
                error_log("Erro: Falha ao executar a query de cadastro para matricula=$matricula");
                echo "Erro: Falha na execução da query<br>";
                return false;
            }
        } catch (PDOException $e) {
            error_log("Erro ao cadastrar aluno: " . $e->getMessage());
            echo "Erro PDO: " . $e->getMessage() . "<br>";
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

    public function registrarEntrada($nome_responsavel, $nome_conducente, $id_tipo_conducente, $id_tipo_responsavel, $date_time, $id_motivo, $id_usuario, $id_aluno)
    {
        try {
            // Conexão com o banco de dados



            $registrar = "INSERT INTO registro_entrada VALUES (NULL, :nome_responsavel, :nome_conducente, :id_tipo_conducente, :id_tipo_responsavel, :date_time, :id_motivo, :id_usuario, :id_aluno)";
            $query = $this->connect->prepare($registrar);


            $query->bindValue(":nome_responsavel", $nome_responsavel);
            $query->bindValue(":nome_conducente", $nome_conducente);
            $query->bindValue(":id_tipo_conducente", $id_tipo_conducente);
            $query->bindValue("id_tipo_responsavel", $id_tipo_responsavel);
            $query->bindValue(":date_time", $date_time);
            $query->bindValue(":id_motivo", $id_motivo);
            $query->bindValue(":id_usuario", $id_usuario);
            $query->bindValue(":id_aluno", $id_aluno);


            $query->execute();

            return true;
        } catch (PDOException $e) {

            echo "Erro: " . $e->getMessage();
            return false;
        }
    }

    public function registrarSaidaEstagio($aluno, $date_time)
    {
        try {
            // Conexão com o banco de dados


            // Verifica se o aluno existe na tabela aluno com base no nome
            $verificarAluno = "SELECT id_aluno FROM aluno WHERE nome = :nome";
            $queryVerificar = $this->connect->prepare($verificarAluno);
            $queryVerificar->bindValue(":nome", $aluno, PDO::PARAM_STR);
            $queryVerificar->execute();

            // Verifica se o aluno foi encontrado
            if ($queryVerificar->rowCount() > 0) {
                // Recupera o id_aluno
                $row = $queryVerificar->fetch(PDO::FETCH_ASSOC);
                $id_aluno = $row['id_aluno'];

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

                // Executa a query
                $query->execute();

                return 0; // Sucesso
            } else {

                return 2;
            }
        } catch (PDOException $e) {
            // Tratamento de erro
            return 3;
        }
    }
};

class SaidaEstagioModel extends connect
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getSaidasByDateRange($id_aluno, $startDate = null, $endDate = null)
    {
        if (empty($id_aluno)) {
            return [];
        }

        $sql = "SELECT se.*, a.nome AS nome_aluno 
                FROM saida_estagio se
                LEFT JOIN aluno a ON se.id_aluno = a.id_aluno 
                WHERE se.id_aluno = :id_aluno";
        if ($startDate && $endDate) {
            $sql .= " AND se.dae BETWEEN :start AND :end";
        }
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':id_aluno', $id_aluno, PDO::PARAM_INT);
        if ($startDate && $endDate) {
            $stmt->bindParam(':start', $startDate);
            $stmt->bindParam(':end', $endDate);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

class EntradaPDF extends connect
{



    public function __construct()
    {
        parent::__construct();
    }

    public function getSaidasByDateRange($id_aluno, $startDate = null, $endDate = null)
    {
        if (empty($id_aluno)) {
            return [];
        }

        $sql = "SELECT r.*, a.nome AS nome_aluno 
                FROM registro_entrada r
                LEFT JOIN aluno a ON r.id_aluno = a.id_aluno 
                WHERE r.id_aluno = :id_aluno";
        if ($startDate && $endDate) {
            $sql .= " AND r.date_time BETWEEN :start AND :end";
        }
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':id_aluno', $id_aluno, PDO::PARAM_INT);
        if ($startDate && $endDate) {
            $stmt->bindParam(':start', $startDate);
            $stmt->bindParam(':end', $endDate);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


class SaidaPDF extends connect
{


    public function __construct()
    {
        parent::__construct();
    }

    public function getSaidasByDateRange($id_aluno, $startDate = null, $endDate = null)
    {
        if (empty($id_aluno)) {
            return [];
        }

        $sql = "SELECT r.*, a.nome AS nome_aluno 
                FROM registro_saida r
                LEFT JOIN aluno a ON r.id_aluno = a.id_aluno 
                WHERE r.id_aluno = :id_aluno";
        if ($startDate && $endDate) {
            $sql .= " AND r.date_time BETWEEN :start AND :end";
        }
        $stmt = $this->connect->prepare($sql);
        $stmt->bindParam(':id_aluno', $id_aluno, PDO::PARAM_INT);
        if ($startDate && $endDate) {
            $stmt->bindParam(':start', $startDate);
            $stmt->bindParam(':end', $endDate);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
