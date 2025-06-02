<?php
class Demanda {
    private $pdo;
    private $pdo_salaberga;

    public function __construct($pdo) {
        $this->pdo = $pdo;
        $this->pdo_salaberga = Database::getInstance()->getSalabergaConnection();
    }

    public function listarDemandas() {
        $stmt = $this->pdo->prepare("
            SELECT d.*, u.nome as admin_nome
            FROM demandas d 
            LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
            ORDER BY d.data_criacao DESC
        ");
        $stmt->execute();
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
        error_log("DEBUG: Iniciando listarDemandasPorUsuario para usuário ID: " . $usuario_id);

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
        
        error_log("DEBUG: Permissões encontradas: " . print_r($permissoes, true));

        // Array para armazenar os IDs das áreas do usuário
        $area_ids = [];

        // Processar cada permissão
        foreach ($permissoes as $permissao) {
            if (strpos($permissao['permissao'], 'usuario_area_') === 0 || strpos($permissao['permissao'], 'adm_area_') === 0) {
                $area_nome = substr($permissao['permissao'], strpos($permissao['permissao'], '_') + 1);
                $area_nome = substr($area_nome, strpos($area_nome, '_') + 1);
                $area_nome = ucfirst($area_nome); // Primeira letra maiúscula
                
                error_log("DEBUG: Nome da área extraído: " . $area_nome);
                
                // Buscar o ID da área pelo nome
                $stmtAreaId = $this->pdo->prepare("SELECT id FROM areas WHERE nome = ?");
                $stmtAreaId->execute([$area_nome]);
                $area = $stmtAreaId->fetch(PDO::FETCH_ASSOC);
                
                error_log("DEBUG: Área encontrada: " . print_r($area, true));
                
                if ($area) {
                    $area_ids[] = $area['id'];
                    error_log("DEBUG: ID da área adicionado: " . $area['id']);
                }
            }
        }

        // Se não encontrou nenhuma área específica, buscar todas as demandas atribuídas ao usuário
        if (empty($area_ids)) {
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT d.*, u.nome as admin_nome,
                       COALESCE(du.status, 'pendente') as status_usuario,
                       du.data_conclusao as data_conclusao_usuario
                FROM demandas d 
                LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
                LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id AND du.usuario_id = ?
                WHERE du.usuario_id = ?
                ORDER BY d.data_criacao DESC
            ");
            $stmt->execute([$usuario_id, $usuario_id]);
        } else {
            // Buscar demandas onde o usuário está atribuído OU que são das áreas do usuário
            $placeholders = str_repeat('?,', count($area_ids) - 1) . '?';
            $stmt = $this->pdo->prepare("
                SELECT DISTINCT d.*, u.nome as admin_nome,
                       COALESCE(du.status, 'pendente') as status_usuario,
                       du.data_conclusao as data_conclusao_usuario
                FROM demandas d 
                LEFT JOIN u750204740_salaberga.usuarios u ON d.admin_id = u.id 
                LEFT JOIN demanda_usuarios du ON d.id = du.demanda_id AND du.usuario_id = ?
                WHERE du.usuario_id = ? OR d.area_id IN ($placeholders)
                ORDER BY d.data_criacao DESC
            ");
            
            // Preparar os parâmetros: usuario_id, usuario_id, e todos os area_ids
            $params = array_merge([$usuario_id, $usuario_id], $area_ids);
            $stmt->execute($params);
        }

        $demandas = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        error_log("DEBUG: Query executada com parâmetros - usuario_id: $usuario_id, area_ids: " . implode(',', $area_ids));
        error_log("DEBUG: Número de demandas encontradas: " . count($demandas));
        error_log("DEBUG: Primeira demanda (se houver): " . print_r(!empty($demandas) ? $demandas[0] : 'Nenhuma demanda', true));

        // Para cada demanda, buscar os usuários atribuídos
        foreach ($demandas as &$demanda) {
            $stmtUsuarios = $this->pdo->prepare("
                SELECT u.id, u.nome, du.status, du.data_conclusao 
                FROM u750204740_salaberga.usuarios u
                LEFT JOIN demanda_usuarios du ON u.id = du.usuario_id
                WHERE du.demanda_id = ?
            ");
            $stmtUsuarios->execute([$demanda['id']]);

            // DEBUG: Log da consulta de usuários atribuídos
            error_log("DEBUG SQL: Consulta para usuarios_atribuidos: " . $stmtUsuarios->queryString);
            error_log("DEBUG Params: Parametros para usuarios_atribuidos: " . print_r([$demanda['id']], true));
            error_log("DEBUG Result: Resultado da consulta de usuarios_atribuidos: " . print_r($stmtUsuarios->fetchAll(PDO::FETCH_ASSOC), true));

            // Resetar o ponteiro para que o fetchAll posterior funcione
            $stmtUsuarios->execute([$demanda['id']]);

            $demanda['usuarios_atribuidos'] = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
        }

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

    public function criarDemanda($titulo, $descricao, $prioridade, $admin_id, $usuarios_ids = [], $prazo = null, $area_id = null, $usuarioModel = null) {
        try {
            $this->pdo->beginTransaction();

            $dias_para_adicionar = 0;
            switch ($prioridade) {
                case 'baixa': $dias_para_adicionar = 5; break;
                case 'media': $dias_para_adicionar = 3; break;
                case 'alta': $dias_para_adicionar = 1; break;
            }
            $prazo_calculado = date('Y-m-d', strtotime("+" . $dias_para_adicionar . " days"));

            $stmt = $this->pdo->prepare("
                INSERT INTO demandas (titulo, descricao, prioridade, admin_id, status, prazo, area_id)
                VALUES (?, ?, ?, ?, 'pendente', ?, ?)
            ");
            $stmt->execute([$titulo, $descricao, $prioridade, $admin_id, $prazo_calculado, $area_id]);

            $demanda_id = $this->pdo->lastInsertId();

            // Atribuir usuários apenas se a lista de IDs for fornecida explicitamente
            if (!empty($usuarios_ids)) {
                $stmtAtribuir = $this->pdo->prepare("
                    INSERT INTO demanda_usuarios (demanda_id, usuario_id, status)
                    VALUES (?, ?, 'pendente')
                ");
                foreach ($usuarios_ids as $usuario_id) {
                    $stmtAtribuir->execute([$demanda_id, $usuario_id]);
                }
            }

            $this->pdo->commit();
            return true;
        } catch (Exception $e) {
            $this->pdo->rollBack();
            error_log("Erro ao criar demanda: " . $e->getMessage());
            return false;
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