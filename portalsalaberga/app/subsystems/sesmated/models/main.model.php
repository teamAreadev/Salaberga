<?php
require_once('../config/connect.php');

class main_model extends connect
{

    function __construct()
    {
        parent::__construct();
    }

    //rifas 
    public function adicionar_turma($id_turma, $rifas, $id_usuario)
    {
        $valor = $rifas * 2;
        // Verifica se já existe registro para a turma
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_01_rifas WHERE turma_id = :turma_id");
        $stmt_check->bindValue(':turma_id', $id_turma);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_01_rifas`(`turma_id`, `id_usuario`, `valor_arrecadado`, `quantidades_rifas`) VALUES ( :turma_id, :id_usuario, :valor, :quantidades)");
            $stmt_adcionar->bindValue(':turma_id', $id_turma);
            $stmt_adcionar->bindValue(':id_usuario', $id_usuario);
            $stmt_adcionar->bindValue(':valor', $valor);
            $stmt_adcionar->bindValue(':quantidades', $rifas);

            if ($stmt_adcionar->execute()) {

                return 1;
            } else {

                return 2;
            }
        } else {

            return 3;
        }
    }

    //grito
    public function confirmar_grito($id_curso, $grito)
    {
        $pontuacao = $grito == "sim" ? 500 : 0;
        $grito = $grito == "sim" ? 1 : 0;
        // Verifica se já existe registro para a turma
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_02_grito_guerra WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_02_grito_guerra`(`curso_id`, `cumprida`, `pontuacao`) VALUES (:curso_id, :cumprida, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':cumprida', $grito);
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {

                return 1;
            } else {

                return 2;
            }
        } else {

            return 3;
        }
    }
    //mascote
    public function confirmar_mascote($curso_id, $nota_animacao, $nota_vestimenta, $nota_identidade)
    {
        // Verifica se já existe registro para o curso
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_03_mascote WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $curso_id);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO tarefa_03_mascote (curso_id, animacao, vestimenta, identidade_curso) VALUES (:curso_id, :animacao, :vestimenta, :identidade)");
            $stmt_adcionar->bindValue(':curso_id', $curso_id);
            $stmt_adcionar->bindValue(':animacao', $nota_animacao);
            $stmt_adcionar->bindValue(':vestimenta', $nota_vestimenta);
            $stmt_adcionar->bindValue(':identidade', $nota_identidade);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //logo
    public function confirmar_logo($criterios, $pontuacao, $id_curso)
    {
        // Verifica se já existe registro para a turma
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_04_logo WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_04_logo`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //esquete
    public function confirmar_esquete($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_05_esquete WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_05_esquete`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //cordel
    public function confirmar_cordel($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_06_cordel WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_06_cordel`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //parodia
    public function confirmar_parodia($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_07_parodia WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_07_parodia`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //vestimentas sustentaveis
    public function confirmar_vestimentas($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_08_vestimentas WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_08_vestimentas`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //workshops
    public function confirmar_workshops($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_09_workshops WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_09_workshops`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //sala temática
    public function confirmar_sala_tematica($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_10_sala_tematica WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_10_sala_tematica`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //palestras
    public function confirmar_palestras($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_11_palestras WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_11_palestras`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //painel
    public function confirmar_painel($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_12_painel WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_12_painel`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //empreendedorismo
    public function confirmar_empreendedorismo($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_13_empreendedorismo WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_13_empreendedorismo`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }

    //inovacao
    public function confirmar_inovacao($criterios, $pontuacao, $id_curso)
    {
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_14_inovacao WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_14_inovacao`(`curso_id`, `criterios`, `pontuacao`) VALUES (:curso_id, :criterios, :pontuacao)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':criterios', json_encode($criterios));
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

            if ($stmt_adcionar->execute()) {
                return 1;
            } else {
                return 2;
            }
        } else {
            return 3;
        }
    }
}
