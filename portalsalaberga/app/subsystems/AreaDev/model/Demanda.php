<?php
class Demanda {
    private $pdo;
    private $pdo_salaberga;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo_salaberga = Database::getInstance()->getSalabergaConnection();
        
        // Verificar conexões
        error_log("\n=== VERIFICANDO CONEXÕES COM BANCO DE DADOS ===");
        try {
            $test_areadev = $this->pdo->query("SELECT 1")->fetch();
            error_log("Conexão com banco areadev: OK");
        } catch (PDOException $e) {
            error_log("ERRO na conexão com banco areadev: " . $e->getMessage());
        }
        
        try {
            $test_salaberga = $this->pdo_salaberga->query("SELECT 1")->fetch();
            error_log("Conexão com banco salaberga: OK");
        } catch (PDOException $e) {
            error_log("ERRO na conexão com banco salaberga: " . $e->getMessage());
        }
    }

    public function listarDemandas($admin_id = null) {
        // Se um admin_id for fornecido, filtrar apenas as demandas das áreas que ele tem permissão
        if ($admin_id !== null) {
            $id_sistema = 3; // Ajuste para o ID do sistema de demandas
            $stmt = $this->pdo_salaberga->prepare("
                SELECT p.descricao 
                FROM usu_sist us
                INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
                INNER JOIN permissoes p ON sp.permissao_id = p.id
                WHERE us.usuario_id = ? AND sp.sistema_id = ?
            ");
            $stmt->execute([$admin_id, $id_sistema]);
            $permissoes = $stmt->fetchAll(PDO::FETCH_COLUMN);

            // Se for admin geral, mostrar todas as demandas
            foreach ($permissoes as $permissao) {
                if (strpos($permissao, 'adm_geral') === 0) {
                    $stmt = $this->pdo->prepare("
                        SELECT d.*, u.nome as admin_nome
                        FROM demandas d 
                        LEFT JOIN salaberga.usuarios u ON d.admin_id = u.id 
                        ORDER BY d.data_criacao DESC
                    ");
                    $stmt->execute();
                    $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // Buscar usuários atribuídos (mantém igual)
                    foreach ($demandas as &$demanda) {
                        $stmtUsuarios = $this->pdo->prepare("
                            SELECT u.id, u.nome, du.status, du.data_conclusao 
                            FROM salaberga.usuarios u
                            INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                            WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                            UNION
                            SELECT u.id, u.nome, d.status as status, d.data_conclusao
                            FROM salaberga.usuarios u
                            INNER JOIN demandas d ON u.id = d.admin_id
                            WHERE d.id = ? AND u.id = d.admin_id AND d.status IN ('em_andamento', 'concluida')
                        ");
                        $stmtUsuarios->execute([$demanda['id'], $demanda['id']]);
                        $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
                    }
                    return $demandas;
                }
            }

            // Mapear permissões para area_ids
            $area_ids = [];
            foreach ($permissoes as $permissao) {
                $permissao = preg_replace('/\(\d+\)$/', '', $permissao); // remove (3) do final
                if (preg_match('/adm_area_([a-z]+)/', $permissao, $matches)) {
                    $area_slug = strtolower($matches[1]);
                    // Buscar o id da área pelo nome
                    $stmtArea = $this->pdo->prepare("SELECT id FROM areas WHERE LOWER(nome) LIKE ?");
                    $stmtArea->execute(["%$area_slug%"]);
                    $area = $stmtArea->fetch(PDO::FETCH_ASSOC);
                    if ($area) {
                        $area_ids[] = $area['id'];
                    }
                }
            }

            if (empty($area_ids)) {
                return []; // Admin não tem permissão em nenhuma área
            }

            $placeholders = str_repeat('?,', count($area_ids) - 1) . '?';
            $sql = "
                SELECT d.*, u.nome as admin_nome
                FROM demandas d 
                LEFT JOIN salaberga.usuarios u ON d.admin_id = u.id 
                WHERE d.area_id IN ($placeholders)
                ORDER BY d.data_criacao DESC
            ";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($area_ids);
        } else {
            // Se nenhum admin_id for fornecido, listar todas as demandas (comportamento anterior)
            $stmt = $this->pdo->prepare("
                SELECT d.*, u.nome as admin_nome
                FROM demandas d 
                LEFT JOIN salaberga.usuarios u ON d.admin_id = u.id 
                ORDER BY d.data_criacao DESC
            ");
            $stmt->execute();
        }

        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para cada demanda, buscar os usuários atribuídos
        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM salaberga.usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                UNION
                SELECT u.id, u.nome, d.status as status, d.data_conclusao
                FROM salaberga.usuarios u
                INNER JOIN demandas d ON u.id = d.admin_id
                WHERE d.id = ? AND u.id = d.admin_id AND d.status IN ('em_andamento', 'concluida')
            ");
            $stmtUsuarios->execute([$demanda['id'], $demanda['id']]);
            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
        }

        return $demandas;
    }

    public function listarDemandasPorUsuario($usuario_id) {
        error_log("\n\n=== INÍCIO DO DEBUG DE LISTAR DEMANDAS POR USUÁRIO ===");
        error_log("Usuário ID: " . $usuario_id);

        // Verificar se o usuário tem permissão para ver demandas e qual sua área
        $sql_perm = "
            SELECT DISTINCT p.descricao 
            FROM salaberga.usu_sist us
            INNER JOIN salaberga.sist_perm sp ON us.sist_perm_id = sp.id
            INNER JOIN salaberga.permissoes p ON sp.permissao_id = p.id
            WHERE us.usuario_id = ? AND sp.sistema_id = 3
        ";
        $stmt_perm = $this->pdo_salaberga->prepare($sql_perm);
        $stmt_perm->execute([$usuario_id]);
        $permissoes = $stmt_perm->fetchAll(PDO::FETCH_COLUMN);
        error_log("\nPermissões do usuário: " . print_r($permissoes, true));

        // Verificar se é admin geral
        $is_admin_geral = false;
        foreach ($permissoes as $permissao) {
            if (strpos($permissao, 'adm_geral') === 0) {
                $is_admin_geral = true;
                break;
            }
        }

        // Se for admin geral, mostrar todas as demandas
        if ($is_admin_geral) {
            $sql = "
                SELECT DISTINCT 
                    d.*,
                    u.nome as admin_nome,
                    d.status as status_usuario,
                    d.data_conclusao as data_conclusao_usuario
                FROM demandas d
                LEFT JOIN salaberga.usuarios u ON d.admin_id = u.id
                ORDER BY d.data_criacao DESC";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
        } else {
            // Mapear permissões para area_ids
            $area_ids = [];
            foreach ($permissoes as $permissao) {
                $permissao = preg_replace('/\(\d+\)$/', '', $permissao); // remove (3) do final
                if (preg_match('/adm_area_([a-z]+)|usuario_area_([a-z]+)/', $permissao, $matches)) {
                    $area_slug = strtolower($matches[1] ?? $matches[2]);
                    // Buscar o id da área pelo nome
                    $stmtArea = $this->pdo->prepare("SELECT id FROM areas WHERE LOWER(nome) LIKE ?");
                    $stmtArea->execute(["%$area_slug%"]);
                    $area = $stmtArea->fetch(PDO::FETCH_ASSOC);
                    if ($area) {
                        $area_ids[] = $area['id'];
                    }
                }
            }

            if (empty($area_ids)) {
                error_log("Usuário não tem permissão em nenhuma área");
                return [];
            }

            // Buscar demandas onde o usuário está atribuído OU é o admin OU a demanda é da área do usuário
            $placeholders = str_repeat('?,', count($area_ids) - 1) . '?';
            $sql = "
                SELECT DISTINCT 
                    d.*,
                    u.nome as admin_nome,
                    du.status as status_usuario_individual,
                    d.status as status_geral,
                    d.data_conclusao as data_conclusao_geral,
                    du.data_conclusao as data_conclusao_individual
                FROM demandas d
                LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id AND du.usuario_id = ?
                LEFT JOIN salaberga.usuarios u ON d.admin_id = u.id
                WHERE (
                    d.admin_id = ?
                    OR du.usuario_id = ?
                    OR d.area_id IN ($placeholders)
                )
                ORDER BY d.data_criacao DESC";
            
            $params = array_merge([$usuario_id, $usuario_id, $usuario_id], $area_ids);
            $stmt = $this->pdo->prepare($sql);
            
            error_log("DEBUG MODEL - SQL listarDemandasPorUsuario: " . $sql);
            error_log("DEBUG MODEL - Params listarDemandasPorUsuario: " . print_r($params, true));

            $stmt->execute($params);
        }

        try {
            $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

            error_log("\n=== DEMANDAS ENCONTRADAS ===");
            error_log("Número de demandas: " . count($demandas));
            error_log(print_r($demandas, true));

            error_log("DEBUG MODEL - Demandas brutas antes de buscar usuários atribuídos:");
            error_log(print_r($demandas, true));

            foreach ($demandas as &$demanda) {
                error_log("\n=== PROCESSANDO DEMANDA ID: " . $demanda['id'] . " PARA USUÁRIO ID: " . $usuario_id . " ===");

                $stmtUsuarios = $this->pdo->prepare("
                    SELECT 
                        u.id,
                        u.nome,
                        du.status,
                        du.data_conclusao
                    FROM salaberga.usuarios u
                    INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                    WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                    UNION
                    SELECT 
                        u.id,
                        u.nome,
                        d.status as status,
                        d.data_conclusao
                    FROM salaberga.usuarios u
                    INNER JOIN demandas d ON u.id = d.admin_id
                    WHERE d.id = ? AND u.id = d.admin_id AND d.status IN ('em_andamento', 'concluida')
                ");
                $stmtUsuarios->execute([$demanda['id'], $demanda['id']]);
                $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
            }

            return $demandas;
        } catch (PDOException $e) {
            error_log("ERRO ao buscar demandas: " . $e->getMessage());
            throw $e;
        }
    }

    public function buscarDemanda($id) {
<<<<<<< HEAD
        $sql = "SELECT d.*, GROUP_CONCAT(du.usuario_id) as usuarios_atribuidos 
                FROM demandas d 
                LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id 
                WHERE d.id = :id 
                GROUP BY d.id";
=======
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome, u2.nome as usuario_nome 
            FROM demandas d 
            LEFT JOIN usuarios u ON d.admin_id = u.id 
            LEFT JOIN usuarios u2 ON d.usuario_id = u2.id 
            WHERE d.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuario_id = null) {
        $stmt = $this->pdo->prepare("
            INSERT INTO demandas (titulo, descricao, prioridade, admin_id, usuario_id)
            VALUES (?, ?, ?, ?, ?)
        ");
        // Converter string vazia para NULL para consistência
        $usuario_id_salvar = ($usuario_id === '' || $usuario_id === 0) ? null : $usuario_id;
>>>>>>> parent of 3f481e1 (finalizando sistema de demandas)
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $demanda = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($demanda) {
            $demanda['usuarios_atribuidos'] = $demanda['usuarios_atribuidos'] ? 
                explode(',', $demanda['usuarios_atribuidos']) : [];
        }
        
        return $demanda;
    }

    public function listarDemandasPorArea($area_id) {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome
            FROM demandas d 
            LEFT JOIN salaberga.usuarios u ON d.admin_id = u.id 
            WHERE d.area_id = ?
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute([$area_id]);
        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM salaberga.usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                UNION
                SELECT u.id, u.nome, d.status as status, d.data_conclusao
                FROM salaberga.usuarios u
                INNER JOIN demandas d ON u.id = d.admin_id
                WHERE d.id = ? AND u.id = d.admin_id AND d.status IN ('em_andamento', 'concluida')
            ");
            $stmtUsuarios->execute([$demanda['id'], $demanda['id']]);
            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
        }
        return $demandas;
    }
    public function verificarPermissaoAdminArea($admin_id, $area_id) {
        // Mapear área_id para a permissão correspondente
        $permissoes = [
            1 => 'adm_area_dev',
            2 => 'adm_area_suporte',
            3 => 'adm_area_design'
        ];
        if (!isset($permissoes[$area_id])) {
            error_log("Área ID inválido: " . $area_id);
            return false;
        }
        $permissao = $permissoes[$area_id];
        $id_sistema = 3; // ID do sistema de demandas

        // Debug
        error_log("Verificando permissão para admin_id: " . $admin_id . ", área: " . $area_id . ", permissão: " . $permissao);

        // Verificar se é admin geral
        $stmt = $this->pdo_salaberga->prepare("
            SELECT COUNT(*) 
            FROM usu_sist us
            INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
            INNER JOIN permissoes p ON sp.permissao_id = p.id
            WHERE us.usuario_id = ? AND p.descricao = 'adm_geral(3)' AND sp.sistema_id = ?
        ");
        $stmt->execute([$admin_id, $id_sistema]);
        $is_admin_geral = $stmt->fetchColumn() > 0;
        error_log("É admin geral? " . ($is_admin_geral ? 'Sim' : 'Não'));

        if ($is_admin_geral) {
            return true;
        }

        // Verificar permissão específica da área
        $stmt = $this->pdo_salaberga->prepare("
            SELECT COUNT(*) 
            FROM usu_sist us
            INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
            INNER JOIN permissoes p ON sp.permissao_id = p.id
            WHERE us.usuario_id = ? AND p.descricao = ? AND sp.sistema_id = ?
        ");
        $stmt->execute([$admin_id, $permissao, $id_sistema]);
        $tem_permissao = $stmt->fetchColumn() > 0;
        error_log("Tem permissão específica? " . ($tem_permissao ? 'Sim' : 'Não'));

        return $tem_permissao;
    }

    public function criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuarios_ids = [], $prazo = null, $area_id = null, $usuarioModel = null) {
        try {
            // Validar dados obrigatórios
            if (empty($titulo) || empty($descricao) || empty($prioridade) || empty($admin_id) || empty($area_id)) {
                throw new Exception('Todos os campos obrigatórios devem ser preenchidos');
            }

            // Validar admin
            $stmt = $this->pdo_salaberga->prepare("SELECT id FROM usuarios WHERE id = ?");
            $stmt->execute([$admin_id]);
            if (!$stmt->fetch()) {
                throw new Exception('Administrador não encontrado');
            }

            // Validar prioridade
            if (!in_array($prioridade, ['baixa', 'media', 'alta'])) {
                error_log('ERRO: Prioridade inválida: ' . $prioridade);
                throw new Exception('Prioridade inválida');
            }

            $dias_para_adicionar = 0;
            switch ($prioridade) {
                case 'baixa': $dias_para_adicionar = 5; break;
                case 'media': $dias_para_adicionar = 3; break;
                case 'alta': $dias_para_adicionar = 1; break;
            }
            $prazo_calculado = ($prazo !== null) ? $prazo : date('Y-m-d', strtotime("+" . $dias_para_adicionar . " days"));

            // Inserir a demanda
            $sql = "INSERT INTO demandas (titulo, descricao, prioridade, admin_id, status, prazo, area_id) VALUES (?, ?, ?, ?, 'pendente', ?, ?)";
            
            error_log('DEBUG SQL (criarDemanda): ' . $sql);
            error_log('DEBUG PARAMS (criarDemanda): ' . print_r([$titulo, $descricao, $prioridade, $admin_id, $prazo_calculado, $area_id], true));

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titulo, $descricao, $prioridade, $admin_id, $prazo_calculado, $area_id]);

            $demanda_id = $this->pdo->lastInsertId();
            error_log('DEBUG DEMANDA ID (criarDemanda): ' . $demanda_id);

            // Atribuir usuários individualmente se a lista de IDs for fornecida
            if (!empty($usuarios_ids)) {
                $stmtAtribuir = $this->pdo->prepare("
                    INSERT INTO demanda_usuarios (demanda_id, usuario_id, status)
                    VALUES (?, ?, 'pendente')
                ");
                foreach ($usuarios_ids as $usuario_id) {
                    // Verificar se o usuário existe antes de atribuir
                    $stmt = $this->pdo_salaberga->prepare("SELECT id FROM usuarios WHERE id = ?");
                    $stmt->execute([$usuario_id]);
                    if (!$stmt->fetch()) {
                        error_log('ERRO: Usuário não encontrado para atribuição: ' . $usuario_id);
                        // Decida se quer lançar uma exceção ou apenas logar o erro e continuar
                        // throw new Exception('Usuário não encontrado para atribuição: ' . $usuario_id); // Opção mais rigorosa
                        continue; // Opção menos rigorosa: apenas pula o usuário inválido
                    }
                    
                    error_log('DEBUG: Atribuindo usuário individualmente ' . $usuario_id . ' à demanda ' . $demanda_id);
                    $stmtAtribuir->execute([$demanda_id, $usuario_id]);
                }
            }

            return $demanda_id; // Retorna o ID da nova demanda

        } catch (Exception $e) {
            error_log('ERRO AO CRIAR DEMANDA: ' . $e->getMessage());
            error_log('ERRO COMPLETO: ' . $e->getTraceAsString());
            throw $e; // Propagar o erro para ser tratado no controller
        }
    }

    public function atualizarDemanda($id, $titulo, $descricao, $prioridade, $status, $usuarios_ids = [], $prazo = null) {
        try {
            $this->pdo->beginTransaction();

            // Primeiro, buscar o status atual da demanda
            $stmtStatus = $this->pdo->prepare("SELECT status FROM demandas WHERE id = ?");
            $stmtStatus->execute([$id]);
            $statusAtual = $stmtStatus->fetchColumn();

            // Calcular o novo prazo baseado na prioridade atualizada
            $dias_para_adicionar = 0;
            switch ($prioridade) {
                case 'baixa':
                    $dias_para_adicionar = 5;
                    break;
                case 'media':
                    $dias_para_adicionar = 3;
                    break;
                case 'alta':
                    $dias_para_adicionar = 1;
                    break;
            }
            $novo_prazo = date('Y-m-d', strtotime("+" . $dias_para_adicionar . " days"));

            // Atualizar apenas os campos básicos da demanda
            $stmt = $this->pdo->prepare("
                UPDATE demandas 
                SET titulo = ?, 
                    descricao = ?, 
                    prioridade = ?, 
                    prazo = ?
                WHERE id = ?
            ");
            $stmt->execute([$titulo, $descricao, $prioridade, $novo_prazo, $id]);

            $this->pdo->commit();
            return true;

        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function excluirDemanda($id) {
        // A exclusão na tabela demanda_usuarios será em cascata devido à FOREIGN KEY
        $stmt = $this->pdo->prepare("DELETE FROM demandas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function marcarEmAndamento($demandaId, $usuarioId) {
        error_log("\n=== INÍCIO marcarEmAndamento ===");
        error_log("Demanda ID: $demandaId, Usuário ID: $usuarioId");
        
        $this->pdo->beginTransaction();
        try {
            // 1. Verificar se a demanda existe e obter seu status atual
            $sql = "SELECT d.*, du.status as status_usuario 
                    FROM demandas d 
                    LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id AND du.usuario_id = ?
                    WHERE d.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$usuarioId, $demandaId]);
            $demanda = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$demanda) {
                error_log("Demanda não encontrada");
                $this->pdo->rollBack();
                return false;
            }
            error_log("Demanda encontrada. Status atual: " . $demanda['status'] . ", Status usuário: " . ($demanda['status_usuario'] ?? 'não atribuído'));
            
            // 2. Verificar se o usuário está atribuído à demanda ou é o admin
            $sqlCheckAssignment = "
                SELECT COUNT(*) 
                FROM demanda_usuarios du
                INNER JOIN demandas d ON du.demanda_id = d.id
                WHERE du.demanda_id = ? AND (du.usuario_id = ? OR d.admin_id = ?)
            ";
            $stmtCheckAssignment = $this->pdo->prepare($sqlCheckAssignment);
            $stmtCheckAssignment->execute([$demandaId, $usuarioId, $usuarioId]);
            $isAssignedOrAdmin = $stmtCheckAssignment->fetchColumn();
            
            if (!$isAssignedOrAdmin) {
                error_log("Usuário não está atribuído à demanda e não é admin");
                $this->pdo->rollBack();
                return false;
            }
            error_log("Usuário verificado: atribuído ou admin");
            
            // 3. Atualizar status do usuário na demanda
            $sqlUpdateUserStatus = "
                UPDATE demanda_usuarios 
                SET status = 'em_andamento', 
                    data_atualizacao = NOW() 
                WHERE demanda_id = ? AND usuario_id = ?
            ";
            $stmtUpdateUserStatus = $this->pdo->prepare($sqlUpdateUserStatus);
            $successUpdateUser = $stmtUpdateUserStatus->execute([$demandaId, $usuarioId]);
            
            if (!$successUpdateUser) {
                error_log("Erro ao atualizar status do usuário");
                $this->pdo->rollBack();
                return false;
            }
            error_log("Status do usuário atualizado para 'em_andamento'");
            
            // 4. Verificar se todos os usuários estão em andamento
            $sqlCheckAllInProgress = "
                SELECT COUNT(*) as total,
                       SUM(CASE WHEN status = 'em_andamento' THEN 1 ELSE 0 END) as em_andamento
                FROM demanda_usuarios 
                WHERE demanda_id = ?
            ";
            $stmtCheckAllInProgress = $this->pdo->prepare($sqlCheckAllInProgress);
            $stmtCheckAllInProgress->execute([$demandaId]);
            $status = $stmtCheckAllInProgress->fetch(PDO::FETCH_ASSOC);
            
            error_log("Total de usuários: " . $status['total'] . ", Em andamento: " . $status['em_andamento']);
            
            // 5. Se todos os usuários estiverem em andamento, atualizar status da demanda
            if ($status['total'] > 0 && $status['total'] == $status['em_andamento']) {
                $sqlUpdateDemandaStatus = "
                    UPDATE demandas 
                    SET status = 'em_andamento', 
                        data_atualizacao = NOW() 
                    WHERE id = ?
                ";
                $stmtUpdateDemandaStatus = $this->pdo->prepare($sqlUpdateDemandaStatus);
                $successUpdateDemanda = $stmtUpdateDemandaStatus->execute([$demandaId]);
                
                if (!$successUpdateDemanda) {
                    error_log("Erro ao atualizar status da demanda");
                    $this->pdo->rollBack();
                    return false;
                }
                error_log("Status da demanda atualizado para 'em_andamento'");
            }
            
            $this->pdo->commit();
            error_log("Transação commitada com sucesso");
            return true;
            
        } catch (Exception $e) {
            error_log("Erro em marcarEmAndamento: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            $this->pdo->rollBack();
            return false;
        }
    }

    public function marcarConcluida($demandaId, $usuarioId) {
        error_log("DEMANDA_MODEL_LOG: Iniciando marcarConcluida para demanda ID $demandaId e usuário ID $usuarioId");
        $this->pdo->beginTransaction();
        try {
            // 1. Verificar se a demanda existe e obter seu status atual
            $sql = "SELECT d.*, du.status as status_usuario 
                    FROM demandas d 
                    LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id AND du.usuario_id = ?
                    WHERE d.id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$usuarioId, $demandaId]);
            $demanda = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$demanda) {
                error_log("DEMANDA_MODEL_LOG: Erro - Demanda ID $demandaId não encontrada.");
                $this->pdo->rollBack();
                return false;
            }
            error_log("DEMANDA_MODEL_LOG: Demanda encontrada. Status atual: " . $demanda['status'] . ", Status usuário: " . ($demanda['status_usuario'] ?? 'não atribuído'));

            // 2. Verificar se o usuário está atribuído à demanda ou é o admin
            $sqlCheckAssignment = "
                SELECT COUNT(*) 
                FROM demanda_usuarios du
                INNER JOIN demandas d ON du.demanda_id = d.id
                WHERE du.demanda_id = ? AND (du.usuario_id = ? OR d.admin_id = ?)
            ";
            $stmtCheckAssignment = $this->pdo->prepare($sqlCheckAssignment);
            $stmtCheckAssignment->execute([$demandaId, $usuarioId, $usuarioId]);
            $isAssignedOrAdmin = $stmtCheckAssignment->fetchColumn();

            if (!$isAssignedOrAdmin) {
                error_log("DEMANDA_MODEL_LOG: Erro - Usuário ID $usuarioId não atribuído à demanda ID $demandaId e não é admin.");
                $this->pdo->rollBack();
                return false;
            }
            error_log("DEMANDA_MODEL_LOG: Usuário ID $usuarioId verificado: atribuído ou admin.");

            // 3. Atualizar o status do usuário na tabela demanda_usuarios
            $sqlUpdateUserStatus = "
                UPDATE demanda_usuarios 
                SET status = 'concluido', 
                    data_conclusao = NOW() 
                WHERE demanda_id = ? AND usuario_id = ?
            ";
            $stmtUpdateUserStatus = $this->pdo->prepare($sqlUpdateUserStatus);
            $successUpdateUser = $stmtUpdateUserStatus->execute([$demandaId, $usuarioId]);

            if (!$successUpdateUser) {
                error_log("DEMANDA_MODEL_LOG: Erro ao atualizar status do usuário.");
                $this->pdo->rollBack();
                return false;
            }
            error_log("DEMANDA_MODEL_LOG: Status do usuário atualizado para 'concluido'.");

            // 4. Verificar se todos os usuários atribuídos concluíram a demanda
            $sqlCheckAllConcluded = "
                SELECT COUNT(*) as total,
                       SUM(CASE WHEN status = 'concluido' THEN 1 ELSE 0 END) as concluidos
                FROM demanda_usuarios 
                WHERE demanda_id = ?
            ";
            $stmtCheckAllConcluded = $this->pdo->prepare($sqlCheckAllConcluded);
            $stmtCheckAllConcluded->execute([$demandaId]);
            $status = $stmtCheckAllConcluded->fetch(PDO::FETCH_ASSOC);

            error_log("DEMANDA_MODEL_LOG: Total de usuários: " . $status['total'] . ", Concluídos: " . $status['concluidos']);

            // 5. Se todos os usuários concluíram, atualizar status da demanda
            if ($status['total'] > 0 && $status['total'] == $status['concluidos']) {
                $sqlUpdateDemandaStatus = "
                    UPDATE demandas 
                    SET status = 'concluida', 
                        data_conclusao = NOW() 
                    WHERE id = ?
                ";
                $stmtUpdateDemandaStatus = $this->pdo->prepare($sqlUpdateDemandaStatus);
                $successUpdateDemanda = $stmtUpdateDemandaStatus->execute([$demandaId]);

                if (!$successUpdateDemanda) {
                    error_log("DEMANDA_MODEL_LOG: Erro ao atualizar status da demanda.");
                    $this->pdo->rollBack();
                    return false;
                }
                error_log("DEMANDA_MODEL_LOG: Status da demanda atualizado para 'concluida'.");
            }

            $this->pdo->commit();
            error_log("DEMANDA_MODEL_LOG: Transação commitada com sucesso.");
            return true;

        } catch (Exception $e) {
            error_log("DEMANDA_MODEL_LOG: Exception caught: " . $e->getMessage());
            error_log("DEMANDA_MODEL_LOG: Stack trace: " . $e->getTraceAsString());
            $this->pdo->rollBack();
            return false;
        }
    }

    // Verificar permissão para usuário (agora verifica se o usuário está atribuído ou é admin)
    public function verificarPermissaoUsuario($demandaId, $usuarioId) {
        error_log("\n=== VERIFICANDO PERMISSÃO DO USUÁRIO ===");
        error_log("Demanda ID: $demandaId, Usuário ID: $usuarioId");
        
        try {
            // 1. Verificar se o usuário é admin da demanda
            $sqlAdmin = "
                SELECT COUNT(*) 
                FROM demandas 
                WHERE id = ? AND admin_id = ?
            ";
            $stmtAdmin = $this->pdo->prepare($sqlAdmin);
            $stmtAdmin->execute([$demandaId, $usuarioId]);
            $isAdmin = $stmtAdmin->fetchColumn() > 0;
            
            if ($isAdmin) {
                error_log("Usuário é admin da demanda");
                return true;
            }
            
            // 2. Verificar se o usuário está atribuído à demanda
            $sqlAtribuido = "
                SELECT COUNT(*) 
                FROM demanda_usuarios 
                WHERE demanda_id = ? AND usuario_id = ?
            ";
            $stmtAtribuido = $this->pdo->prepare($sqlAtribuido);
            $stmtAtribuido->execute([$demandaId, $usuarioId]);
            $isAtribuido = $stmtAtribuido->fetchColumn() > 0;
            
            if ($isAtribuido) {
                error_log("Usuário está atribuído à demanda");
                return true;
            }
            
            // 3. Verificar se o usuário tem permissão na área da demanda
            $sqlArea = "
                SELECT d.area_id, p.descricao
                FROM demandas d
                INNER JOIN u750204740_salaberga.usu_sist us ON us.usuario_id = ?
                INNER JOIN u750204740_salaberga.sist_perm sp ON us.sist_perm_id = sp.id
                INNER JOIN u750204740_salaberga.permissoes p ON sp.permissao_id = p.id
                WHERE d.id = ? AND sp.sistema_id = 3
            ";
            $stmtArea = $this->pdo->prepare($sqlArea);
            $stmtArea->execute([$usuarioId, $demandaId]);
            $permissoes = $stmtArea->fetchAll(PDO::FETCH_COLUMN);
            
            error_log("Permissões encontradas: " . print_r($permissoes, true));
            
            // Verificar se tem permissão de admin geral
            foreach ($permissoes as $permissao) {
                if (strpos($permissao, 'adm_geral') === 0) {
                    error_log("Usuário tem permissão de admin geral");
                    return true;
                }
            }
            
            error_log("Usuário não tem permissão para atualizar esta demanda");
            return false;
            
        } catch (Exception $e) {
            error_log("Erro ao verificar permissão: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            return false;
        }
    }

    public function verificarStatusUsuario($demanda_id, $usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT status 
            FROM demanda_usuarios 
            WHERE demanda_id = ? AND usuario_id = ?
        ");
        $stmt->execute([$demanda_id, $usuario_id]);
        return $stmt->fetchColumn();
    }

    public function aceitarDemanda($demanda_id, $usuario_id) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE demanda_usuarios 
                SET status = 'inscrito', data_aceitacao = CURRENT_TIMESTAMP 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            return $stmt->execute([$demanda_id, $usuario_id]);
        } catch (Exception $e) {
            error_log("Erro ao aceitar demanda: " . $e->getMessage());
            return false;
        }
    }

    public function recusarDemanda($demanda_id, $usuario_id) {
        try {
            // Remover o usuário da demanda em vez de marcar como recusado
            $stmt = $this->pdo->prepare("
                DELETE FROM demanda_usuarios 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            return $stmt->execute([$demanda_id, $usuario_id]);
        } catch (Exception $e) {
            error_log("Erro ao recusar demanda: " . $e->getMessage());
            return false;
        }
    }

    // Este método pode não ser mais necessário ou precisará ser adaptado dependendo do uso
    // public function verificarPermissao($id, $usuario_id, $tipo) {
    //     $stmt = $this->pdo->prepare("
    //         SELECT * FROM demandas 
    //         WHERE id = ? AND (usuario_id = ? OR admin_id = ? OR ? = 'admin')
    //     ");
    //     $stmt->execute([$id, $usuario_id, $usuario_id, $tipo]);
    //     return $stmt->fetch() !== false;
    // }

    public function criarDemandaTeste() {
        try {
            error_log("Iniciando criação de demanda de teste");
            
            $this->pdo->beginTransaction();
            
            // Inserir a demanda
            $sql = "INSERT INTO demandas (
                titulo, 
                descricao, 
                prioridade, 
                admin_id, 
                status, 
                prazo, 
                area_id
            ) VALUES (
                'Teste de Demanda', 
                'Demanda de teste para verificar o funcionamento do sistema', 
                'media', 
                1, 
                'pendente', 
                DATE_ADD(NOW(), INTERVAL 7 DAY), 
                1
            )";
            
            error_log("SQL para criar demanda: " . $sql);
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            
            $demanda_id = $this->pdo->lastInsertId();
            error_log("Demanda criada com ID: " . $demanda_id);
            
            // Atribuir ao usuário 12
            $sql = "INSERT INTO demanda_usuarios (demanda_id, usuario_id, status) VALUES (?, 12, 'pendente')";
            error_log("SQL para atribuir demanda: " . $sql);
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$demanda_id]);
            
            error_log("Demanda atribuída ao usuário 12");
            
            // Verificar se foi criada e atribuída corretamente
            $sql = "SELECT d.*, du.status as status_usuario 
                    FROM demandas d 
                    INNER JOIN demanda_usuarios du ON d.id = du.demanda_id 
                    WHERE d.id = ? AND du.usuario_id = 12";
            
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$demanda_id]);
            $demanda = $stmt->fetch(PDO::FETCH_ASSOC);
            
            error_log("Verificação da demanda criada: " . print_r($demanda, true));
            
            $this->pdo->commit();
            error_log("Transação concluída com sucesso");
            
            return $demanda_id;
            
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erro ao criar demanda de teste: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw $e;
        }
    }
} 