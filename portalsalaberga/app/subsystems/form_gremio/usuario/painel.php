<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário - Copa Grêmio 2025</title>
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
                            700: '#005A24',
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
                            600: '#FF8C00',
                            700: '#cc7000',
                            800: '#995400',
                            900: '#663800',
                        },
                        accent: {
                            50: '#ffede9',
                            100: '#ffdbd3',
                            200: '#ffb7a7',
                            300: '#ff937b',
                            400: '#FF6347',
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
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease-out forwards;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.8; }
        }
        .animate-pulse {
            animation: pulse 2s infinite;
        }
        .hover-float:hover {
            transform: translateY(-3px);
            transition: transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md animate-fadeInUp" style="animation-delay: 0.1s">
        <div class="bg-gradient-to-r from-primary-700 to-primary-800 text-white rounded-t-lg py-6 px-8 text-center shadow-lg">
            <i class="fas fa-user text-4xl mb-3 text-secondary-300 animate-pulse"></i>
            <h1 class="text-2xl font-bold">Painel do Usuário</h1>
            <p class="text-primary-200">Copa Grêmio 2025</p>
        </div>
        <div class="bg-white shadow-xl rounded-b-lg p-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-32 h-32 bg-primary-50 rounded-full -mt-16 -mr-16 opacity-50"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-secondary-50 rounded-full -mb-12 -ml-12 opacity-50"></div>
            <div id="painel-conteudo" class="relative z-10">
                <div class="flex justify-center items-center py-8">
                    <i class="fas fa-spinner fa-spin mr-2 text-primary-600"></i> Carregando informações...
                </div>
            </div>
            <div class="mt-6 text-center relative z-10 animate-fadeInUp" style="animation-delay: 0.7s">
                <a href="login.php?logout=1" class="text-sm text-primary-600 hover:text-primary-800 flex items-center justify-center transition-colors duration-300">
                    <i class="fas fa-sign-out-alt mr-1"></i> Sair
                </a>
            </div>
        </div>
        <div class="mt-4 text-center text-xs text-gray-500 animate-fadeInUp" style="animation-delay: 0.8s">
            <p>&copy; 2025 Grêmio Estudantil José Ivan Pontes Júnior</p>
            <p>EEEP Salaberga Torquato Gomes de Matos</p>
        </div>
    </div>
    <script>
        // Logout simples
        if (window.location.search.includes('logout=1')) {
            fetch('../controllers/InscricaoController.php?action=logout', { method: 'POST' })
                .then(() => { window.location.href = 'login.php'; });
        }
        // Buscar dados da inscrição
        fetch('../controllers/InscricaoController.php?action=infoInscricao')
            .then(response => response.json())
            .then(data => {
                const painel = document.getElementById('painel-conteudo');
                if (data.success && data.data) {
                    const info = data.data;
                    painel.innerHTML = `
                        <h2 class="text-xl font-bold text-primary-800 mb-6 flex items-center"><i class="fas fa-clipboard-list mr-2 text-secondary-600"></i> Sua Inscrição</h2>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-primary-700 mb-2">Dados Pessoais</h3>
                            <ul class="space-y-1">
                                <li><strong>Nome:</strong> ${info.nome}</li>
                                <li><strong>Turma:</strong> ${info.ano}º ${info.turma}</li>
                                <li><strong>E-mail:</strong> ${info.email}</li>
                                <li><strong>Telefone:</strong> ${info.telefone}</li>
                            </ul>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-primary-700 mb-2">Modalidades Inscritas</h3>
                            <ul class="space-y-2">
                                ${(info.modalidades || []).map(m => `<li class="capitalize">${m}</li>`).join('')}
                            </ul>
                        </div>
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-primary-700 mb-2">Status</h3>
                            <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">Pendente</span>
                        </div>
                    `;
                } else {
                    painel.innerHTML = `<div class='p-6 bg-red-50 text-red-700 rounded-lg text-center'><i class='fas fa-exclamation-circle text-3xl mb-2'></i><p>${data.message || 'Não foi possível carregar suas informações.'}</p></div>`;
                }
            })
            .catch(() => {
                document.getElementById('painel-conteudo').innerHTML = `<div class='p-6 bg-red-50 text-red-700 rounded-lg text-center'><i class='fas fa-exclamation-circle text-3xl mb-2'></i><p>Erro ao carregar informações.</p></div>`;
            });
    </script>
</body>
</html> 