-- Banco de dados para Copa Grêmio 2025
CREATE DATABASE IF NOT EXISTS copa_gremio;
USE copa_gremio;

-- Tabela de alunos
CREATE TABLE IF NOT EXISTS alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    ano VARCHAR(10) NOT NULL,
    turma VARCHAR(10) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefone VARCHAR(20) NOT NULL,
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de inscrições
CREATE TABLE IF NOT EXISTS inscricoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    modalidade VARCHAR(50) NOT NULL,
    categoria VARCHAR(20) DEFAULT 'misto',
    nome_equipe VARCHAR(100),
    status ENUM('pendente', 'aprovado', 'reprovado') DEFAULT 'pendente',
    data_aprovacao TIMESTAMP NULL,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id) ON DELETE CASCADE
);

-- Tabela de usuários admin
CREATE TABLE IF NOT EXISTS admin_usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Inserir um usuário admin padrão (senha: admin123 em MD5)
INSERT INTO admin_usuarios (usuario, senha, nome) VALUES
('admin', '0192023a7bbd73250516f069df18b500', 'Administrador'); 