<?php
// Iniciar sessão
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header('Location: login.php');
    exit;
}

// Dados do usuário
$nome = $_SESSION['usuario_nome'] ?? '';
$email = $_SESSION['usuario_email'] ?? '';
$inscricoes = $_SESSION['usuario_inscricoes'] ?? [];
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil do Usuário - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#e6f2ec',
                            100: '#cce5d9',
                            200: '#99cbb3',
                            300: '#66b18d',
                            400: '#339766',
                            500: '#007d40',
                            600: '#006a36',
                            700: '#005A24', // Base primary color
                            800: '#004d1f',
                            900: '#00401a',
                        },
                        secondary: {
                            50: '#fff8e6',
                            100: '#ffefc0',
                            200: '#ffe099',
                            300: '#ffd066',
                            400: '#ffc033',
                            500: '#ffb000',
                            600: '#FF8C00', // Base secondary color
                            700: '#cc7000',
                            800: '#995400',
                            900: '#663800',
                        },
                        accent: {
                            50: '#ffede9',
                            100: '#ffdbd3',
                            200: '#ffb7a7',
                            300: '#ff937b',
                            400: '#FF6347', // Base accent color
                            500: '#ff3814',
                            600: '#e62600',
                            700: '#b31e00',
                            800: '#801500',
                            900: '#4d0c00',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 700;
            border-radius: 0.375rem;
            text-transform: uppercase;
        }
        .badge-aprovado {
            background-color: #e6f2ec;
            color: #007d40;
        }
        .badge-pendente {
            background-color: #fff8e6;
            color: #cc7000;
        }
        .badge-reprovado {
            background-color: #ffede9;
            color: #e62600;
        }
    </style>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Cabeçalho -->
        <header class="bg-primary-700 text-white shadow-lg sticky top-0 z-10">
            <div class="container mx-auto py-3 px-4 md:px-6">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" alt="Logo Copa Grêmio" class="h-10 w-10">
                        <div>
                            <h1 class="text-xl font-bold whitespace-nowrap">Copa Grêmio 2025</h1>
                            <p class="text-primary-200 text-xs">Grêmio Estudantil José Ivan Pontes Júnior</p>
                        </div>
                    </div>
                    <a href="../controllers/UsuarioController.php?action=logout" class="bg-secondary-600 hover:bg-secondary-700 text-white px-3 py-1 rounded-md shadow-md transition-colors flex items-center text-sm">
                        <i class="fas fa-sign-out-alt mr-1"></i> Sair
                    </a>
                </div>
            </div>
        </header>

        <!-- Conteúdo Principal -->
        <main class="container mx-auto py-8 px-4 md:px-6 flex-grow">
            <div class="max-w-4xl mx-auto">
                <!-- Perfil do Usuário -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-8">
                    <h2 class="text-2xl font-bold text-primary-800 mb-6 pb-2 border-b border-gray-200 flex items-center">
                        <i class="fas fa-user-circle mr-2 text-secondary-600"></i>
                        Perfil do Usuário
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Informações Pessoais -->
                        <section>
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-id-card mr-2 text-secondary-600"></i>
                                <span>Informações Pessoais</span>
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-4 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Nome Completo</p>
                                    <p class="text-lg font-medium"><?php echo htmlspecialchars($nome); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">E-mail</p>
                                    <p class="text-lg font-medium"><?php echo htmlspecialchars($email); ?></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Ano e Turma</p>
                                    <p class="text-lg font-medium"><?php echo isset($_SESSION['usuario_ano']) && isset($_SESSION['usuario_turma']) ? $_SESSION['usuario_ano'] . '° Ano ' . $_SESSION['usuario_turma'] : 'Não disponível'; ?></p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Telefone</p>
                                    <p class="text-lg font-medium"><?php echo isset($_SESSION['usuario_telefone']) ? htmlspecialchars($_SESSION['usuario_telefone']) : 'Não disponível'; ?></p>
                                </div>
                            </div>
                        </section>

                        <!-- Modalidades Inscritas -->
                        <section>
                            <h3 class="text-xl font-semibold text-primary-700 mb-4 flex items-center">
                                <i class="fas fa-trophy mr-2 text-secondary-600"></i>
                                <span>Modalidades Inscritas</span>
                            </h3>
                            
                            <?php if (empty($inscricoes)): ?>
                                <div class="p-4 bg-gray-50 rounded-lg text-center">
                                    <p class="text-gray-500">Nenhuma modalidade encontrada para este usuário.</p>
                                </div>
                            <?php else: ?>
                                <!-- Layout para telas maiores (md+) -->
                                <div class="hidden md:block">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modalidade</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoria</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Equipe</th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            <?php foreach ($inscricoes as $inscricao): ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="font-medium text-gray-900"><?php echo htmlspecialchars($inscricao['modalidade']); ?></div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                        <?php echo htmlspecialchars($inscricao['categoria']); ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">
                                                        <?php echo !empty($inscricao['nome_equipe']) ? htmlspecialchars($inscricao['nome_equipe']) : 'Não aplicável'; ?>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <?php 
                                                        $status = $inscricao['status'];
                                                        $statusClass = '';
                                                        switch($status) {
                                                            case 'aprovado':
                                                                $statusClass = 'badge-aprovado';
                                                                break;
                                                            case 'pendente':
                                                                $statusClass = 'badge-pendente';
                                                                break;
                                                            case 'reprovado':
                                                                $statusClass = 'badge-reprovado';
                                                                break;
                                                        }
                                                        ?>
                                                        <span class="badge <?php echo $statusClass; ?>">
                                                            <?php echo ucfirst(htmlspecialchars($status)); ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <!-- Layout para telas menores (mobile) -->
                                <div class="grid grid-cols-1 gap-4 md:hidden">
                                    <?php foreach ($inscricoes as $inscricao): ?>
                                        <div class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm">
                                            <div class="flex justify-between items-center mb-2">
                                                <h5 class="font-bold text-gray-900 text-lg"><?php echo htmlspecialchars($inscricao['modalidade']); ?></h5>
                                                <?php 
                                                $status = $inscricao['status'];
                                                $statusClass = '';
                                                switch($status) {
                                                    case 'aprovado':
                                                        $statusClass = 'badge-aprovado';
                                                        break;
                                                    case 'pendente':
                                                        $statusClass = 'badge-pendente';
                                                        break;
                                                    case 'reprovado':
                                                        $statusClass = 'badge-reprovado';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge <?php echo $statusClass; ?>">
                                                    <?php echo ucfirst(htmlspecialchars($status)); ?>
                                                </span>
                                            </div>
                                            <div class="grid grid-cols-2 gap-2 text-sm">
                                                <div>
                                                    <p class="text-gray-500">Categoria:</p>
                                                    <p class="font-medium"><?php echo htmlspecialchars($inscricao['categoria']); ?></p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500">Equipe:</p>
                                                    <p class="font-medium"><?php echo !empty($inscricao['nome_equipe']) ? htmlspecialchars($inscricao['nome_equipe']) : 'Não aplicável'; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </section>

                        <!-- Botão de Voltar -->
                        <div class="mt-8 text-center">
                            <a href="../index.php" class="inline-flex items-center px-4 py-2 bg-primary-600 text-white rounded-md hover:bg-primary-700 transition-colors">
                                <i class="fas fa-arrow-left mr-2"></i> Voltar para o início
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Rodapé -->
        <footer class="bg-white border-t border-gray-200 py-4">
            <div class="container mx-auto px-4 md:px-6">
                <div class="text-center text-sm text-gray-500">
                    <p>&copy; 2025 Grêmio Estudantil José Ivan Pontes Júnior</p>
                    <p>EEEP Salaberga Torquato Gomes de Matos</p>
                    <p class="mt-1">Desenvolvido por <span class="font-medium text-primary-600">Matheus Felix</span></p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html> 