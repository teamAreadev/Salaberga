-- Desativar verificação de chaves estrangeiras
SET FOREIGN_KEY_CHECKS = 0;

-- Limpar tabelas existentes
DROP TABLE IF EXISTS equipe_membros;
DROP TABLE IF EXISTS inscricoes;
DROP TABLE IF EXISTS equipes;
DROP TABLE IF EXISTS alunos;
DROP TABLE IF EXISTS admins;

-- Tabela de alunos
CREATE TABLE alunos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    telefone VARCHAR(20),
    ano VARCHAR(10),
    turma VARCHAR(10),
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de equipes
CREATE TABLE equipes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    modalidade VARCHAR(50) NOT NULL,
    categoria VARCHAR(20) NOT NULL,
    lider_id INT NOT NULL,
    codigo_acesso VARCHAR(6) NOT NULL UNIQUE,
    limite_membros INT NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lider_id) REFERENCES alunos(id)
);

-- Tabela de membros das equipes
CREATE TABLE equipe_membros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipe_id INT NOT NULL,
    aluno_id INT NOT NULL,
    data_entrada TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipe_id) REFERENCES equipes(id),
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    UNIQUE KEY unique_membro (equipe_id, aluno_id)
);

-- Tabela de inscrições
CREATE TABLE inscricoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    aluno_id INT NOT NULL,
    modalidade VARCHAR(50) NOT NULL,
    categoria VARCHAR(20) NOT NULL,
    nome_equipe VARCHAR(255),
    equipe_id INT,
    status VARCHAR(20) DEFAULT 'pendente',
    data_inscricao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_aprovacao TIMESTAMP NULL,
    FOREIGN KEY (aluno_id) REFERENCES alunos(id),
    FOREIGN KEY (equipe_id) REFERENCES equipes(id)
);

-- Tabela de administradores
CREATE TABLE admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Reativar verificação de chaves estrangeiras
SET FOREIGN_KEY_CHECKS = 1;

-- Inserir dados de teste

-- Inserir alunos
INSERT INTO alunos (nome, email, telefone, ano, turma) VALUES
('João Silva', 'joao@teste.com', '11999999999', '3', 'A'),
('Maria Santos', 'maria@teste.com', '11988888888', '2', 'B'),
('Pedro Souza', 'pedro@teste.com', '11977777777', '1', 'C'),
('Ana Oliveira', 'ana@teste.com', '11966666666', '3', 'A'),
('Lucas Pereira', 'lucas@teste.com', '11955555555', '2', 'B');

-- Inserir equipes
INSERT INTO equipes (nome, modalidade, categoria, lider_id, codigo_acesso, limite_membros) VALUES
('Time Futsal A', 'futsal', 'masculino', 1, 'ABC123', 9),
('Time Vôlei A', 'volei', 'misto', 2, 'DEF456', 12),
('Time Queimada A', 'queimada', 'feminino', 3, 'GHI789', 12),
('Dupla Tênis', 'tenis_de_mesa', 'masculino', 4, 'JKL012', 2);

-- Inserir membros nas equipes
INSERT INTO equipe_membros (equipe_id, aluno_id) VALUES
(1, 1), -- Time Futsal A - João (líder)
(1, 2), -- Time Futsal A - Maria
(1, 3), -- Time Futsal A - Pedro
(2, 2), -- Time Vôlei A - Maria (líder)
(2, 4), -- Time Vôlei A - Ana
(3, 3), -- Time Queimada A - Pedro (líder)
(3, 4), -- Time Queimada A - Ana
(4, 4), -- Dupla Tênis - Ana (líder)
(4, 5); -- Dupla Tênis - Lucas

-- Inserir inscrições
INSERT INTO inscricoes (aluno_id, modalidade, categoria, nome_equipe, equipe_id, status) VALUES
(1, 'futsal', 'masculino', 'Time Futsal A', 1, 'aprovado'),
(2, 'futsal', 'masculino', 'Time Futsal A', 1, 'aprovado'),
(3, 'futsal', 'masculino', 'Time Futsal A', 1, 'aprovado'),
(2, 'volei', 'misto', 'Time Vôlei A', 2, 'aprovado'),
(4, 'volei', 'misto', 'Time Vôlei A', 2, 'aprovado'),
(3, 'queimada', 'feminino', 'Time Queimada A', 3, 'aprovado'),
(4, 'queimada', 'feminino', 'Time Queimada A', 3, 'aprovado'),
(4, 'tenis_de_mesa', 'masculino', 'Dupla Tênis', 4, 'aprovado'),
(5, 'tenis_de_mesa', 'masculino', 'Dupla Tênis', 4, 'aprovado');

-- Inserir admin padrão (usuário: admin, senha: admin123)
INSERT INTO admins (nome, usuario, senha) VALUES
('Administrador', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'); 