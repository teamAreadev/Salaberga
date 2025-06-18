<?php
require_once('../models/adm.model.php');
$model_adm = new adm_model();
session_start();
?>
<!DOCTYPE html>
<html lang="pt-BR" class="dark">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a1a1a">
    <meta name="description" content="Painel Administrativo - Sistema de Gestão de Demandas">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="icon" href="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <title>Painel Administrativo - Sistema de Gestão de Demandas</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background-color: #1a1a1a; color: #fff; min-height: 100vh; }
    </style>
</head>

<body class="select-none">
    <!-- Header -->
    <header class="bg-dark-400 shadow-lg border-b border-primary-500/20 sticky top-0 z-50 backdrop-blur-lg">
        <div class="container mx-auto px-4 py-4">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3 w-full sm:w-auto justify-center sm:justify-start">
                    <img src="https://i.postimg.cc/Dy40VtFL/Design-sem-nome-13-removebg-preview.png" alt="Logo" class="w-10 h-10">
                    <div class="text-center sm:text-left">
                        <h1 class="text-xl md:text-2xl font-bold bg-gradient-to-r from-primary-50 to-primary-200 bg-clip-text text-transparent">
                            Painel Administrativo
                        </h1>
                        <p class="text-sm text-gray-400">Sistema de Gestão de Demandas</p>
                    </div>
                </div>
                <div class="flex flex-col sm:flex-row items-center gap-4 w-full sm:w-auto">
                    <div class="flex items-center gap-2 text-gray-300 bg-dark-300/50 px-4 py-2 rounded-lg">
                        <i class="fas fa-user-shield text-primary-50"></i>
                        <span class="text-sm truncate max-w-[200px]">
                            <?php echo isset($_SESSION['usuario_nome']) ? htmlspecialchars($_SESSION['usuario_nome']) : 'Administrador'; ?>
                        </span>
                    </div>
                    <div class="flex items-center gap-2 w-full sm:w-auto justify-center sm:justify-end">
                        <a href="#" class="custom-btn bg-primary-500 hover:bg-primary-600 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-chart-bar btn-icon"></i>
                            <span>Relatórios</span>
                        </a>
                        <a href="../../main/views/autenticacao/login.php" class="custom-btn bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white py-2 px-4 rounded-lg flex items-center gap-2 text-sm w-full sm:w-auto justify-center">
                            <i class="fas fa-sign-out-alt btn-icon"></i>
                            <span>Sair</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main class="container mx-auto px-4 py-8">
        <!-- Botão para abrir modal de cadastro -->
        <div class="flex justify-end mb-6">
            <button onclick="openModal('modalCadastrarDemanda')" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-6 rounded-lg flex items-center gap-2">
                <i class="fas fa-plus btn-icon"></i> Nova Demanda
            </button>
        </div>
        <!-- Modal de Cadastro -->
        <div id="modalCadastrarDemanda" class="modal fixed inset-0 hidden items-center justify-center p-4 z-50">
            <div class="modal-content w-full max-w-md p-6 scale-in bg-dark-200 rounded-xl shadow-lg border border-gray-800">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-white">Nova Demanda</h3>
                    <button onclick="closeModal('modalCadastrarDemanda')" class="text-gray-400 hover:text-white transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <form action="../controllers/adm.controller.php" method="post">
                    <div class="form-group mb-4">
                        <label for="titulo" class="block text-gray-300 mb-2">Título</label>
                        <input type="text" name="titulo" id="titulo" required class="custom-input w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-2 text-white">
                    </div>
                    <div class="form-group mb-4">
                        <label for="descricao" class="block text-gray-300 mb-2">Descrição</label>
                        <input type="text" name="descricao" id="descricao" required class="custom-input w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-2 text-white">
                    </div>
                    <div class="form-group mb-4">
                        <label class="block text-gray-300 mb-2">Prioridade</label>
                        <div class="radio-group flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="prioridade" value="baixa" required class="accent-green-500">
                                Baixa
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="prioridade" value="media" required class="accent-yellow-500">
                                Média
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="prioridade" value="alta" required class="accent-red-500">
                                Alta
                            </label>
                        </div>
                    </div>
                    <input type="hidden" name="id_admin" value="<?= $_SESSION['user_id'] ?>">
                    <input type="date" name="prazo" required class="custom-input w-full bg-dark-100 border border-gray-700 rounded-lg px-4 py-2 text-white mb-4">
                    <div class="flex justify-end gap-4 mt-6">
                        <button type="button" onclick="closeModal('modalCadastrarDemanda')" class="custom-btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg">Cancelar</button>
                        <button type="submit" class="custom-btn bg-gradient-to-r from-primary-500 to-primary-50 hover:from-primary-400 hover:to-primary-100 text-white font-bold py-2 px-4 rounded-lg">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            function openModal(id) {
                document.getElementById(id).classList.remove('hidden');
                document.getElementById(id).classList.add('flex');
                document.body.style.overflow = 'hidden';
            }
            function closeModal(id) {
                document.getElementById(id).classList.add('hidden');
                document.getElementById(id).classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        </script>
        <?php
        if (isset($_GET['status'])) {
            switch ($_GET['status']) {
                case 'success':
                    echo '<div class="status-message status-success">Demanda cadastrada com sucesso!</div>';
                    break;
                case 'error':
                    echo '<div class="status-message status-error">Erro ao cadastrar demanda. Verifique se o título já existe.</div>';
                    break;
                case 'empty':
                    echo '<div class="status-message status-empty">Por favor, preencha todos os campos.</div>';
                    break;
            }
        }
        ?>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Coluna Pendente -->
            <div>
                <h1 class="text-xl font-bold text-white mb-4">Pendente</h1>
                <div class="demanda-container flex flex-col gap-6 mb-8">
                    <?php
                    $dados = $model_adm->select_demandas_pendentes();
                    foreach ($dados as $dado) {
                    ?>
                        <div class="demanda-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300">
                            <h2 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"><?= htmlspecialchars($dado['titulo']) ?></h2>
                            <p class="text-gray-300 text-sm line-clamp-3 mb-3"><?= htmlspecialchars($dado['descricao']) ?></p>
                            <p>Prioridade: <span class="priority-badge priority-<?= strtolower($dado['prioridade']) ?>"><?= htmlspecialchars($dado['prioridade']) ?></span></p>
                            <p>Status: <span class="status-badge status-pendente"><?= htmlspecialchars($dado['status']) ?></span></p>
                            <p>Prazo: <?= htmlspecialchars($dado['prazo']) ?></p>
                            <form action="../controllers/adm.controller.php" method="post" class="mt-2">
                                <input type="hidden" name="id_usuario" value="<?= $_SESSION['user_id'] ?>">
                                <input type="hidden" name="id_demanda" value="<?= $dado['id'] ?>">
                                <button type="submit" class="custom-btn bg-yellow-600 hover:bg-yellow-700 text-white py-1 px-2 rounded-lg mt-2">Fazer Demanda</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Coluna Em Andamento -->
            <div>
                <h1 class="text-xl font-bold text-white mb-4">Em andamento</h1>
                <div class="demanda-container flex flex-col gap-6 mb-8">
                    <?php
                    $dados = $model_adm->select_demandas_andamentos();
                    foreach ($dados as $dado) {
                    ?>
                        <div class="demanda-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300">
                            <h2 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"><?= htmlspecialchars($dado['titulo']) ?></h2>
                            <p class="text-gray-300 text-sm line-clamp-3 mb-3"><?= htmlspecialchars($dado['descricao']) ?></p>
                            <p>Prioridade: <span class="priority-badge priority-<?= strtolower($dado['prioridade']) ?>"><?= htmlspecialchars($dado['prioridade']) ?></span></p>
                            <p>Status: <span class="status-badge status-andamento"><?= htmlspecialchars($dado['status']) ?></span></p>
                            <p>Prazo: <?= htmlspecialchars($dado['prazo']) ?></p>
                            <p>Selecionados: <?= htmlspecialchars($dado['nome_usuario']) ?></p>
                            <form action="../controllers/adm.controller.php" method="post" class="mt-2">
                                <input type="hidden" name="id_demanda_concluir" value="<?= $dado['id'] ?>">
                                <button type="submit" class="custom-btn bg-green-600 hover:bg-green-700 text-white py-1 px-2 rounded-lg mt-2">Concluir Demanda</button>
                            </form>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <!-- Coluna Concluída -->
            <div>
                <h1 class="text-xl font-bold text-white mb-4">Concluída</h1>
                <div class="demanda-container flex flex-col gap-6 mb-8">
                    <?php
                    $dados = $model_adm->select_demandas_concluidos();
                    foreach ($dados as $dado) {
                    ?>
                        <div class="demanda-card bg-dark-100 rounded-xl p-6 shadow-lg border border-gray-800 hover:border-primary/30 transition-all duration-300">
                            <h2 class="text-lg font-semibold text-white mb-2 line-clamp-2 cursor-pointer hover:text-primary-50 transition-colors duration-300"><?= htmlspecialchars($dado['titulo']) ?></h2>
                            <p class="text-gray-300 text-sm line-clamp-3 mb-3"><?= htmlspecialchars($dado['descricao']) ?></p>
                            <p>Prioridade: <span class="priority-badge priority-<?= strtolower($dado['prioridade']) ?>"><?= htmlspecialchars($dado['prioridade']) ?></span></p>
                            <p>Status: <span class="status-badge status-concluido"><?= htmlspecialchars($dado['status']) ?></span></p>
                            <p>Prazo: <?= htmlspecialchars($dado['prazo']) ?></p>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </main>
</body>

</html>