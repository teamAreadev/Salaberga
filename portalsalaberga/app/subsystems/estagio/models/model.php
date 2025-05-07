<?php
require_once('../config/connect.php');


class main_model extends connect
{
    function __construct()
    {
        parent::__construct();
    }

    function login($email, $senha)
    {
        session_start();
        $stmt_cadastro = $this->connect->prepare("SELECT * FROM usuario WHERE email = :email AND senha = :senha");
        $stmt_cadastro->bindValue(':email', $email);
        $stmt_cadastro->bindValue(':senha', $senha);
        $stmt_cadastro->execute();

        if ($stmt_cadastro->rowCount() > 0) {

            $_SESSION['email'] = $email;
            return 1;
        } else {

            unset($_SESSION['email']);
            return 2;
        }
    }
    function cadastrar_empresa($nome, $endereco, $telefone)
    {
        // Verificar se a empresa já existe
        $stmt_check = $this->connect->prepare("SELECT * FROM concedentes WHERE nome = :nome");
        $stmt_check->bindValue(':nome', $nome);
        $stmt_check->execute();
        $result = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if (empty($result)) {
            
            try {

                $stmt_cadastrar_empresa = $this->connect->prepare("INSERT INTO concedentes VALUES (null, :nome, :contato, :endereco)");
                $stmt_cadastrar_empresa->bindValue(':nome', $nome);
                $stmt_cadastrar_empresa->bindValue(':contato', $telefone);
                $stmt_cadastrar_empresa->bindValue(':endereco', $endereco);
                $stmt_cadastrar_empresa->execute();

                return 1;

            } catch (Exception $e) {
                
                return 2; 
            }
        } else {
            return 3; 
        }
    }
    function cadastrar_vaga($id_empresa, $id_area, $quantidade, $data, $tipo_vaga, $hora)
    {
        $stmt_cadastrar_vagas = $this->connect->prepare("INSERT INTO vagas VALUES (null, :id_concedente, :id_perfil, :quantidade, :data, :tipo_vaga, :hora)");
        $stmt_cadastrar_vagas->bindValue(':id_perfil', $id_area);
        $stmt_cadastrar_vagas->bindValue(':id_concedente', $id_empresa);
        $stmt_cadastrar_vagas->bindValue(':quantidade', $quantidade);
        $stmt_cadastrar_vagas->bindValue(':data', $data);
        $stmt_cadastrar_vagas->bindValue(':tipo_vaga', $tipo_vaga);
        $stmt_cadastrar_vagas->bindValue(':hora', $hora);
        $stmt_cadastrar_vagas->execute();

        if ($stmt_cadastrar_vagas) {
            return 1;
        } else {
            return 2;
        }
    }

    function selecao($alunos, $id_vaga)
    {
        foreach ($alunos as $aluno) {
            $stmt = $this->connect->query("SELECT * FROM selecao WHERE id_aluno = '$aluno' AND id_vaga = '$id_vaga'");

            if ($stmt->rowCount() > 0) {

                return 3;
            }
        }

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        foreach ($alunos as $aluno) {

            $stmt = $this->connect->query("INSERT INTO selecao VALUES(null, '$aluno', '$id_vaga')");
        }
        if ($stmt) {

            return 1;
        } {

            return 2;
        }
    }
    function editar_aluno($id, $nome, $contato, $medias, $email, $projetos, $perfil_opc1, $perfil_opc2, $ocorrencia, $custeio, $entregas_individuais, $entregas_grupo)
    {

        $stmt = $this->connect->prepare("UPDATE `aluno` SET `nome`=:nome, `contato`=:contato, `medias`=:medias, `email`=:email, `projetos`=:projetos, `perfil_opc1`=:opc1, `perfil_opc2`=:opc2, `ocorrencia`=:ocorrencia, `custeio`=:custeio,  `entregas_individuais`=:entrega_individuais, `entregas_grupo`=:entrega_grupo WHERE id = :id");

        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':contato', $contato);
        $stmt->bindValue(':medias', $medias);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':projetos', $projetos);
        $stmt->bindValue(':opc1', $perfil_opc1);
        $stmt->bindValue(':opc2', $perfil_opc2);
        $stmt->bindValue(':ocorrencia', $ocorrencia);
        $stmt->bindValue(':custeio', $custeio);
        $stmt->bindValue(':entrega_individuais', $entregas_individuais);
        $stmt->bindValue(':entrega_grupo', $entregas_grupo);
        $stmt->bindValue(':id', $id);

        $stmt->execute();

        if ($stmt) {

            return 1;
        } else {

            return 2;
        }
    }
}
