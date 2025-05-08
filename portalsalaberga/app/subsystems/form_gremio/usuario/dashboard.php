<?php
session_start();
if (!isset($_SESSION['aluno_id'])) {
    header("Location: ../index.php");
    exit();
}

require_once '../config/config.php';
require_once '../model/UsuarioModel.php';
$usuarioModel = new UsuarioModel();
$dadosUsuario = $usuarioModel->obterDadosUsuario($_SESSION['aluno_id']);

if (!$dadosUsuario['success']) {
    header("Location: ../index.php");
    exit();
}

$aluno = $dadosUsuario['aluno'];
$inscricoes = $dadosUsuario['inscricoes'];

// Contar modalidades aprovadas
$modalidades_aprovadas = 0;
foreach ($inscricoes as $inscricao) {
    if ($inscricao['status'] === 'aprovado') {
        $modalidades_aprovadas++;
    }
}

// Definir o valor da inscrição
$valor_inscricao = $modalidades_aprovadas >= 3 ? '3,00' : '5,00';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" type="image/svg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f2ec', 100: '#cce5d9', 200: '#99cbb3', 300: '#66b18d',
                            400: '#339766', 500: '#007d40', 600: '#006a36', 700: '#005A24',
                            800: '#004d1f', 900: '#00401a',
                        },
                        secondary: {
                            50: '#fff8e6', 100: '#ffefc0', 200: '#ffe099', 300: '#ffd066',
                            400: '#ffc033', 500: '#ffb000', 600: '#FF8C00', 700: '#cc7000',
                            800: '#995400', 900: '#663800',
                        }
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.5s ease-in-out',
                    },
                    keyframes: {
                        fadeIn: {
                            '0%': { opacity: '0', transform: 'translateY(10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Poppins', sans-serif; }
        .modal { transition: opacity 0.3s ease, transform 0.3s ease; }
        .modal-hidden { opacity: 0; transform: scale(0.95); pointer-events: none; }
        .btn-primary { background-image: linear-gradient(to right, #007d40 0%, #339766 50%, #007d40 100%); }
        .btn-primary:hover { background-position: right center; transform: translateY(-2px); }
        .btn-secondary { background-image: linear-gradient(to right, #FF8C00 0%, #ffc033 50%, #FF8C00 100%); }
        .btn-secondary:hover { background-position: right center; transform: translateY(-2px); }
        .toast { transition: transform 0.3s ease-out, opacity 0.3s ease-out; }
        .table-responsive { overflow-x: auto; }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Unified Navigation -->
        <header class="bg-primary-700 text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo and Branding -->
            <div class="flex items-center space-x-3">
                <div class="p-1 rounded-full shadow-md">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" 
                         alt="Logo Copa Grêmio" 
                         class="h-10 w-10" loading="lazy">
                </div>
                <div>
                    <h1 class="text-lg sm:text-xl font-bold tracking-tight">Copa Grêmio 2025</h1>
                    <p class="text-primary-100 text-xs opacity-90">Grêmio Estudantil José Ivan Pontes Júnior</p>
                </div>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                <ul class="flex space-x-4">
                    <li>
                        <a href="dashboard.php" class="text-primary-200 border-b-2 border-primary-400 px-3 py-2 hover:text-white transition-colors">
                            Início
                        </a>
                    </li>
                    <li>
                        <a href="equipes.php" class="text-white hover:text-primary-200 px-3 py-2 transition-colors">
                            Equipes
                        </a>
                    </li>
                    <li>
                        <a href="logout.php" class="text-white hover:text-primary-200 px-3 py-2 transition-colors">
                            Sair
                        </a>
                    </li>
                </ul>
            </nav>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white p-2 focus:outline-none hover:bg-white/10 rounded-lg transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-primary-600/95 backdrop-blur-sm">
        <div class="container mx-auto px-4 py-2">
            <ul class="flex flex-col space-y-1">
                <li>
                    <a href="dashboard.php" class="text-primary-200 border-l-4 border-primary-400 px-3 py-2.5 block hover:bg-white/10 transition-colors">
                        Início
                    </a>
                </li>
                <li>
                    <a href="equipes.php" class="text-white px-3 py-2.5 block hover:bg-white/10 transition-colors">
                        Equipes
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="text-white px-3 py-2.5 block hover:bg-white/10 transition-colors">
                        Sair
                    </a>
                </li>
            </ul>
        </div>
    </div>
</header>

        <main class="flex-grow container mx-auto px-4 py-8">
    <!-- Welcome Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-2">Bem-vindo(a), <?php echo $aluno['nome']; ?>!</h1>
        <p class="text-gray-600">Gerencie suas inscrições para a Copa Grêmio 2025.</p>
    </div>

    <!-- Action Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
        <!-- Collective Card -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <i class="fas fa-users text-3xl text-primary-600 mr-3"></i>
                <h3 class="text-lg font-semibold">Inscrição Coletiva</h3>
            </div>
            <p class="text-gray-600 mb-4">Participe de modalidades coletivas criando ou entrando em uma equipe.</p>
            <a href="equipes.php" class="btn-primary text-white px-4 py-2 rounded-md inline-block">Gerenciar Equipes</a>
        </div>

        <!-- Individual Card -->
        <div class="bg-white rounded-lg shadow-md p-6 hover:shadow-lg transition-shadow">
            <div class="flex items-center mb-4">
                <i class="fas fa-running text-3xl text-secondary-600 mr-3"></i>
                <h3 class="text-lg font-semibold">Inscrição Individual</h3>
            </div>
            <p class="text-gray-600 mb-4">Participe de modalidades individuais como tênis de mesa, dama, xadrez e mais.</p>
            <button onclick="openModal('inscricaoIndividualModal')" class="btn-secondary text-white px-4 py-2 rounded-md">Fazer Inscrição</button>
        </div>
    </div>

    <!-- My Inscriptions -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Minhas Inscrições</h2>
        <?php if (empty($inscricoes)): ?>
            <div class="bg-gray-50 rounded-md p-4 text-center">
                <p class="text-gray-500">Você ainda não possui inscrições.</p>
            </div>
        <?php else: ?>
            <!-- Card layout for mobile -->
            <div class="space-y-4 md:hidden">
                <?php foreach ($inscricoes as $inscricao): ?>
                    <div class="bg-gray-50 rounded-lg p-4 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex flex-col space-y-2">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-800"><?php echo ucfirst($inscricao['modalidade']); ?></h4>
                                    <p class="text-xs text-gray-500"><?php echo ucfirst($inscricao['categoria']); ?></p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded-full <?php echo $inscricao['status'] == 'aprovado' ? 'bg-green-100 text-green-700' : ($inscricao['status'] == 'reprovado' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'); ?>">
                                    <?php echo ucfirst($inscricao['status']); ?>
                                </span>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Equipe:</span> 
                                    <?php echo $inscricao['nome_equipe'] ? $inscricao['nome_equipe'] : 'Individual'; ?>
                                </p>
                            </div>
                            <?php if (!$inscricao['nome_equipe']): // Se for individual ?>
                                <button type="button"
                                    class="mt-2 w-full bg-primary-600 hover:bg-primary-700 text-white px-3 py-2 rounded-md flex items-center justify-center gap-2 text-sm"
                                    onclick="abrirPagamentoIndividual('<?php echo ucfirst($inscricao['modalidade']); ?>', '<?php echo $valor_inscricao; ?>')">
                                    <i class="fas fa-money-bill-wave mr-1"></i> Ver informações de pagamento
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Table layout for larger screens -->
            <div class="table-responsive hidden md:block">
                <table class="min-w-full bg-white border rounded-md">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Modalidade</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Categoria</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Equipe</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500">Pagamento</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscricoes as $inscricao): ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-2 text-sm"><?php echo ucfirst($inscricao['modalidade']); ?></td>
                                <td class="px-4 py-2 text-sm"><?php echo ucfirst($inscricao['categoria']); ?></td>
                                <td class="px-4 py-2 text-sm"><?php echo $inscricao['nome_equipe'] ? $inscricao['nome_equipe'] : 'Individual'; ?></td>
                                <td class="px-4 py-2 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-full <?php echo $inscricao['status'] == 'aprovado' ? 'bg-green-100 text-green-700' : ($inscricao['status'] == 'reprovado' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'); ?>">
                                        <?php echo ucfirst($inscricao['status']); ?>
                                    </span>
                                </td>
                                <td class="px-4 py-2 text-sm">
                                    <?php if (!$inscricao['nome_equipe']): // Se for individual ?>
                                        <button type="button"
                                            class="bg-primary-600 hover:bg-primary-700 text-white px-3 py-1 rounded-md flex items-center justify-center gap-2 text-xs"
                                            onclick="abrirPagamentoIndividual('<?php echo ucfirst($inscricao['modalidade']); ?>', '<?php echo $valor_inscricao; ?>')">
                                            <i class="fas fa-money-bill-wave mr-1"></i> Pagamento
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</main>

        <!-- Footer -->
        <footer class="bg-gray-800 text-white py-6">
            <div class="container mx-auto px-4 text-center">
                <p>© 2025 Copa Grêmio - Grêmio Estudantil José Ivan Pontes Júnior</p>
                <p class="text-gray-400 text-sm mt-1">Todos os direitos reservados</p>
            </div>
        </footer>

        <!-- Individual Enrollment Modal -->
        <div id="inscricaoIndividualModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal modal-hidden">
            <div class="bg-white rounded-lg w-full max-w-sm mx-4 p-4">
                <div class="flex justify-between items-center mb-4 sticky top-0 bg-white pb-3 border-b">
                    <div>
                        <h3 class="text-lg font-bold text-secondary-600">Inscrição Individual</h3>
                        <p class="text-sm text-gray-500">Escolha sua modalidade</p>
                    </div>
                    <button onclick="closeModal('inscricaoIndividualModal')" class="text-gray-600 hover:text-gray-800 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="inscricaoIndividualForm" class="space-y-4">
                    <div>
                        <label for="modalidadeIndividual" class="block text-sm font-medium text-gray-700 mb-1">Modalidade</label>
                        <div class="relative">
                            <select id="modalidadeIndividual" name="modalidadeIndividual" required 
                                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-500 bg-white appearance-none pr-10">
                                <option value="">Selecione uma modalidade...</option>
                              
                                <option value="tenis">Tênis de Mesa</option>
                                <option value="xadrez">Xadrez</option>
                                <option value="judo">Judô</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label for="categoriaIndividual" class="block text-sm font-medium text-gray-700 mb-1">Categoria</label>
                        <div class="relative">
                            <select id="categoriaIndividual" name="categoriaIndividual" required 
                                    class="w-full px-4 py-2.5 border rounded-lg focus:outline-none focus:ring-2 focus:ring-secondary-500 bg-white appearance-none pr-10">
                                <option value="">Selecione uma categoria...</option>
                                <option value="masculino">Masculino</option>
                                <option value="feminino">Feminino</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                                <i class="fas fa-chevron-down text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="flex flex-col gap-1">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Valor da inscrição:</span>
                                <span class="text-lg font-semibold text-secondary-600">R$ <?php echo $valor_inscricao; ?></span>
                            </div>
                            <?php if ($modalidades_aprovadas >= 3): ?>
                            <p class="text-xs text-green-600">
                                <i class="fas fa-check-circle mr-1"></i>
                                Desconto aplicado! (<?php echo $modalidades_aprovadas; ?> modalidades aprovadas)
                            </p>
                            <?php elseif ($modalidades_aprovadas > 0): ?>
                            <p class="text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Desconto disponível a partir de 3 modalidades (atual: <?php echo $modalidades_aprovadas; ?>)
                            </p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="flex gap-3 pt-2">
                        <button type="button" onclick="closeModal('inscricaoIndividualModal')" 
                                class="flex-1 px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition-all duration-300">
                            Cancelar
                        </button>
                        <button type="submit" 
                                class="flex-1 px-4 py-2.5 bg-secondary-600 hover:bg-secondary-700 text-white rounded-lg transition-all duration-300 flex items-center justify-center gap-2">
                            <span>Inscrever-se</span>
                            <i class="fas fa-arrow-right text-sm"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Payment Modal -->
        <div id="paymentModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden modal modal-hidden">
            <div class="bg-white rounded-lg w-full max-w-sm mx-4 p-4">
                <div class="flex justify-between items-center mb-3 sticky top-0 bg-white">
                    <h3 class="text-lg font-bold text-primary-700">Pagamento</h3>
                    <button onclick="closeModal('paymentModal')" class="text-gray-600 hover:text-gray-800 p-1">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Resumo da Inscrição -->
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <div class="space-y-1">
                            <p class="text-center font-medium"><span id="modalNomeModalidade" class="text-primary-700"></span></p>
                            <p class="text-center text-xl font-bold text-primary-800">R$ <span id="modalValorTotal">5,00</span></p>
                        </div>
                    </div>

                    <!-- Chave PIX -->
                    <div class="bg-white border rounded-lg p-3">
                        <div class="space-y-2">
                            <span class="text-sm text-gray-700">Chave PIX:</span>
                            <div class="flex items-center gap-2">
                                <span id="modalChavePix" class="font-mono bg-gray-50 px-3 py-2 rounded border text-sm flex-1 overflow-x-auto whitespace-nowrap"><?php echo PIX_CHAVE; ?></span>
                                <button onclick="copiarPix(document.getElementById('modalChavePix').textContent)" 
                                        class="bg-primary-600 hover:bg-primary-700 text-white p-2 rounded-lg flex items-center justify-center transition-all duration-300 hover:scale-105">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                <i class="fas fa-user mr-1"></i> <?php echo PIX_NOME; ?>
                            </p>
                        </div>
                    </div>

                    <!-- Instruções -->
                    <div class="bg-primary-50 p-3 rounded-lg">
                        <h4 class="font-medium text-primary-800 mb-2 text-sm">Como pagar:</h4>
                        <ol class="list-decimal list-inside space-y-1 text-primary-700 text-sm">
                            <li>Copie a chave PIX</li>
                            <li>Abra seu app do banco</li>
                            <li>Faça a transferência</li>
                            <li>Salve o comprovante</li>
                            <li>Envie pelo WhatsApp</li>
                        </ol>
                    </div>

                    <!-- Botão do WhatsApp -->
                    <button id="btnWhatsApp" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg flex items-center justify-center font-medium transition-all duration-300 hover:scale-105">
                        <i class="fab fa-whatsapp mr-2"></i>
                        Enviar Comprovante
                    </button>
                </div>
            </div>
        </div>

        <!-- Toast Notification -->
        <div id="toast" class="toast fixed bottom-4 right-4 bg-primary-600 text-white p-4 rounded-lg shadow-lg hidden">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span id="toastMessage"></span>
            </div>
        </div>
    </div>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', () => {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // Modal Functions
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.remove('hidden', 'modal-hidden');
            setTimeout(() => modal.classList.remove('modal-hidden'), 10);
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('modal-hidden');
            setTimeout(() => modal.classList.add('hidden'), 300);
        }

        // Copiar PIX
        function copiarPix(chave) {
            navigator.clipboard.writeText(chave)
                .then(() => {
                    // Criar elemento de confirmação de cópia
                    const confirmacao = document.createElement('div');
                    confirmacao.className = 'fixed bottom-4 right-4 bg-green-600 text-white py-2 px-4 rounded-lg shadow-lg flex items-center z-50';
                    confirmacao.innerHTML = '<i class="fas fa-check-circle mr-2"></i> Chave PIX copiada com sucesso!';
                    confirmacao.style.transition = 'opacity 0.5s ease';
                    document.body.appendChild(confirmacao);
                    
                    // Remover após 2 segundos
                    setTimeout(() => {
                        confirmacao.classList.add('opacity-0');
                        setTimeout(() => confirmacao.remove(), 500);
                    }, 2000);
                })
                .catch(() => {
                    alert('Erro ao copiar chave PIX. Por favor, copie manualmente.');
                });
        }

        function enviarComprovante(modalidade, valor) {
            const mensagem = `Olá! Segue o comprovante de pagamento:\n\n` +
                            `*Modalidade:* ${modalidade}\n` +
                            `*Valor:* R$ ${valor}`;
            
            const numeroWhatsapp = '<?php echo WHATSAPP_NUMERO; ?>';
            const url = `https://wa.me/${numeroWhatsapp}?text=${encodeURIComponent(mensagem)}`;
            window.open(url, '_blank');
        }

        // Form Submission
        document.getElementById('inscricaoIndividualForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const submitButton = this.querySelector('button[type="submit"]');
            const originalText = submitButton.innerHTML;
            
            // Desabilitar o botão e mostrar loading
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processando...';
            
            const modalidade = document.getElementById('modalidadeIndividual').value;
            const categoria = document.getElementById('categoriaIndividual').value;
            const valor = '<?php echo $valor_inscricao; ?>';

            const formData = new FormData();
            formData.append('action', 'inscricaoIndividual');
            formData.append('modalidade', modalidade);
            formData.append('categoria', categoria);
            formData.append('valor', valor);

            fetch('../controllers/InscricaoController.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast('Inscrição realizada com sucesso!', 'success');
                    closeModal('inscricaoIndividualModal');
                    
                    // Atualizar informações do modal de pagamento
                    document.getElementById('modalNomeModalidade').textContent = modalidade.charAt(0).toUpperCase() + modalidade.slice(1);
                    document.getElementById('modalValorTotal').textContent = valor;
                    document.getElementById('btnWhatsApp').onclick = () => enviarComprovante(modalidade, valor);
                    
                    openModal('paymentModal');
                    setTimeout(() => {
                        window.location.reload();
                    }, 8000);
                } else {
                    showToast('Erro: ' + data.message, 'error');
                    // Restaurar o botão
                    submitButton.disabled = false;
                    submitButton.innerHTML = originalText;
                }
            })
            .catch(error => {
                showToast('Ocorreu um erro ao fazer a inscrição.', 'error');
                // Restaurar o botão
                submitButton.disabled = false;
                submitButton.innerHTML = originalText;
            });
        });

        // Função para mostrar toast
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            toast.classList.remove('hidden');
            toast.style.backgroundColor = type === 'success' ? '#007d40' : '#e62600';
            toastMessage.textContent = message;
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }

        function abrirPagamentoIndividual(modalidade, valor) {
            document.getElementById('modalNomeModalidade').textContent = modalidade;
            document.getElementById('modalValorTotal').textContent = valor;
            document.getElementById('btnWhatsApp').onclick = () => enviarComprovante(modalidade, valor);
            openModal('paymentModal');
        }
    </script>
</body>
</html>