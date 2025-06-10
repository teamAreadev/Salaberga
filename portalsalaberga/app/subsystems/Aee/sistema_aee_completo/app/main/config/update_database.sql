-- Atualizar a tabela de alunos
ALTER TABLE alunos CHANGE COLUMN senha password VARCHAR(255) NOT NULL;

-- Atualizar a tabela de responsáveis
ALTER TABLE responsaveis CHANGE COLUMN senha password VARCHAR(255) NOT NULL;

-- Recriar os índices
DROP INDEX IF EXISTS idx_alunos_senha ON alunos;
DROP INDEX IF EXISTS idx_responsaveis_senha ON responsaveis;

CREATE INDEX idx_alunos_password ON alunos(password);
CREATE INDEX idx_responsaveis_password ON responsaveis(password); 