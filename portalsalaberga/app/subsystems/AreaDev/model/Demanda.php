<?php
class Demanda {
    private $pdo;
    private $pdo_salaberga;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo_salaberga = Database::getInstance()->getSalabergaConnection();
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
                        LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
                        ORDER BY d.data_criacao DESC
                    ");
                    $stmt->execute();
                    $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    // Buscar usuários atribuídos (mantém igual)
                    foreach ($demandas as &$demanda) {
                        $stmtUsuarios = $this->pdo->prepare("
                            SELECT u.id, u.nome, du.status, du.data_conclusao 
                            FROM u750204740_salaberga.usuarios u
                            INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                            WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                            UNION
                            SELECT u.id, u.nome, d.status as status, d.data_conclusao
                            FROM u750204740_salaberga.usuarios u
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
                LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
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
                LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
                ORDER BY d.data_criacao DESC
            ");
            $stmt->execute();
        }

        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Para cada demanda, buscar os usuários atribuídos
        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM u750204740_salaberga.usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                UNION
                SELECT u.id, u.nome, d.status as status, d.data_conclusao
                FROM u750204740_salaberga.usuarios u
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

        // Primeiro, buscar todas as permissões do usuário
        $stmtArea = $this->pdo_salaberga->prepare("
            SELECT p.descricao as permissao
            FROM usu_sist us
            INNER JOIN sist_perm sp ON us.sist_perm_id = sp.id
            INNER JOIN permissoes p ON sp.permissao_id = p.id
            WHERE us.usuario_id = ? AND sp.sistema_id = 3
        ");
        $stmtArea->execute([$usuario_id]);
        $permissoes = $stmtArea->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("\n=== PERMISSÕES ENCONTRADAS ===");
        error_log(print_r($permissoes, true));

        // Array para armazenar os IDs das áreas do usuário
        $area_ids = [];

        // Processar cada permissão
        foreach ($permissoes as $permissao) {
            $permissao_desc = $permissao['permissao'];
            error_log("\n=== PROCESSANDO PERMISSÃO ===");
            error_log("Permissão original: " . $permissao_desc);
            
            // Remover o sufixo (3) se existir
            $permissao_desc = preg_replace('/\(\d+\)$/', '', $permissao_desc);
            error_log("Permissão após remover sufixo: " . $permissao_desc);
            
            if (strpos($permissao_desc, 'usuario_area_') === 0 || strpos($permissao_desc, 'adm_area_') === 0) {
                $area_nome = substr($permissao_desc, strpos($permissao_desc, '_') + 1);
                $area_nome = substr($area_nome, strpos($area_nome, '_') + 1);
                $area_nome = ucfirst($area_nome); // Primeira letra maiúscula
                
                error_log("Nome da área extraído: " . $area_nome);
                
                // Buscar o ID da área pelo nome (usando LIKE para correspondência parcial)
                $stmtAreaId = $this->pdo->prepare("SELECT id FROM areas WHERE LOWER(nome) LIKE LOWER(?)");
                $stmtAreaId->execute(["%$area_nome%"]);
                $area = $stmtAreaId->fetch(PDO::FETCH_ASSOC);
                
                error_log("Resultado da busca da área: " . print_r($area, true));
                
                if ($area) {
                    $area_ids[] = $area['id'];
                    error_log("ID da área adicionado: " . $area['id']);
                }
            }
        }

        error_log("\n=== ÁREAS ENCONTRADAS ===");
        error_log("IDs das áreas: " . print_r($area_ids, true));

        // Buscar demandas onde o usuário está atribuído OU que são das áreas do usuário
        $sql = "
            SELECT DISTINCT d.*, u.nome as admin_nome,
                   COALESCE(du.status, 'pendente') as status_usuario,
                   du.data_conclusao as data_conclusao_usuario
            FROM demandas d 
            LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
            LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id AND du.usuario_id = ?
            WHERE du.usuario_id = ?";

        if (!empty($area_ids)) {
            $placeholders = str_repeat('?,', count($area_ids) - 1) . '?';
            $sql .= " OR d.area_id IN ($placeholders)";
        }

        $sql .= " ORDER BY d.data_criacao DESC";
        
        error_log("\n=== SQL GERADA ===");
        error_log($sql);

        $params = [$usuario_id, $usuario_id];
        if (!empty($area_ids)) {
            $params = array_merge($params, $area_ids);
        }
        
        error_log("\n=== PARÂMETROS ===");
        error_log(print_r($params, true));

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("\n=== DEMANDAS ENCONTRADAS ===");
        error_log("Número de demandas: " . count($demandas));
        error_log("Demandas: " . print_r($demandas, true));

        // Para cada demanda, buscar os usuários atribuídos
        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM u750204740_salaberga.usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ?
            ");
            $stmtUsuarios->execute([$demanda['id']]);
            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
            error_log("\n=== USUÁRIOS ATRIBUÍDOS PARA DEMANDA " . $demanda['id'] . " ===");
            error_log(print_r($demanda['usuarios_atribuidos'], true));
        }

        error_log("\n=== FIM DO DEBUG DE LISTAR DEMANDAS POR USUÁRIO ===\n");
        return $demandas;
    }

    public function buscarDemanda($id) {
        $sql = "SELECT d.*, GROUP_CONCAT(du.usuario_id) as usuarios_atribuidos 
                FROM demandas d 
                LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id 
                WHERE d.id = :id 
                GROUP BY d.id";
        
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
            LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
            WHERE d.area_id = ?
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute([$area_id]);
        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM u750204740_salaberga.usuarios u
                INNER JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ? AND du.status IN ('aceito', 'em_andamento', 'concluido')
                UNION
                SELECT u.id, u.nome, d.status as status, d.data_conclusao
                FROM u750204740_salaberga.usuarios u
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
            WHERE us.usuario_id = ? AND p.descricao = 'adm_geral' AND sp.sistema_id = ?
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
            $this->pdo->beginTransaction();

            // Verificar permissão do admin para a área
            if (!$this->verificarPermissaoAdminArea($admin_id, $area_id)) {
                throw new Exception('Você não tem permissão para criar demandas nesta área');
            }

            // Debug dos dados recebidos
            error_log('DEBUG MODEL DATA: ' . print_r([
                'titulo' => $titulo,
                'descricao' => $descricao,
                'prioridade' => $prioridade,
                'admin_id' => $admin_id,
                'usuarios_ids' => $usuarios_ids,
                'prazo' => $prazo,
                'area_id' => $area_id
            ], true));

            // Validar campos obrigatórios
            if (empty($titulo) || empty($descricao) || empty($prioridade) || empty($admin_id) || empty($area_id)) {
                error_log('ERRO: Campos obrigatórios não preenchidos');
                throw new Exception('Todos os campos obrigatórios devem ser preenchidos');
            }

            // Verificar se a área existe
            $stmt = $this->pdo->prepare("SELECT id FROM areas WHERE id = ?");
            $stmt->execute([$area_id]);
            if (!$stmt->fetch()) {
                throw new Exception('Área não encontrada');
            }

            // Verificar se o admin existe
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
            $prazo_calculado = date('Y-m-d', strtotime("+" . $dias_para_adicionar . " days"));

            // Debug do SQL
            $sql = "INSERT INTO demandas (titulo, descricao, prioridade, admin_id, status, prazo, area_id) VALUES (?, ?, ?, ?, 'pendente', ?, ?)";
            error_log('DEBUG SQL: ' . $sql);
            error_log('DEBUG PARAMS: ' . print_r([$titulo, $descricao, $prioridade, $admin_id, $prazo_calculado, $area_id], true));

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$titulo, $descricao, $prioridade, $admin_id, $prazo_calculado, $area_id]);

            $demanda_id = $this->pdo->lastInsertId();
            error_log('DEBUG DEMANDA ID: ' . $demanda_id);

            // Atribuir usuários apenas se a lista de IDs for fornecida explicitamente
            if (!empty($usuarios_ids)) {
                $stmtAtribuir = $this->pdo->prepare("
                    INSERT INTO demanda_usuarios (demanda_id, usuario_id, status)
                    VALUES (?, ?, 'pendente')
                ");
                foreach ($usuarios_ids as $usuario_id) {
                    // Verificar se o usuário existe
                    $stmt = $this->pdo_salaberga->prepare("SELECT id FROM usuarios WHERE id = ?");
                    $stmt->execute([$usuario_id]);
                    if (!$stmt->fetch()) {
                        throw new Exception('Usuário não encontrado: ' . $usuario_id);
                    }
                    
                    error_log('DEBUG: Atribuindo usuário ' . $usuario_id . ' à demanda ' . $demanda_id);
                    $stmtAtribuir->execute([$demanda_id, $usuario_id]);
                }
            }

            $this->pdo->commit();
            error_log('DEBUG: Demanda criada com sucesso. ID: ' . $demanda_id);
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log('ERRO AO CRIAR DEMANDA: ' . $e->getMessage() . ' | Título: ' . $titulo . ' | Admin: ' . $admin_id . ' | Área: ' . $area_id);
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

    public function marcarConcluida($id, $usuario_id) {
        try {
            $this->pdo->beginTransaction();
            
            // Atualiza o status do usuário específico
            $stmt = $this->pdo->prepare("
                UPDATE demanda_usuarios 
                SET status = 'concluido', data_conclusao = CURRENT_TIMESTAMP 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            $stmt->execute([$id, $usuario_id]);

            // Verifica se todos os usuários concluíram
            $stmt = $this->pdo->prepare("
                SELECT COUNT(*) as total,
                       SUM(CASE WHEN status = 'concluido' THEN 1 ELSE 0 END) as concluidos
                FROM demanda_usuarios 
                WHERE demanda_id = ?
            ");
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            // Se todos os usuários concluíram, marca a demanda como concluída
            if ($resultado['total'] > 0 && $resultado['total'] == $resultado['concluidos']) {
                $stmt = $this->pdo->prepare("
                    UPDATE demandas 
                    SET status = 'concluida', data_conclusao = CURRENT_TIMESTAMP 
                    WHERE id = ?
                ");
                $stmt->execute([$id]);
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    public function marcarEmAndamento($id, $usuario_id) {
        try {
            $this->pdo->beginTransaction();
            
            // Atualiza o status do usuário específico
            $stmt = $this->pdo->prepare("
                UPDATE demanda_usuarios 
                SET status = 'em_andamento' 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            $stmt->execute([$id, $usuario_id]);

            // Atualiza o status geral da demanda
            $stmt = $this->pdo->prepare("
                UPDATE demandas 
                SET status = 'em_andamento' 
                WHERE id = ?
            ");
            $stmt->execute([$id]);

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    // Verificar permissão para usuário (agora verifica se o usuário está atribuído ou é admin)
    public function verificarPermissaoUsuario($id, $usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT COUNT(*) 
            FROM demanda_usuarios du
            INNER JOIN demandas d ON du.demanda_id = d.id
            WHERE du.demanda_id = ? AND (du.usuario_id = ? OR d.admin_id = ?)
        ");
        $stmt->execute([$id, $usuario_id, $usuario_id]);
        return $stmt->fetchColumn() > 0;
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
                SET status = 'aceito', data_aceitacao = CURRENT_TIMESTAMP 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            return $stmt->execute([$demanda_id, $usuario_id]);
        } catch (Exception $e) {
            return false;
        }
    }

    public function recusarDemanda($demanda_id, $usuario_id) {
        try {
            $stmt = $this->pdo->prepare("
                UPDATE demanda_usuarios 
                SET status = 'recusado' 
                WHERE demanda_id = ? AND usuario_id = ?
            ");
            return $stmt->execute([$demanda_id, $usuario_id]);
        } catch (Exception $e) {
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
} 