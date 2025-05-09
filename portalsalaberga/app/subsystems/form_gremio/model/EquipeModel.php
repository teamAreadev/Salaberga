<?php
require_once __DIR__ . '/../config/database.php';

class EquipeModel {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    
    /**
     * Cria uma nova equipe e gera código de acesso
     * @param array $dados Dados da equipe
     * @return array Resultado da operação
     */
    public function criarEquipe($dados) {
        try {
            // Iniciar transação
            $this->db->beginTransaction();
            
            error_log("criarEquipe - Iniciando criação para o aluno ID: " . $dados['aluno_id']);
            
            // Verificar se o aluno existe
            $queryAluno = "SELECT * FROM alunos WHERE id = :aluno_id";
            $stmtAluno = $this->db->prepare($queryAluno);
            $stmtAluno->bindParam(':aluno_id', $dados['aluno_id']);
            $stmtAluno->execute();
            
            if ($stmtAluno->rowCount() === 0) {
                error_log("criarEquipe - Aluno não encontrado: " . $dados['aluno_id']);
                return [
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ];
            }
            
            // Verificar limite de participantes por modalidade
            $limiteParticipantes = $this->getLimiteParticipantes($dados['modalidade']);
            
            if (!$limiteParticipantes) {
                error_log("criarEquipe - Modalidade inválida: " . $dados['modalidade']);
                return [
                    'success' => false,
                    'message' => 'Modalidade inválida ou não encontrada'
                ];
            }
            
            // Verificar se o aluno já tem uma inscrição para esta modalidade
            $queryInscricao = "SELECT * FROM inscricoes 
                             WHERE aluno_id = :aluno_id AND modalidade = :modalidade";
            $stmtInscricao = $this->db->prepare($queryInscricao);
            $stmtInscricao->bindParam(':aluno_id', $dados['aluno_id']);
            $stmtInscricao->bindParam(':modalidade', $dados['modalidade']);
            $stmtInscricao->execute();
            
            if ($stmtInscricao->rowCount() > 0) {
                error_log("criarEquipe - Aluno já tem inscrição para esta modalidade");
                return [
                    'success' => false,
                    'message' => 'Você já possui uma inscrição para a modalidade ' . $dados['modalidade'] . '. Somente é permitida uma inscrição por modalidade.'
                ];
            }
            
            // Gerar código único de acesso (6 caracteres alfanuméricos)
            $codigo = $this->gerarCodigoUnico();
            
            // Inserir equipe
            $query = "INSERT INTO equipes (nome, modalidade, categoria, lider_id, codigo_acesso, data_criacao, limite_membros) 
                     VALUES (:nome, :modalidade, :categoria, :lider_id, :codigo, NOW(), :limite)";
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(':nome', $dados['nome']);
            $stmt->bindParam(':modalidade', $dados['modalidade']);
            $stmt->bindParam(':categoria', $dados['categoria']);
            $stmt->bindParam(':lider_id', $dados['aluno_id']);
            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':limite', $limiteParticipantes);
            
            $result = $stmt->execute();
            
            if (!$result) {
                error_log("criarEquipe - Erro ao executar INSERT em equipes: " . json_encode($stmt->errorInfo()));
                throw new PDOException("Erro ao criar equipe: " . implode(", ", $stmt->errorInfo()));
            }
            
            $equipeId = $this->db->lastInsertId();
            
            error_log("criarEquipe - Equipe criada com ID: $equipeId");
            
            // Verificar se a equipe foi criada
            $queryEquipeVerificar = "SELECT * FROM equipes WHERE id = :equipe_id";
            $stmtEquipeVerificar = $this->db->prepare($queryEquipeVerificar);
            $stmtEquipeVerificar->bindParam(':equipe_id', $equipeId);
            $stmtEquipeVerificar->execute();
            
            if ($stmtEquipeVerificar->rowCount() === 0) {
                error_log("criarEquipe - ERRO: Equipe não foi criada corretamente");
                throw new PDOException("Equipe não foi criada corretamente");
            }
            
            // Adicionar o líder como membro da equipe automaticamente
            $queryMembro = "INSERT INTO equipe_membros (equipe_id, aluno_id, data_entrada) 
                           VALUES (:equipe_id, :aluno_id, NOW())";
            $stmtMembro = $this->db->prepare($queryMembro);
            
            $stmtMembro->bindParam(':equipe_id', $equipeId);
            $stmtMembro->bindParam(':aluno_id', $dados['aluno_id']);
            
            $result = $stmtMembro->execute();
            
            if (!$result) {
                error_log("criarEquipe - Erro ao executar INSERT em equipe_membros: " . json_encode($stmtMembro->errorInfo()));
                throw new PDOException("Erro ao adicionar líder como membro: " . implode(", ", $stmtMembro->errorInfo()));
            }
            
            error_log("criarEquipe - Líder adicionado como membro da equipe");
            
            // Verificar se o registro foi criado corretamente
            $queryVerificar = "SELECT COUNT(*) as total FROM equipe_membros WHERE equipe_id = :equipe_id AND aluno_id = :aluno_id";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            $stmtVerificar->bindParam(':equipe_id', $equipeId);
            $stmtVerificar->bindParam(':aluno_id', $dados['aluno_id']);
            $stmtVerificar->execute();
            $result = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] == 0) {
                error_log("criarEquipe - ERRO: Falha ao adicionar líder como membro da equipe");
                throw new PDOException("Falha ao adicionar líder como membro da equipe");
            }
            
            // Criar inscrição para esta equipe
            $queryInscricao = "INSERT INTO inscricoes (aluno_id, modalidade, categoria, nome_equipe, equipe_id, status) 
                              VALUES (:aluno_id, :modalidade, :categoria, :nome_equipe, :equipe_id, 'pendente')";
            $stmtInscricao = $this->db->prepare($queryInscricao);
            
            $stmtInscricao->bindParam(':aluno_id', $dados['aluno_id']);
            $stmtInscricao->bindParam(':modalidade', $dados['modalidade']);
            $stmtInscricao->bindParam(':categoria', $dados['categoria']);
            $stmtInscricao->bindParam(':nome_equipe', $dados['nome']);
            $stmtInscricao->bindParam(':equipe_id', $equipeId);
            
            $result = $stmtInscricao->execute();
            
            if (!$result) {
                error_log("criarEquipe - Erro ao executar INSERT em inscricoes: " . json_encode($stmtInscricao->errorInfo()));
                throw new PDOException("Erro ao criar inscrição: " . implode(", ", $stmtInscricao->errorInfo()));
            }
            
            error_log("criarEquipe - Inscrição criada para a equipe");
            
            // Verificar novamente se o aluno está associado à equipe
            try {
                $resultadoVerificacao = $this->listarEquipesUsuario($dados['aluno_id']);
                error_log("criarEquipe - Verificação final - resultado: " . json_encode($resultadoVerificacao));
            } catch (Exception $e) {
                error_log("criarEquipe - Erro na verificação final: " . $e->getMessage());
            }
            
            // Commit da transação
            $this->db->commit();
            error_log("criarEquipe - Transação concluída com sucesso");
            
            return [
                'success' => true,
                'message' => 'Equipe criada com sucesso!',
                'equipe_id' => $equipeId,
                'codigo' => $codigo
            ];
            
        } catch(PDOException $e) {
            // Rollback em caso de erro
            $this->db->rollBack();
            error_log("criarEquipe - ERRO: " . $e->getMessage() . " - Trace: " . $e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'Erro ao criar equipe: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Entrar em uma equipe existente usando o código de acesso
     * @param int $alunoId ID do aluno
     * @param string $codigo Código de acesso da equipe
     * @return array Resultado da operação
     */
    public function entrarEquipe($alunoId, $codigo) {
        try {
            // Iniciar transação
            $this->db->beginTransaction();
            
            error_log("entrarEquipe - Aluno $alunoId tentando entrar com código: $codigo");
            
            // Verificar se o aluno existe
            $queryAluno = "SELECT * FROM alunos WHERE id = :aluno_id";
            $stmtAluno = $this->db->prepare($queryAluno);
            $stmtAluno->bindParam(':aluno_id', $alunoId);
            $stmtAluno->execute();
            
            if ($stmtAluno->rowCount() === 0) {
                error_log("entrarEquipe - Aluno não encontrado: $alunoId");
                return [
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ];
            }
            
            // Verificar se o código é válido
            $queryEquipe = "SELECT * FROM equipes WHERE codigo_acesso = :codigo";
            $stmtEquipe = $this->db->prepare($queryEquipe);
            $stmtEquipe->bindParam(':codigo', $codigo);
            $stmtEquipe->execute();
            
            $equipe = $stmtEquipe->fetch(PDO::FETCH_ASSOC);
            
            if (!$equipe) {
                error_log("entrarEquipe - Código inválido: $codigo");
                return [
                    'success' => false,
                    'message' => 'Código de equipe inválido ou inexistente'
                ];
            }
            
            error_log("entrarEquipe - Equipe encontrada ID: " . $equipe['id']);
            
            // Verificar se a equipe já atingiu o limite de membros
            $queryContagem = "SELECT COUNT(*) as total FROM equipe_membros WHERE equipe_id = :equipe_id";
            $stmtContagem = $this->db->prepare($queryContagem);
            $stmtContagem->bindParam(':equipe_id', $equipe['id']);
            $stmtContagem->execute();
            $contagem = $stmtContagem->fetch(PDO::FETCH_ASSOC);
            
            if ($contagem['total'] >= $equipe['limite_membros']) {
                error_log("entrarEquipe - Equipe atingiu limite de membros: " . $contagem['total'] . "/" . $equipe['limite_membros']);
                return [
                    'success' => false,
                    'message' => 'Esta equipe já atingiu o limite máximo de ' . $equipe['limite_membros'] . ' membros'
                ];
            }
            
            // Verificar se o aluno já é membro desta equipe
            $queryMembro = "SELECT * FROM equipe_membros 
                           WHERE equipe_id = :equipe_id AND aluno_id = :aluno_id";
            $stmtMembro = $this->db->prepare($queryMembro);
            $stmtMembro->bindParam(':equipe_id', $equipe['id']);
            $stmtMembro->bindParam(':aluno_id', $alunoId);
            $stmtMembro->execute();
            
            if ($stmtMembro->rowCount() > 0) {
                error_log("entrarEquipe - Aluno já é membro desta equipe");
                return [
                    'success' => false,
                    'message' => 'Você já é membro desta equipe'
                ];
            }
            
            // Verificar se o aluno já tem uma inscrição para esta modalidade
            $queryInscricao = "SELECT * FROM inscricoes 
                             WHERE aluno_id = :aluno_id AND modalidade = :modalidade";
            $stmtInscricao = $this->db->prepare($queryInscricao);
            $stmtInscricao->bindParam(':aluno_id', $alunoId);
            $stmtInscricao->bindParam(':modalidade', $equipe['modalidade']);
            $stmtInscricao->execute();
            
            if ($stmtInscricao->rowCount() > 0) {
                error_log("entrarEquipe - Aluno já tem inscrição para esta modalidade");
                $inscricao = $stmtInscricao->fetch(PDO::FETCH_ASSOC);
                error_log("entrarEquipe - Detalhes da inscrição existente: " . json_encode($inscricao));
                
                // Se a inscrição já existir, mas não for para esta equipe, cancelamos a anterior e permitimos entrar nesta
                if (isset($inscricao['equipe_id']) && $inscricao['equipe_id'] == $equipe['id']) {
                    // Já está inscrito nesta mesma equipe
                    return [
                        'success' => false,
                        'message' => 'Você já possui uma inscrição para esta equipe'
                    ];
                }
                
                return [
                    'success' => false,
                    'message' => 'Você já possui uma inscrição para a modalidade ' . $equipe['modalidade'] . '. Somente é permitida uma inscrição por modalidade.'
                ];
            }
            
            // Adicionar aluno como membro da equipe
            $queryNovoMembro = "INSERT INTO equipe_membros (equipe_id, aluno_id, data_entrada) 
                              VALUES (:equipe_id, :aluno_id, NOW())";
            $stmtNovoMembro = $this->db->prepare($queryNovoMembro);
            $stmtNovoMembro->bindParam(':equipe_id', $equipe['id']);
            $stmtNovoMembro->bindParam(':aluno_id', $alunoId);
            $result = $stmtNovoMembro->execute();
            
            if (!$result) {
                error_log("entrarEquipe - Erro ao executar INSERT em equipe_membros: " . json_encode($stmtNovoMembro->errorInfo()));
                throw new PDOException("Erro ao adicionar membro à equipe: " . implode(", ", $stmtNovoMembro->errorInfo()));
            }
            
            error_log("entrarEquipe - Aluno adicionado como membro da equipe");
            
            // Verificar se o registro foi criado corretamente
            $queryVerificar = "SELECT COUNT(*) as total FROM equipe_membros WHERE equipe_id = :equipe_id AND aluno_id = :aluno_id";
            $stmtVerificar = $this->db->prepare($queryVerificar);
            $stmtVerificar->bindParam(':equipe_id', $equipe['id']);
            $stmtVerificar->bindParam(':aluno_id', $alunoId);
            $stmtVerificar->execute();
            $result = $stmtVerificar->fetch(PDO::FETCH_ASSOC);
            
            if ($result['total'] == 0) {
                error_log("entrarEquipe - ERRO: Falha ao adicionar membro à equipe");
                throw new PDOException("Falha ao adicionar membro à equipe");
            }
            
            // Criar inscrição para esta equipe
            $queryNovaInscricao = "INSERT INTO inscricoes (aluno_id, modalidade, categoria, nome_equipe, equipe_id, status) 
                                 VALUES (:aluno_id, :modalidade, :categoria, :nome_equipe, :equipe_id, 'pendente')";
            $stmtNovaInscricao = $this->db->prepare($queryNovaInscricao);
            $stmtNovaInscricao->bindParam(':aluno_id', $alunoId);
            $stmtNovaInscricao->bindParam(':modalidade', $equipe['modalidade']);
            $stmtNovaInscricao->bindParam(':categoria', $equipe['categoria']);
            $stmtNovaInscricao->bindParam(':nome_equipe', $equipe['nome']);
            $stmtNovaInscricao->bindParam(':equipe_id', $equipe['id']);
            $result = $stmtNovaInscricao->execute();
            
            if (!$result) {
                error_log("entrarEquipe - Erro ao executar INSERT em inscricoes: " . json_encode($stmtNovaInscricao->errorInfo()));
                throw new PDOException("Erro ao criar inscrição: " . implode(", ", $stmtNovaInscricao->errorInfo()));
            }
            
            error_log("entrarEquipe - Inscrição criada para o aluno na equipe");
            
            // Commit da transação
            $this->db->commit();
            error_log("entrarEquipe - Transação concluída com sucesso");
            
            return [
                'success' => true,
                'message' => 'Você entrou na equipe ' . $equipe['nome'] . ' com sucesso!',
                'equipe' => $equipe
            ];
            
        } catch(PDOException $e) {
            // Rollback em caso de erro
            $this->db->rollBack();
            error_log("entrarEquipe - ERRO: " . $e->getMessage() . " - Trace: " . $e->getTraceAsString());
            
            return [
                'success' => false,
                'message' => 'Erro ao entrar na equipe: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Lista todas as equipes que o usuário participa
     * @param int $alunoId ID do aluno
     * @return array Lista de equipes
     */
    public function listarEquipesUsuario($alunoId) {
        try {
            error_log("listarEquipesUsuario - Iniciando busca para o aluno ID: $alunoId");
            
            // Primeiro verifica se o aluno existe
            $queryAluno = "SELECT * FROM alunos WHERE id = :aluno_id";
            $stmtAluno = $this->db->prepare($queryAluno);
            $stmtAluno->bindParam(':aluno_id', $alunoId);
            $stmtAluno->execute();
            
            if ($stmtAluno->rowCount() === 0) {
                error_log("listarEquipesUsuario - Aluno não encontrado: $alunoId");
                return [
                    'success' => false,
                    'message' => 'Aluno não encontrado'
                ];
            }
            
            error_log("listarEquipesUsuario - Aluno encontrado, buscando equipes");
            
            $query = "SELECT e.*, 
                     (SELECT COUNT(*) FROM equipe_membros WHERE equipe_id = e.id) as total_membros,
                     (e.lider_id = :aluno_id_lider) as is_lider
                     FROM equipes e
                     JOIN equipe_membros m ON e.id = m.equipe_id
                     WHERE m.aluno_id = :aluno_id_membro
                     ORDER BY e.data_criacao DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':aluno_id_lider', $alunoId);
            $stmt->bindParam(':aluno_id_membro', $alunoId);
            $stmt->execute();
            
            $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("listarEquipesUsuario - Total de equipes encontradas: " . count($equipes));
            
            if (count($equipes) > 0) {
                error_log("listarEquipesUsuario - Equipes encontradas: " . json_encode(array_column($equipes, 'id')));
                return [
                    'success' => true,
                    'equipes' => $equipes
                ];
            } else {
                error_log("listarEquipesUsuario - Nenhuma equipe encontrada");
                
                // Verificar se o aluno está na tabela equipe_membros
                $queryMembros = "SELECT equipe_id FROM equipe_membros WHERE aluno_id = :aluno_id";
                $stmtMembros = $this->db->prepare($queryMembros);
                $stmtMembros->bindParam(':aluno_id', $alunoId);
                $stmtMembros->execute();
                $membroResultado = $stmtMembros->fetchAll(PDO::FETCH_ASSOC);
                
                error_log("listarEquipesUsuario - Verificação adicional: aluno está em " . count($membroResultado) . " equipes na tabela equipe_membros");
                
                if (count($membroResultado) > 0) {
                    error_log("listarEquipesUsuario - IDs das equipes na equipe_membros: " . json_encode(array_column($membroResultado, 'equipe_id')));
                    
                    // Se há registros em equipe_membros mas não retornou equipes, verificar a tabela equipes
                    $equipesIds = array_column($membroResultado, 'equipe_id');
                    
                    // Verificar se há IDs antes de construir a consulta
                    if (!empty($equipesIds)) {
                        $placeholders = implode(',', array_fill(0, count($equipesIds), '?'));
                        
                        $queryEquipesVerificar = "SELECT id, nome FROM equipes WHERE id IN ($placeholders)";
                        $stmtEquipesVerificar = $this->db->prepare($queryEquipesVerificar);
                        
                        foreach ($equipesIds as $index => $id) {
                            $stmtEquipesVerificar->bindValue($index + 1, $id);
                        }
                        
                        $stmtEquipesVerificar->execute();
                        $equipesVerificar = $stmtEquipesVerificar->fetchAll(PDO::FETCH_ASSOC);
                        
                        error_log("listarEquipesUsuario - Equipes encontradas na tabela equipes: " . count($equipesVerificar));
                        error_log("listarEquipesUsuario - Detalhes das equipes encontradas: " . json_encode($equipesVerificar));
                    } else {
                        error_log("listarEquipesUsuario - Nenhum ID de equipe encontrado para verificação");
                    }
                }
                
                // Retornar array vazio de equipes com sucesso true
                return [
                    'success' => true,
                    'equipes' => []
                ];
            }
            
        } catch(PDOException $e) {
            error_log("listarEquipesUsuario - Erro: " . $e->getMessage() . " - Trace: " . $e->getTraceAsString());
            return [
                'success' => false,
                'message' => 'Erro ao listar equipes: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Sair de uma equipe
     * @param int $alunoId ID do aluno
     * @param int $equipeId ID da equipe
     * @return array Resultado da operação
     */
    public function sairEquipe($alunoId, $equipeId) {
        try {
            // Iniciar transação
            $this->db->beginTransaction();
            
            // Verificar se a equipe existe
            $queryEquipe = "SELECT * FROM equipes WHERE id = :equipe_id";
            $stmtEquipe = $this->db->prepare($queryEquipe);
            $stmtEquipe->bindParam(':equipe_id', $equipeId);
            $stmtEquipe->execute();
            
            $equipe = $stmtEquipe->fetch(PDO::FETCH_ASSOC);
            
            if (!$equipe) {
                return [
                    'success' => false,
                    'message' => 'Equipe não encontrada'
                ];
            }
            
            // Verificar se o usuário é o líder da equipe
            if ($equipe['lider_id'] == $alunoId) {
                return [
                    'success' => false,
                    'message' => 'Você é o líder da equipe e não pode sair. Você pode excluir a equipe.'
                ];
            }
            
            // Remover membro da equipe
            $queryRemoverMembro = "DELETE FROM equipe_membros 
                                 WHERE equipe_id = :equipe_id AND aluno_id = :aluno_id";
            $stmtRemoverMembro = $this->db->prepare($queryRemoverMembro);
            $stmtRemoverMembro->bindParam(':equipe_id', $equipeId);
            $stmtRemoverMembro->bindParam(':aluno_id', $alunoId);
            $stmtRemoverMembro->execute();
            
            // Remover inscrição relacionada à equipe
            $queryRemoverInscricao = "DELETE FROM inscricoes 
                                    WHERE aluno_id = :aluno_id AND equipe_id = :equipe_id";
            $stmtRemoverInscricao = $this->db->prepare($queryRemoverInscricao);
            $stmtRemoverInscricao->bindParam(':aluno_id', $alunoId);
            $stmtRemoverInscricao->bindParam(':equipe_id', $equipeId);
            $stmtRemoverInscricao->execute();
            
            // Commit da transação
            $this->db->commit();
            
            return [
                'success' => true,
                'message' => 'Você saiu da equipe com sucesso'
            ];
            
        } catch(PDOException $e) {
            // Rollback em caso de erro
            $this->db->rollBack();
            
            return [
                'success' => false,
                'message' => 'Erro ao sair da equipe: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Gera um código único alfanumérico de 6 caracteres
     * @return string Código único
     */
    private function gerarCodigoUnico() {
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $codigo = '';
        $max = strlen($caracteres) - 1;
        
        // Gerar código de 6 caracteres
        for ($i = 0; $i < 6; $i++) {
            $codigo .= $caracteres[random_int(0, $max)];
        }
        
        // Verificar se o código já existe
        $query = "SELECT COUNT(*) as total FROM equipes WHERE codigo_acesso = :codigo";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':codigo', $codigo);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Se já existe, gerar outro
        if ($result['total'] > 0) {
            return $this->gerarCodigoUnico();
        }
        
        return $codigo;
    }
    
    /**
     * Retorna o limite de participantes para uma modalidade específica
     * @param string $modalidade Nome da modalidade
     * @return int Limite de participantes ou false em caso de erro
     */
    private function getLimiteParticipantes($modalidade) {
        switch ($modalidade) {
            case 'futsal':
                return 9;
            case 'volei':
                return 12;
            case 'basquete':
                return 12;
            case 'handebol':
                return 14;
            case 'queimada':
                return 12;
            case 'futmesa':
                return 2;
            case 'teqball':
                return 2;
            case 'teqvolei':
                return 2;
            case 'beach_tenis':
                return 2;
            case 'volei_de_praia':
                return 2;
            case 'tenis_de_mesa':
                return 1;
            case 'dama':
                return 1;
            case 'xadrez':
                return 1;
            case 'x2':
                return 3;
            default:
                return 12;
        }
    }
    
    /**
     * Calcula o valor total da inscrição de uma equipe
     * @param int $equipeId ID da equipe
     * @return array Resultado com o valor total e detalhes
     */
    public function calcularValorInscricao($equipeId, $alunoId = null) {
        try {
            // Primeiro verifica se a equipe existe
            $queryEquipe = "SELECT e.*, 
                          (SELECT COUNT(*) FROM equipe_membros WHERE equipe_id = e.id) as total_membros 
                          FROM equipes e 
                          WHERE e.id = :equipe_id";
            $stmtEquipe = $this->db->prepare($queryEquipe);
            $stmtEquipe->bindParam(':equipe_id', $equipeId);
            $stmtEquipe->execute();
            
            if ($stmtEquipe->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Equipe não encontrada'
                ];
            }

            $equipe = $stmtEquipe->fetch(PDO::FETCH_ASSOC);
            
            // Se um alunoId foi fornecido, verificar se é o líder
            if ($alunoId !== null) {
                if ($equipe['lider_id'] != $alunoId) {
                    return [
                        'success' => false,
                        'message' => 'Apenas o líder da equipe pode realizar o pagamento'
                    ];
                }
            }
            
            // Define o número mínimo de membros por modalidade
            $minimosModalidade = [
                'futsal' => 5,
                'volei' => 6,
                'queimada' => 8,
                'futmesa' => 2,
                'teqball' => 2,
                'teqvolei' => 2,
                'beach_tenis' => 2,
                'volei_de_praia' => 2,
                'tenis_de_mesa' => 1,
                'dama' => 1,
                'xadrez' => 1,
                'jiu-jitsu' => 1,
                'x2' => 3
            ];

            // Busca os membros e suas modalidades
            $queryMembros = "SELECT 
                    a.id as aluno_id,
                    a.nome,
                    COUNT(DISTINCT i.modalidade) as total_modalidades
                FROM equipe_membros m
                JOIN alunos a ON m.aluno_id = a.id
                LEFT JOIN inscricoes i ON a.id = i.aluno_id
                WHERE m.equipe_id = :equipe_id
                GROUP BY a.id, a.nome";
            
            $stmtMembros = $this->db->prepare($queryMembros);
            $stmtMembros->bindParam(':equipe_id', $equipeId);
            $stmtMembros->execute();
            
            $membros = $stmtMembros->fetchAll(PDO::FETCH_ASSOC);
            $valorTotal = 0;
            $detalhes = [];
            
            foreach ($membros as $membro) {
                $valorPorModalidade = ($membro['total_modalidades'] >= 3) ? 3.00 : 5.00;
                $valorMembro = $valorPorModalidade;
                
                $valorTotal += $valorMembro;
                
                $detalhes[] = [
                    'aluno_id' => $membro['aluno_id'],
                    'nome' => $membro['nome'],
                    'total_modalidades' => $membro['total_modalidades'],
                    'valor_modalidade' => $valorPorModalidade,
                    'valor_total' => $valorMembro
                ];
            }

            // Verifica se atingiu o número mínimo de membros
            $minimoNecessario = $minimosModalidade[$equipe['modalidade']] ?? 1;
            
            // Para modalidade x2, só libera pagamento com exatamente 3 pessoas
            if ($equipe['modalidade'] === 'x2') {
                $atingiuMinimo = $equipe['total_membros'] === 3;
            } else {
                $atingiuMinimo = $equipe['total_membros'] >= $minimoNecessario;
            }

            // Gera o PIX se atingiu o mínimo
            $pixInfo = null;
            if ($atingiuMinimo) {
                $pixInfo = [
                    'chave' => PIX_CHAVE,
                    'beneficiario' => PIX_NOME,
                    'cidade' => PIX_CIDADE,
                    'valor' => number_format($valorTotal, 2, '.', ''),
                    'identificador' => 'GREMIO' . $equipeId . date('YmdHis'),
                    'descricao' => 'Inscrição Copa Grêmio 2025 - Equipe ' . $equipe['nome']
                ];
            }
            
            return [
                'success' => true,
                'equipe' => $equipe,
                'valor_total' => $valorTotal,
                'total_membros' => count($membros),
                'detalhes' => $detalhes,
                'minimo_necessario' => $minimoNecessario,
                'atingiu_minimo' => $atingiuMinimo,
                'pix_info' => $pixInfo
            ];
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao calcular valor: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Lista os membros de uma equipe
     * @param int $equipeId ID da equipe
     * @return array Lista de membros
     */
    public function listarMembrosEquipe($equipeId) {
        try {
            // Primeiro verifica se a equipe existe
            $queryEquipe = "SELECT * FROM equipes WHERE id = :equipe_id";
            $stmtEquipe = $this->db->prepare($queryEquipe);
            $stmtEquipe->bindParam(':equipe_id', $equipeId);
            $stmtEquipe->execute();
            
            if ($stmtEquipe->rowCount() === 0) {
                return [
                    'success' => false,
                    'message' => 'Equipe não encontrada'
                ];
            }
            
            // Busca os membros da equipe
            $query = "SELECT 
                        m.id as membro_id,
                        m.data_entrada,
                        a.id as aluno_id,
                        a.nome,
                        a.email,
                        a.ano,
                        a.turma,
                        (SELECT COUNT(*) FROM inscricoes WHERE aluno_id = a.id) as total_modalidades,
                        CASE WHEN e.lider_id = a.id THEN 1 ELSE 0 END as is_lider
                    FROM equipe_membros m
                    JOIN alunos a ON m.aluno_id = a.id
                    JOIN equipes e ON m.equipe_id = e.id
                    WHERE m.equipe_id = :equipe_id
                    ORDER BY is_lider DESC, a.nome ASC";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':equipe_id', $equipeId);
            $stmt->execute();
            
            $membros = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Busca informações da equipe
            $equipe = $stmtEquipe->fetch(PDO::FETCH_ASSOC);
            
            return [
                'success' => true,
                'equipe' => $equipe,
                'membros' => $membros,
                'total_membros' => count($membros)
            ];
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao listar membros: ' . $e->getMessage()
            ];
        }
    }
    
    /**
     * Lista todas as equipes com seus membros e status para o admin
     * @return array Lista de equipes com detalhes
     */
    public function listarTodasEquipes() {
        try {
            // Buscar todas as equipes com contagem de membros e status geral
            $query = "SELECT 
                        e.*,
                        (SELECT COUNT(*) FROM equipe_membros WHERE equipe_id = e.id) as total_membros,
                        (SELECT COUNT(*) FROM inscricoes WHERE equipe_id = e.id AND status = 'aprovado') as membros_aprovados,
                        (SELECT COUNT(*) FROM inscricoes WHERE equipe_id = e.id AND status = 'pendente') as membros_pendentes,
                        (SELECT COUNT(*) FROM inscricoes WHERE equipe_id = e.id AND status = 'reprovado') as membros_reprovados,
                        a.nome as lider_nome,
                        CASE 
                            WHEN MIN(i.status) = 'reprovado' THEN 'reprovado'
                            WHEN MIN(i.status) = 'pendente' THEN 'pendente'
                            ELSE 'aprovado'
                        END as status_equipe
                    FROM equipes e
                    LEFT JOIN alunos a ON e.lider_id = a.id
                    LEFT JOIN inscricoes i ON e.id = i.equipe_id
                    GROUP BY e.id
                    ORDER BY e.data_criacao DESC";
            
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $equipes = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Para cada equipe, buscar seus membros
            foreach ($equipes as &$equipe) {
                $queryMembros = "SELECT 
                                    a.id, 
                                    a.nome, 
                                    a.email, 
                                    a.telefone,
                                    a.ano,
                                    a.turma,
                                    i.status,
                                    i.id as inscricao_id,
                                    (a.id = :lider_id) as is_lider
                                FROM equipe_membros em
                                JOIN alunos a ON em.aluno_id = a.id
                                LEFT JOIN inscricoes i ON i.aluno_id = a.id AND i.equipe_id = em.equipe_id
                                WHERE em.equipe_id = :equipe_id
                                ORDER BY is_lider DESC, a.nome ASC";
                
                $stmtMembros = $this->db->prepare($queryMembros);
                $stmtMembros->bindParam(':equipe_id', $equipe['id']);
                $stmtMembros->bindParam(':lider_id', $equipe['lider_id']);
                $stmtMembros->execute();
                
                $equipe['membros'] = $stmtMembros->fetchAll(PDO::FETCH_ASSOC);
            }
            
            return [
                'success' => true,
                'equipes' => $equipes
            ];
            
        } catch(PDOException $e) {
            return [
                'success' => false,
                'message' => 'Erro ao listar equipes: ' . $e->getMessage()
            ];
        }
    }
}
?> 