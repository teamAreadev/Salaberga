-- Atualizar a tabela de responsáveis
ALTER TABLE responsaveis CHANGE COLUMN senha password VARCHAR(255) NOT NULL;

-- Inserir responsável de teste (senha: resp123)
INSERT INTO responsaveis (email, password, nome, cpf) VALUES 
('resp@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Responsável Teste', '123.456.789-00'); 