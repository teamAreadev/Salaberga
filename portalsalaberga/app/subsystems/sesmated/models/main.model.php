<?php
require_once('../config/connect.php');

class main_model extends connect
{

    function __construct()
    {
        parent::__construct();
    }

    //funções a parte
    public function adicionar_avaliador($nome, $email, $turno, $data, $senha)
    {
        $stmt_check = $this->connect_salaberga->prepare("SELECT * FROM usuarios WHERE email = :email");
        $stmt_check->bindValue(':email', $email);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            // Gerar senha automática numérica de 6 dígitos

            $stmt_usuario = $this->connect_salaberga->prepare("INSERT INTO usuarios(id, nome, senha, email) VALUES (null, :nome, md5(:senha), :email)");
            $stmt_usuario->bindValue(':nome', $nome);
            $stmt_usuario->bindValue(':email', $email);
            $stmt_usuario->bindValue(':senha', $senha);

            if ($stmt_usuario->execute()) {
                // Retornar a senha numérica gerada para possível envio ao usuário
                $stmt_id_usuario = $this->connect_salaberga->prepare("SELECT id FROM usuarios WHERE email = :email");
                $stmt_id_usuario->bindValue(':email', $email);
                $stmt_id_usuario->execute();
                $id_usuario_array = $stmt_id_usuario->fetch(PDO::FETCH_ASSOC);
                $id_usuario = $id_usuario_array['id'];

                $sist_perm = 23;
                $stmt_usu_sist = $this->connect_salaberga->prepare("INSERT INTO `usu_sist`(`usuario_id`, `sist_perm_id`) VALUES ( :id_usuario, :id_sist_perm)");
                $stmt_usu_sist->bindValue(':id_usuario', $id_usuario);
                $stmt_usu_sist->bindValue(':id_sist_perm', $sist_perm);
                $stmt_usu_sist->execute();

                $stmt_avaliadores = $this->connect->prepare("INSERT INTO `avaliadores`(`nome`, `data`, `turno`, `id_usuario`) VALUES (:nome, :data, :turno, :id_usuario)");
                $stmt_avaliadores->bindValue(':nome', $nome);
                $stmt_avaliadores->bindValue(':data', $data);
                $stmt_avaliadores->bindValue(':turno', $turno);
                $stmt_avaliadores->bindValue(':id_usuario', $id_usuario);

                if ($stmt_avaliadores->execute()) {
                    // Retornar a senha numérica gerada para possível envio ao usuário
                    return 1;
                } else {
                    return 2;
                }
            } else {
                return 2;
            }
        } else {
            // Retornar a senha numérica gerada para possível envio ao usuário
            $stmt_id_usuario = $this->connect_salaberga->prepare("SELECT id FROM usuarios WHERE email = :email");
            $stmt_id_usuario->bindValue(':email', $email);
            $stmt_id_usuario->execute();
            $id_usuario_array = $stmt_id_usuario->fetch(PDO::FETCH_ASSOC);
            $id_usuario = $id_usuario_array['id'];

            $sist_perm = 23;
            $stmt_usu_sist = $this->connect_salaberga->prepare("INSERT INTO `usu_sist`(`usuario_id`, `sist_perm_id`) VALUES ( :id_usuario, :id_sist_perm)");
            $stmt_usu_sist->bindValue(':id_usuario', $id_usuario);
            $stmt_usu_sist->bindValue(':id_sist_perm', $sist_perm);
            $stmt_usu_sist->execute();

            $stmt_avaliadores = $this->connect->prepare("INSERT INTO `avaliadores`(`nome`, `data`, `turno`, `id_usuario`) VALUES (:nome, :data, :turno, :id_usuario)");
            $stmt_avaliadores->bindValue(':nome', $nome);
            $stmt_avaliadores->bindValue(':data', $data);
            $stmt_avaliadores->bindValue(':turno', $turno);
            $stmt_avaliadores->bindValue(':id_usuario', $id_usuario);

            if ($stmt_avaliadores->execute()) {
                // Retornar a senha numérica gerada para possível envio ao usuário
                return 1;
            } else {
                return 2;
            }
        }
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

            $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
            $stmt_id_avaliador->bindValue(':id_usuario', $id_usuario);
            $stmt_id_avaliador->execute();
            $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

            $id_avaliador = $result['id'];
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_01_rifas`(`turma_id`, `id_usuario`, `valor_arrecadado`, `quantidades_rifas`) VALUES ( :turma_id, :id_usuario, :valor, :quantidades)");
            $stmt_adcionar->bindValue(':turma_id', $id_turma);
            $stmt_adcionar->bindValue(':id_usuario', $id_avaliador);
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
    public function confirmar_grito($id_curso, $grito, $id_avaliador)
    {
        $pontuacao = $grito == "sim" ? 500 : 0;
        $grito = $grito == "sim" ? 1 : 0;
        // Verifica se já existe registro para a turma
        $stmt_check = $this->connect->prepare("SELECT * FROM tarefa_02_grito_guerra WHERE curso_id = :curso_id");
        $stmt_check->bindValue(':curso_id', $id_curso);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {

            $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
            $stmt_id_avaliador->bindValue(':id_usuario', $id_avaliador);
            $stmt_id_avaliador->execute();
            $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

            $id_avaliador = $result['id'];
            $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_02_grito_guerra`(`curso_id`, `cumprida`, `pontuacao`, `id_avaliador`) VALUES (:curso_id, :cumprida, :pontuacao, :id)");
            $stmt_adcionar->bindValue(':curso_id', $id_curso);
            $stmt_adcionar->bindValue(':cumprida', $grito);
            $stmt_adcionar->bindValue(':pontuacao', $pontuacao);
            $stmt_adcionar->bindValue(':id', $id_avaliador);

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
    public function confirmar_mascote($curso_id, $nota_animacao, $nota_vestimenta, $nota_identidade, $id_avaliador)
    {
        $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
        $stmt_id_avaliador->bindValue(':id_usuario', $id_avaliador);
        $stmt_id_avaliador->execute();
        $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

        $id_avaliador = $result['id'];
        $stmt_adcionar = $this->connect->prepare("INSERT INTO tarefa_03_mascote (curso_id, animacao, vestimenta, identidade_curso, id_avaliador) VALUES (:curso_id, :animacao, :vestimenta, :identidade, :id)");
        $stmt_adcionar->bindValue(':curso_id', $curso_id);
        $stmt_adcionar->bindValue(':animacao', $nota_animacao);
        $stmt_adcionar->bindValue(':vestimenta', $nota_vestimenta);
        $stmt_adcionar->bindValue(':identidade', $nota_identidade);
        $stmt_adcionar->bindValue(':id', $id_avaliador);
        if ($stmt_adcionar->execute()) {
            return 1;
        } else {
            return 2;
        }
    }

    //logo
    public function confirmar_logo($cursoSelecionado, $notaElementos, $notaImpressa, $notaDigital, $avaliadorId)
    {
        // Verifica se já existe registro para o curso

        $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
        $stmt_id_avaliador->bindValue(':id_usuario', $avaliadorId);
        $stmt_id_avaliador->execute();
        $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

        $id_avaliador = $result['id'];
        $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_04_logomarca` VALUES (null, :curso_id, :id_avaliador, :elementos_cursos, :entrega_a3, :entrega_digital)");
        $stmt_adcionar->bindValue(':curso_id', $cursoSelecionado);
        $stmt_adcionar->bindValue(':id_avaliador', $id_avaliador);
        $stmt_adcionar->bindValue(':elementos_cursos', $notaElementos);
        $stmt_adcionar->bindValue(':entrega_a3', $notaImpressa);
        $stmt_adcionar->bindValue(':entrega_digital', $notaDigital);
        if ($stmt_adcionar->execute()) {
            return 1;
        } else {
            return 2;
        }
    }

    //esquete
    public function confirmar_esquete($cursoSelecionado, $notaTempo, $notaTema, $notaFigurino, $notaCriatividade, $avaliadorId)
    {

        $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
        $stmt_id_avaliador->bindValue(':id_usuario', $avaliadorId);
        $stmt_id_avaliador->execute();
        $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

        $id_avaliador = $result['id'];
        $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_05_esquete`(`curso_id`, `id_avaliador`, `tempo`, `tema`, `figurino`, `criatividade`) VALUES (:curso_id, :id_avaliador, :tempo, :tema, :figurino, :criatividade)");
        $stmt_adcionar->bindValue(':curso_id', $cursoSelecionado);
        $stmt_adcionar->bindValue(':id_avaliador', $id_avaliador);
        $stmt_adcionar->bindValue(':tempo', $notaTempo);
        $stmt_adcionar->bindValue(':tema', $notaTema);
        $stmt_adcionar->bindValue(':figurino', $notaFigurino);
        $stmt_adcionar->bindValue(':criatividade', $notaCriatividade);
        if ($stmt_adcionar->execute()) {
            return 1;
        } else {
            return 2;
        }
    }

    //cordel
    public function confirmar_cordel($nota_tema, $nota_estrutura, $nota_declamacao, $nota_criatividade, $nota_apresentacao, $curso_id, $id_usuario)
    {

        $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
        $stmt_id_avaliador->bindValue(':id_usuario', $id_usuario);
        $stmt_id_avaliador->execute();
        $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

        $id_avaliador = $result['id'];
        $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_06_cordel`(`curso_id`, `id_avaliador`, `adequacao_tema`, `estrutura_cordel`, `declamacao`, `criatividade`, `apresentacao_impressa`) VALUES (:curso_id, :id_avaliador, :adequacao_tema, :estrutura_cordel, :declamacao, :criatividade, :apresentacao_impressa)");
        $stmt_adcionar->bindValue(':curso_id', $curso_id);
        $stmt_adcionar->bindValue(':id_avaliador', $id_avaliador);
        $stmt_adcionar->bindValue(':adequacao_tema', $nota_tema);
        $stmt_adcionar->bindValue(':estrutura_cordel', $nota_estrutura);
        $stmt_adcionar->bindValue(':declamacao', $nota_declamacao);
        $stmt_adcionar->bindValue(':criatividade', $nota_criatividade);
        $stmt_adcionar->bindValue(':apresentacao_impressa', $nota_apresentacao);
        if ($stmt_adcionar->execute()) {
            return 1;
        } else {
            return 2;
        }
    }


    //parodia
    public function confirmar_parodia($nota_tema, $nota_letra, $nota_diccao, $nota_desempenho, $nota_trilha, $nota_criatividade, $curso_id, $id_usuario)
    {

        $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
        $stmt_id_avaliador->bindValue(':id_usuario', $id_usuario);
        $stmt_id_avaliador->execute();
        $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

        $id_avaliador = $result['id'];
        $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_07_parodia`(`avaliacao_id`, `curso_id`, `id_avaliador`, `adequacao_tema`, `letra_adaptada`, `diccao_clareza_entonacao`, `desempenho_artistico`, `trilha_sonora_sincronia`, `criatividade_originalidade`) VALUES ('[value-1]', :curso_id, :id_avaliador, :adequacao_tema, :letra_adaptada, :diccao_clareza_entonacao, :desempenho_artistico, :trilha_sonora_sincronia, :criatividade_originalidade)");
        $stmt_adcionar->bindValue(':curso_id', $curso_id);
        $stmt_adcionar->bindValue(':id_avaliador', $id_avaliador);
        $stmt_adcionar->bindValue(':adequacao_tema', $nota_tema);
        $stmt_adcionar->bindValue(':letra_adaptada', $nota_letra);
        $stmt_adcionar->bindValue(':diccao_clareza_entonacao', $nota_diccao);
        $stmt_adcionar->bindValue(':desempenho_artistico', $nota_desempenho);
        $stmt_adcionar->bindValue(':trilha_sonora_sincronia', $nota_trilha);
        $stmt_adcionar->bindValue(':criatividade_originalidade', $nota_criatividade);
        if ($stmt_adcionar->execute()) {
            return 1;
        } else {
            return 2;
        }
    }

    //vestimentas sustentaveis
    public function confirmar_vestimentas($curso, $id_avaliador, $pontuacao)
    {
        $stmt_id_avaliador = $this->connect->prepare("SELECT id FROM avaliadores WHERE id_usuario = :id_usuario");
        $stmt_id_avaliador->bindValue(':id_usuario', $id_avaliador);
        $stmt_id_avaliador->execute();
        $result = $stmt_id_avaliador->fetch(PDO::FETCH_ASSOC);

        $id_avaliador = $result['id'];

        $stmt_adcionar = $this->connect->prepare("INSERT INTO `tarefa_08_vestimentas`( `curso_id`, `id_avaliador`, `pontuação`) VALUES ( :curso_id, :id_avaliador, :pontuacao)");
        $stmt_adcionar->bindValue(':curso_id', $curso);
        $stmt_adcionar->bindValue(':id_avaliador', $id_avaliador);
        $stmt_adcionar->bindValue(':pontuacao', $pontuacao);

        if ($stmt_adcionar->execute()) {
            return 1;
        } else {
            return 2;
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
