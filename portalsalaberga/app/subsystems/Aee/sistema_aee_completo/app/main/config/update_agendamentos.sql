-- Primeiro, adicionar a coluna turma_id na tabela agendamentos se não existir
SET @exists_turma_id_agendamentos = (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'agendamentos'
    AND COLUMN_NAME = 'turma_id'
);

SET @sql_add_turma_id = IF(@exists_turma_id_agendamentos = 0,
    'ALTER TABLE agendamentos ADD COLUMN turma_id INT',
    'SELECT 1');

PREPARE stmt FROM @sql_add_turma_id;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Atualizar a estrutura da tabela agendamentos
ALTER TABLE agendamentos
MODIFY COLUMN tipo ENUM('Equipamento', 'Espaço') NOT NULL,
MODIFY COLUMN status ENUM('pendente', 'confirmado', 'cancelado') NOT NULL DEFAULT 'pendente';

-- Atualizar turma_id nos agendamentos existentes
UPDATE agendamentos a
JOIN alunos al ON a.aluno_id = al.id
SET a.turma_id = al.turma_id
WHERE a.turma_id IS NULL;

-- Agora que temos certeza que a coluna existe e tem dados, adicionar a chave estrangeira
ALTER TABLE agendamentos
MODIFY COLUMN turma_id INT NOT NULL,
ADD CONSTRAINT fk_agendamentos_turma
FOREIGN KEY (turma_id) REFERENCES turmas(id) ON DELETE CASCADE;

-- Por último, adicionar os índices
ALTER TABLE agendamentos
ADD INDEX IF NOT EXISTS idx_tipo (tipo),
ADD INDEX IF NOT EXISTS idx_turma (turma_id),
ADD INDEX IF NOT EXISTS idx_data_hora (data_hora),
ADD INDEX IF NOT EXISTS idx_status (status); 