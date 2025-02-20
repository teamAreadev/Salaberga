<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <?php
    session_start();
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <title>Meu Perfil</title>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        custom: {
                            background: '#f0f7ff',
                            text: '#333333',
                            header: '#007A33',
                            accent: '#FFA500',
                            grid: '#e0e0e0',
                        },
                        dark: {
                            background: '#1a1a1a',
                            text: '#ffffff',
                            header: '#004d1a',
                            accent: '#cc8400',
                            grid: '#333333',
                        },
                    },
                    boxShadow: {
                        'custom': '0 0 15px rgba(0, 0, 0, 0.1)',
                    },
                    fontFamily: {
                        'noto': ['Noto Sans', 'sans-serif'],
                        'anton': ['Anton', 'serif'],
                        'inter': ['Inter', 'sans-serif'],
                    },
                },
            },
        }
    </script>

    <script>
        // Verifica o tema do sistema
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark');
            document.getElementById('darkModeToggle').querySelector('.sun-icon').classList.add('hidden');
            document.getElementById('darkModeToggle').querySelector('.moon-icon').classList.remove('hidden');
        }

        // Listener para mudanças no tema do sistema
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (e.matches) {
                document.documentElement.classList.add('dark');
                document.getElementById('darkModeToggle').querySelector('.sun-icon').classList.add('hidden');
                document.getElementById('darkModeToggle').querySelector('.moon-icon').classList.remove('hidden');
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('darkModeToggle').querySelector('.sun-icon').classList.remove('hidden');
                document.getElementById('darkModeToggle').querySelector('.moon-icon').classList.add('hidden');
            }
        });
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@100..900&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Anton&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');

        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .dark .glass-effect {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-effect:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(0, 122, 51, 0.3);
        }

        .profile-image-container {
            position: relative;
            display: inline-block;

        }

        .profile-image-container::after {
            content: '';
            position: absolute;
            inset: -3px;
            border-radius: 50%;
            border: 6px solid #007A33;
            z-index: -1;
            opacity: 0.5;
        }

        .animate-status {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }
    </style>
</head>

<body class="bg-gradient-to-br from-custom-background to-white min-h-screen font-inter select-none dark:bg-gradient-to-br dark:from-dark-background dark:to-dark-background">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <nav class="glass-effect mb-12 rounded-2xl p-6 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h1 class="text-4xl font-bold text-custom-header flex items-center gap-4 dark:text-dark-header">
                    <i class="fas fa-user-circle"></i>
                    Meu Perfil
                </h1>
            </div>

            <button id="darkModeToggle"
                class="inline-flex items-center justify-center p-2 rounded-lg transition-colors 
           text-custom-header hover:bg-custom-header/10 
           dark:text-gray-200 dark:hover:bg-gray-700"
                role="switch"
                aria-label="Alternar modo escuro">
                <svg class="w-5 h-5 sun-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
                <svg class="w-5 h-5 moon-icon hidden" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <span class="sr-only">Alternar modo escuro</span>
            </button>


        </nav>

        <!-- Main Content -->
        <main class="max-w-5xl mx-auto">
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Profile Card -->
                <div class="md:col-span-1">
                    <div class="glass-effect rounded-3xl p-8 text-center">
                        <div class="profile-image-container mb-6">
                            <img src="https://api.dicebear.com/9.x/initials/svg?seed=JD"
                                alt="Foto de Perfil"
                                class="w-48 h-48 rounded-full border-4 border-white shadow-xl object-cover mx-auto" />
                        </div>
                        <h2 class="text-3xl font-bold mb-2 text-custom-header dark:text-dark-header"><?php echo $_SESSION['Nome'] ?></h2>
                        <p class="text-gray-600 mb-6 dark:text-gray-300"><?php echo $_SESSION['Email'] ?></p>
                        <div class="flex justify-center space-x-4">

                        </div>
                        <a href="../subsytem/subsistema.php" class="text-custom-header hover:text-custom-accent transition-all duration-300 transform hover:scale-110 dark:text-gray-200 dark:hover:text-white">
                            <i class="fas fa-arrow-left text-2xl"></i>
                        </a>

                    </div>
                </div>

                <!-- Info Cards -->
                <div class="md:col-span-2 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-white/95 backdrop-blur-md rounded-2xl p-6 profile-card dark:bg-dark-background/95">
                            <h3 class="text-xl font-semibold text-custom-header mb-4 dark:text-dark-header">Informações Pessoais</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-envelope text-custom-accent dark:text-dark-accent"></i>
                                    <p class="dark:text-gray-300"><span class="font-medium">Email: </span><?php echo $_SESSION['Email']; ?></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-clock text-custom-accent dark:text-dark-accent"></i>
                                    <p class="dark:text-gray-300"><span class="font-medium">Último Acesso:</span> 19/02/2025 14:30</p>
                                </div>
                                <button onclick="editEmail()"
                                    class="text-gray-400 hover:text-custom-accent transition-all duration-300 transform dark:hover:text-dark-accent">
                                    <i class="fas fa-edit text-lg"> </i> <span>Editar Email</span>
                                </button>
                            </div>
                        </div>

                        <div class="bg-white/95 backdrop-blur-md rounded-2xl p-6 profile-card dark:bg-dark-background/95">
                            <h3 class="text-xl font-semibold text-custom-header mb-4 dark:text-dark-header">Segurança</h3>
                            <div class="space-y-4">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-key text-custom-accent dark:text-dark-accent"></i>
                                    <p class="dark:text-gray-300"><span class="font-medium">Senha: </span><?php echo $_SESSION['Senha']; ?></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-history text-custom-accent dark:text-dark-accent"></i>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Última alteração: 19/02/2025</p>
                                </div>
                                <button onclick="editSenha()"
                                    class="text-gray-400 hover:text-custom-accent transition-all duration-300 transform dark:hover:text-dark-accent">
                                    <i class="fas fa-lock text-lg"></i><span class="mx-2">Editar Senha</span>
                                </button>
                            </div>
                        </div>
                    </div>


                    <!-- Status Card -->
                    <div class="glass-effect rounded-2xl p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <i class="fas fa-signal text-custom-header text-xl dark:text-dark-header"></i>
                                <h3 class="text-xl font-semibold text-custom-header dark:text-dark-header">Status</h3>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-block w-3 h-3 bg-custom-header rounded-full animate-status dark:bg-dark-header"></span>
                                <span class="font-medium text-custom-header dark:text-dark-header">Online</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- Email Modal -->
    <div id="emailModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center backdrop-blur-sm">
        <div class="glass-effect p-8 rounded-2xl w-full max-w-md mx-4">
            <div class="flex items-center gap-3 mb-6">
                <i class="fas fa-envelope text-custom-header text-2xl dark:text-dark-header"></i>
                <h3 class="text-2xl font-bold text-custom-header dark:text-dark-header">Editar Email</h3>
            </div>
            <form class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Novo Email</label>
                    <input type="email" name="new_email"
                        class="w-full p-3 rounded-xl bg-white/50 border border-custom-grid 
                               text-custom-text placeholder-gray-400 focus:ring-2 focus:ring-custom-accent 
                               focus:border-transparent outline-none transition-all duration-300 dark:bg-dark-background/50 dark:border-dark-grid dark:text-dark-text"
                        placeholder="Digite seu novo email" required>
                </div>
                <div class="flex justify-end gap-4">
                    <button type="button" onclick="closeEmailModal()"
                        class="px-6 py-2.5 rounded-xl bg-gray-100 text-custom-text 
                               hover:bg-gray-200 transition-all duration-300 dark:bg-dark-background/50 dark:text-dark-text">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-custom-header text-white 
                               hover:bg-opacity-90 transition-all duration-300 dark:bg-dark-header">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Senha Modal -->
    <div id="senhaModal" class="fixed inset-0 bg-black/70 hidden items-center justify-center backdrop-blur-sm">
        <div class="glass-effect p-8 rounded-2xl w-full max-w-md mx-4">
            <div class="flex items-center gap-3 mb-6">
                <i class="fas fa-lock text-custom-header text-2xl dark:text-dark-header"></i>
                <h3 class="text-2xl font-bold text-custom-header dark:text-dark-header">Alterar Senha</h3>
            </div>
            <form class="space-y-6" action="../../controllers/controller_perfil/controller_altSenha.php" method="POST">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Senha Atual</label>
                    <input type="password" name="Senha"
                        class="w-full p-3 rounded-xl bg-white/50 border border-custom-grid 
                               text-custom-text placeholder-gray-400 focus:ring-2 focus:ring-custom-accent 
                               focus:border-transparent outline-none transition-all duration-300 dark:bg-dark-background/50 dark:border-dark-grid dark:text-dark-text"
                        placeholder="Digite sua senha atual" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Nova Senha</label>
                    <input type="password" name="novaSenha"
                        class="w-full p-3 rounded-xl bg-white/50 border border-custom-grid 
                               text-custom-text placeholder-gray-400 focus:ring-2 focus:ring-custom-accent 
                               focus:border-transparent outline-none transition-all duration-300 dark:bg-dark-background/50 dark:border-dark-grid dark:text-dark-text"
                        placeholder="Digite sua nova senha" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2 dark:text-gray-300">Confirme a Nova Senha</label>
                    <input type="password" name="confSenha"
                        class="w-full p-3 rounded-xl bg-white/50 border border-custom-grid 
                               text-custom-text placeholder-gray-400 focus:ring-2 focus:ring-custom-accent 
                               focus:border-transparent outline-none transition-all duration-300 dark:bg-dark-background/50 dark:border-dark-grid dark:text-dark-text"
                        placeholder="Confirme sua nova senha" required>
                </div>
                <div class="flex justify-end gap-4">
                    <?php if (isset($_GET['erro'])) {
                    if ($_GET['erro'] == 1) {
                        echo '<script type="text/javascript">';
                        echo 'window.alert("As senhas não coincidem.");';
                        echo '</script>';
                    }
                }?>
                    <button type="button" onclick="closeSenhaModal()"
                        class="px-6 py-2.5 rounded-xl bg-gray-100 text-custom-text 
                               hover:bg-gray-200 transition-all duration-300 dark:bg-dark-background/50 dark:text-dark-text">
                        Cancelar
                    </button>
                    <button type="submit"
                        class="px-6 py-2.5 rounded-xl bg-custom-header text-white 
                               hover:bg-opacity-90 transition-all duration-300 dark:bg-dark-header">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editEmail() {
            document.getElementById('emailModal').style.display = 'flex';
        }

        function closeEmailModal() {
            document.getElementById('emailModal').style.display = 'none';
        }

        function editSenha() {
            document.getElementById('senhaModal').style.display = 'flex';
        }

        function closeSenhaModal() {
            document.getElementById('senhaModal').style.display = 'none';
        }

        // Close modals when clicking outside
        window.addEventListener('click', (e) => {
            const emailModal = document.getElementById('emailModal');
            const senhaModal = document.getElementById('senhaModal');

            if (e.target === emailModal) {
                closeEmailModal();
            }
            if (e.target === senhaModal) {
                closeSenhaModal();
            }
        });

        // Dark mode toggle
        const darkModeToggle = document.getElementById('darkModeToggle');
        const sunIcon = darkModeToggle.querySelector('.sun-icon');
        const moonIcon = darkModeToggle.querySelector('.moon-icon');

        darkModeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            sunIcon.classList.toggle('hidden');
            moonIcon.classList.toggle('hidden');
        });
    </script>
</body>

</html>