<!-- Header Section -->
<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-2">
    <div class="flex-1 min-w-0">
        <h3 class="text-sm sm:text-base font-semibold text-white mb-1 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300 break-words"
            onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')">
            <?php echo htmlspecialchars($d['titulo']); ?>
        </h3>
        <div class="flex flex-wrap items-center gap-1 mb-1">
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
            <span class="priority-badge priority-<?php echo $d['prioridade']; ?> text-xs sm:text-xs">
                <?php echo ucfirst($d['prioridade']); ?>
            </span>
        </div>
    </div>
    <div class="flex-shrink-0 text-right sm:text-left">
        <span class="text-xs text-gray-400 whitespace-nowrap">ID: #<?php echo $d['id']; ?></span>
    </div>
</div>

<!-- Description and Dates Section -->
<div class="mb-2 space-y-2">
    <p class="text-gray-300 text-xs line-clamp-3 break-words">
        <?php echo htmlspecialchars($d['descricao']); ?>
    </p>
    
    <!-- Responsive Date Grid -->
    <div class="grid grid-cols-1 xs:grid-cols-2 gap-2 sm:gap-3 text-xs">
        <div class="bg-gray-800/30 p-1.5 rounded-lg">
            <span class="text-gray-400 block mb-0.5">Criado em:</span>
            <div class="flex flex-col xs:flex-row xs:items-center xs:gap-1">
                <p class="text-white font-medium">
                    <?php echo date('d/m/Y', strtotime($d['data_criacao'])); ?>
                </p>
                <p class="text-gray-400 text-xs">
                    <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
                </p>
            </div>
        </div>
        <div class="bg-gray-800/30 p-1.5 rounded-lg">
            <span class="text-gray-400 block mb-0.5">
                <?php echo !empty($d['data_conclusao']) ? 'Concluído em:' : 'Prazo:'; ?>
            </span>
            <div class="flex flex-col xs:flex-row xs:items-center xs:gap-1">
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
                <p class="text-gray-400 text-xs">
                    <?php if (!empty($d['data_conclusao'])): ?>
                        <?php echo date('H:i', strtotime($d['data_conclusao'])); ?>
                    <?php else: ?>
                        <?php echo date('H:i', strtotime($d['data_criacao'])); ?>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Card Actions - Improved Mobile Layout -->
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 pt-2 border-t border-gray-700">
    <!-- View Details Button -->
    <button 
        onclick="mostrarDescricao('<?php echo htmlspecialchars($d['titulo']); ?>', '<?php echo htmlspecialchars($d['descricao']); ?>', '<?php echo $d['status']; ?>', '<?php echo date('d/m/Y H:i', strtotime($d['data_criacao'])); ?>', '<?php echo !empty($d['data_conclusao']) ? date('d/m/Y H:i', strtotime($d['data_conclusao'])) : ''; ?>')"
        class="custom-btn bg-blue-600 hover:bg-blue-700 text-white p-2 rounded-lg flex items-center justify-center gap-2 sm:w-auto order-2 sm:order-1 text-xs"
        title="Ver detalhes">
        <i class="fas fa-eye"></i>
        <span class="sm:hidden">Ver Detalhes</span>
    </button>

    <!-- Action Buttons -->
    <div class="flex flex-col xs:flex-row gap-1 w-full sm:w-auto order-1 sm:order-2">
        <?php
            // Use o status específico do usuário se disponível, senão use o status geral da demanda
            $current_user_status = $d['status_usuario'] ?? $d['status'];

            // DEBUG: Logar os status
            error_log("DEBUG CARD - Demanda ID: " . $d['id'] . ", Status Geral: " . $d['status'] . ", Status Usuário: " . ($d['status_usuario'] ?? 'NULL') . ", Status Atual para Lógica: " . $current_user_status);
        ?>
        <?php if ($current_user_status !== 'concluida' && $current_user_status !== 'concluido' && $current_user_status !== 'recusado'): ?>
            <div class="w-full xs:w-auto">
                <?php if ($current_user_status === 'pendente' || $current_user_status === 'aceito'): ?>
                    <button type="button"
                            onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $current_user_status; ?>')"
                            class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1.5 px-2 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 text-xs w-full xs:w-auto">
                        <i class="fas fa-tasks"></i>
                        <span class="hidden xs:inline">Realizar Tarefa</span>
                        <span class="xs:hidden">Realizar</span>
                    </button>
                <?php elseif ($current_user_status === 'em_andamento'): ?>
                    <button type="button"
                            onclick="realizarTarefa(<?php echo $d['id']; ?>, '<?php echo $current_user_status; ?>')"
                            class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1.5 px-2 rounded-lg transition-all duration-300 flex items-center justify-center gap-2 text-xs flex-1 sm:flex-none w-full xs:w-auto">
                        <i class="fas fa-check"></i>
                        <span class="hidden xs:inline">Concluir</span>
                        <span class="xs:hidden">Concluir</span>
                    </button>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Status dos Usuários - Improved Mobile Layout -->
<?php if (!empty($d['usuarios_atribuidos'])): ?>
<div class="mt-2 pt-2 border-t border-gray-700">
    <h4 class="text-xs font-semibold text-gray-400 mb-2">Status dos Participantes:</h4>
    <div class="space-y-1 sm:space-y-0 sm:flex sm:flex-wrap sm:gap-2">
        <?php foreach ($d['usuarios_atribuidos'] as $u_atrib): ?>
            <div class="flex items-center justify-between sm:justify-start gap-1 bg-gray-800/30 p-1.5 rounded-lg sm:bg-transparent sm:p-0">
                <span class="text-xs text-gray-300 font-medium min-w-0 flex-1 sm:flex-none truncate">
                    <?php echo isset($u_atrib['nome']) && $u_atrib['nome'] ? htmlspecialchars($u_atrib['nome']) : '<span class="text-gray-500">Sem nome</span>'; ?>:
                </span>
                <span class="status-badge status-<?php echo $u_atrib['status']; ?> text-xs flex-shrink-0">
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
                    <span class="hidden xs:inline"><?php echo ucfirst($u_atrib['status']); ?></span>
                </span>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?> 