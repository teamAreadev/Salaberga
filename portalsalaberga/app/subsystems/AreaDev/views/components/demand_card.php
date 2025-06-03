<!-- Card Header -->
<div class="flex items-start justify-between mb-4">
    <div class="flex-1">
        <h3 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"
            onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')">
            <?php echo htmlspecialchars($d['titulo']); ?>
        </h3>
        <div class="flex items-center gap-2 mb-2">
            <span class="status-badge status-<?php echo $d['status']; ?>">
                <?php
                $statusIcons = [
                    'pendente' => 'fas fa-clock',
                    'em_andamento' => 'fas fa-spinner fa-spin',
                    'concluida' => 'fas fa-check-circle',
                    'cancelada' => 'fas fa-ban',
                    'aceito' => 'fas fa-check-circle'
                ];
                
                $display_status = $d['status'];
                $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';

                if (!empty($d['usuarios_atribuidos']) && count($d['usuarios_atribuidos']) === 1) {
                    $single_participant_status = $d['usuarios_atribuidos'][0]['status'] ?? null;
                    if ($single_participant_status === 'concluido') {
                        $display_status = 'concluida';
                        $display_icon = $statusIcons[$display_status] ?? 'fas fa-question';
                    }
                }
                
                $status_display = ucfirst(str_replace('_', ' ', $display_status));
                ?>
                <i class="<?php echo $display_icon; ?>"></i>
                <?php echo $status_display; ?>
            </span>
            <span class="priority-badge priority-<?php echo $d['prioridade']; ?>">
                <?php echo ucfirst($d['prioridade']); ?>
            </span>
        </div>
    </div>
    <div class="text-right">
        <span class="text-xs text-gray-400">ID: #<?php echo $d['id']; ?></span>
    </div>
</div>

<!-- Card Content -->
<div class="mb-4">
    <p class="text-gray-300 text-sm line-clamp-3 mb-3">
        <?php echo htmlspecialchars($d['descricao']); ?>
    </p>
    
    <div class="grid grid-cols-2 gap-4 text-xs">
        <div>
            <span class="text-gray-400">Criado em:</span>
            <p class="text-white font-medium">
                <?php echo date('d/m/Y', strtotime($d['data_criacao'])); ?>
            </p>
            <p class="text-gray-400">
                <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
            </p>
        </div>
        <div>
            <span class="text-gray-400">
                <?php echo !empty($d['data_conclusao']) ? 'Concluído em:' : 'Prazo:'; ?>
            </span>
            <p class="text-white font-medium">
                <?php 
                if (!empty($d['data_conclusao'])) {
                    echo date('d/m/Y', strtotime($d['data_conclusao']));
                } else {
                    $dias_prazo = 0;
                    switch ($d['prioridade']) {
                        case 'baixa': $dias_prazo = 5; break;
                        case 'media': $dias_prazo = 3; break;
                        case 'alta': $dias_prazo = 1; break;
                    }
                    echo date('d/m/Y', strtotime($d['data_criacao'] . " +{$dias_prazo} days"));
                }
                ?>
            </p>
            <?php if (!empty($d['data_conclusao'])): ?>
            <p class="text-gray-400">
                <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
            </p>
            <?php else: ?>
            <p class="text-gray-400">
                <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
            </p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Card Actions -->
<div class="flex items-center justify-between pt-4 border-t border-gray-700">
    <button 
        onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')"
        class="custom-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg"
        title="Ver detalhes">
        <i class="fas fa-eye"></i>
    </button>

    <div class="flex items-center gap-2 ml-auto">
        <?php if ($d['status'] !== 'concluida'): ?>
            <?php if ($d['status'] === 'pendente'): ?>
                <button onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $d['status']; ?>')" 
                        class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-tasks"></i>
                    Realizar Tarefa
                </button>
            <?php elseif ($d['status'] === 'em_andamento'): ?>
                <button onclick="concluirDemanda(<?php echo $d['id']; ?>)" 
                        class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded-lg transition-all duration-300 flex items-center gap-2">
                    <i class="fas fa-check"></i>
                    Concluir
                </button>
            <?php endif; ?>
        <?php endif; ?>
        <button onclick="editarDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg" title="Editar">
            <i class="fas fa-edit"></i>
        </button>
        <button onclick="excluirDemanda(<?php echo $d['id']; ?>)" class="custom-btn bg-red-600 hover:bg-red-700 text-white py-1 px-2 rounded-lg" title="Excluir">
            <i class="fas fa-trash"></i>
        </button>
    </div>
</div>

<!-- Status dos Usuários -->
<?php if (!empty($d['usuarios_atribuidos'])): ?>
<div class="mt-4 pt-4 border-t border-gray-700">
    <h4 class="text-sm font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
    <div class="flex flex-wrap gap-2">
        <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
            <div class="flex items-center gap-2">
                <span class="text-xs text-gray-300"><?php echo isset($u_atrib['nome']) && $u_atrib['nome'] ? htmlspecialchars($u_atrib['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>:</span>
                <span class="status-badge status-<?php echo $u_atrib['status']; ?>">
                    <?php
                    $statusIconsParticipante = [
                        'pendente' => 'fas fa-clock',
                        'aceito' => 'fas fa-check-circle',
                        'em_andamento' => 'fas fa-spinner fa-spin',
                        'concluido' => 'fas fa-check-circle',
                        'recusado' => 'fas fa-times-circle'
                    ];
                    ?>
                    <i class="<?php echo $statusIconsParticipante[$u_atrib['status']] ?? 'fas fa-question'; ?>"></i>
                    <?php echo ucfirst($u_atrib['status']); ?>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?> 