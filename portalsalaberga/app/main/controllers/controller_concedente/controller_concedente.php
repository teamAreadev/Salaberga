<?php

class ConcedenteController {
    private $conn;

    public function __construct() {
        $this->connectDB();
    }

    private function connectDB() {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "form_concedentes";

        // Criar conexão
        $this->conn = new mysqli($servername, $username, $password, $dbname);

        // Verificar conexão
        if ($this->conn->connect_error) {
            die("Conexão falhou: " . $this->conn->connect_error);
        }
    }

    public function inserirConcedente($dados) {
        $stmt = $this->conn->prepare("INSERT INTO concedentes (tipo_instituicao, rede, razao_social, nome_fantasia, cnpj, telefone_institucional, especificacao_atividade, email_institucional, nome_representante, email_representante, cpf_representante, rg_representante, nome_supervisor, email_supervisor, celular_supervisor, whats_do_supervisor, endereco, numero, complemento, cep, bairro, municipio, observacoes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssssssssssssssss",
            $dados['tipo_instituicao'],
            $dados['rede'],
            $dados['razao_social'],
            $dados['nome_fantasia'],
            $dados['cnpj'],
            $dados['telefone_institucional'],
            $dados['especificacao_atividade'],
            $dados['email_institucional'],
            $dados['nome_representante'],
            $dados['email_representante'],
            $dados['cpf_representante'],
            $dados['rg_representante'],
            $dados['nome_supervisor'],
            $dados['email_supervisor'],
            $dados['celular_supervisor'],
            $dados['whats_do_supervisor'],
            $dados['endereco'],
            $dados['numero'],
            $dados['complemento'],
            $dados['cep'],
            $dados['bairro'],
            $dados['municipio'],
            $dados['observacoes']
        );

        if ($stmt->execute()) {
            echo "Novo registro criado com sucesso";
        } else {
            echo "Erro: " . $stmt->error;
        }

        $stmt->close();
    }

    public function __destruct() {
        $this->conn->close();
    }
}

// Exemplo de uso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ConcedenteController();
    $controller->inserirConcedente($_POST);
}

?> 