-- Script para adicionar coluna de data na tabela produtos
-- Execute este script no seu banco de dados MySQL

-- Adicionar coluna data_cadastro na tabela produtos
ALTER TABLE produtos ADD COLUMN data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Atualizar registros existentes com data atual
UPDATE produtos SET data_cadastro = NOW() WHERE data_cadastro IS NULL;

-- Verificar se a coluna foi adicionada corretamente
DESCRIBE produtos; 