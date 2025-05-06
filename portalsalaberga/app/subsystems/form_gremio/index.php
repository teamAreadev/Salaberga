<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Copa Grêmio 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="shortcut icon" href="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" type="image/svg">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

    :root {
        --primary-500: #007d40;
        --primary-600: #006a36;
        --primary-700: #005A24;
    }

    body {
        font-family: 'Poppins', sans-serif;
        background-color: #f8fafc;
    }

    .gradient-header {
        background: linear-gradient(135deg, var(--primary-700) 0%, var(--primary-500) 100%);
    }

    .gradient-btn {
        background: linear-gradient(to right, var(--primary-600), var(--primary-500));
        transition: all 0.3s ease;
    }

    .gradient-btn:hover {
        background: linear-gradient(to right, var(--primary-700), var(--primary-600));
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 90, 36, 0.3);
    }

    .input-focus {
        transition: all 0.3s ease;
    }

    .input-focus:focus {
        border-color: #d1d5db; /* border-gray-300 */
        box-shadow: none;
        outline: none;
    }

    .card {
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .card:hover {
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .toast {
        animation: toastIn 0.3s ease-out forwards;
    }

    @keyframes toastIn {
        from { transform: translateY(100px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    .toast-out {
        animation: toastOut 0.3s ease-in forwards;
    }

    @keyframes toastOut {
        from { transform: translateY(0); opacity: 1; }
        to { transform: translateY(100px); opacity: 0; }
    }

    .dropdown-enter {
        animation: dropdownOpen 0.2s ease-out forwards;
    }

    @keyframes dropdownOpen {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    select {
        height: 48px;
        line-height: 1.5;
        background-color: #fff;
        cursor: pointer;
        border-color: #d1d5db; /* border-gray-300 */
    }

    select:focus {
        border-color: #d1d5db; /* border-gray-300 */
        box-shadow: none;
        outline: none;
    }

    .select-icon {
        top: 50%;
        transform: translateY(-50%);
    }

    select::-ms-expand {
        display: none;
    }

    select option {
        font-size: 0.875rem;
        color: #1f2937;
    }
</style>
</head>
<body class="min-h-screen flex flex-col bg-gray-50">
    <!-- Header -->
<!-- Header -->
<header class="gradient-header text-white shadow-lg sticky top-0 z-50">
    <div class="container mx-auto px-4 py-3">
        <div class="flex justify-between items-center">
            <!-- Logo and Branding -->
            <div class="flex items-center space-x-3">
                <div class="p-1  rounded-full shadow-md">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/Design%20sem%20nome-MOpK2hbpuoqfoF8sir0Ue6SvciAArc.svg" 
                         alt="Logo Copa Grêmio" 
                         class="h-10 w-10" loading="lazy">
                </div>
                <div>
                    <h1 class="text-xl md:text-2xl font-bold tracking-tight">Copa Grêmio 2025</h1>
                    <p class="text-green-100 text-xs md:text-sm opacity-90">Grêmio Estudantil José Ivan Pontes Júnior</p>
                </div>
            </div>
            
            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6">
                <div class="relative group">
                    <button id="loginDropdown" class="flex items-center space-x-2 text-white hover:text-green-200 transition-colors px-3 py-2 rounded-lg hover:bg-white/10">
                        <i class="fas fa-sign-in-alt text-lg"></i>
                        <span class="font-medium">Login</span>
                        <i class="fas fa-chevron-down text-xs transition-transform duration-200 transform group-hover:rotate-180"></i>
                    </button>
                    <div class="absolute right-0 mt-1 w-48 bg-white rounded-md shadow-xl z-50 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 origin-top-right transform scale-95 group-hover:scale-100 border border-green-100">
                        <a href="usuario/login.php" class="block px-4 py-2.5 text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center transition-colors border-b border-gray-100">
                            <i class="fas fa-user mr-3 text-green-600"></i>Usuário
                        </a>
                        <a href="admin/login.php" class="block px-4 py-2.5 text-gray-700 hover:bg-green-50 hover:text-green-700 flex items-center transition-colors">
                            <i class="fas fa-lock mr-3 text-green-600"></i>Administrador
                        </a>
                    </div>
                </div>
            </nav>
            
            <!-- Mobile Menu Button -->
            <button id="mobile-menu-btn" class="md:hidden text-white p-2 focus:outline-none hover:bg-white/10 rounded-lg transition-colors">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>
    </div>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden md:hidden bg-green-800/95 backdrop-blur-sm">
        <div class="container mx-auto px-4 py-2">
            <div class="flex flex-col space-y-1">
                <button id="mobile-loginDropdown" class="flex items-center justify-between w-full text-white px-3 py-3 rounded-lg hover:bg-white/10 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-sign-in-alt mr-3 text-lg"></i>
                        <span class="font-medium">Login</span>
                    </div>
                    <i class="fas fa-chevron-down text-xs transition-transform duration-200"></i>
                </button>
                <div id="mobile-loginOptions" class="hidden pl-11 space-y-1">
                    <a href="usuario/login.php" class="block px-3 py-2.5 text-green-200 hover:text-white hover:bg-white/10 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-user mr-3 text-green-300"></i> Usuário
                    </a>
                    <a href="admin/login.php" class="block px-3 py-2.5 text-green-200 hover:text-white hover:bg-white/10 rounded-lg flex items-center transition-colors">
                        <i class="fas fa-lock mr-3 text-green-300"></i> Administrador
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 py-8">
        <!-- Welcome Card -->
       

       <!-- Registration Form -->
       <div class="card bg-white rounded-xl p-6 md:p-8 shadow-sm animate-fade-in" style="animation-delay: 0.1s">
    <h3 class="text-xl md:text-2xl font-semibold text-gray-800 mb-6 flex items-center">
        <i class="fas fa-user-plus text-green-600 mr-3"></i>
        <span>Cadastro de Usuário</span>
    </h3>
    
    <form id="cadastroForm" method="post" novalidate>
        <input type="hidden" name="action" value="cadastrar">
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Nome Completo -->
            <div class="col-span-2">
                <label for="nome" class="block text-sm font-medium text-gray-700 mb-1">Nome Completo *</label>
                <div class="relative">
                    <input type="text" id="nome" name="nome" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus"
                           placeholder="Digite seu nome completo">
                    <i class="fas fa-user absolute right-3 top-3 text-gray-400"></i>
                </div>
                <p id="nome-error" class="text-red-500 text-xs mt-1 hidden">Por favor, insira seu nome completo.</p>
            </div>
            
            <!-- Email -->
            <div class="col-span-2 md:col-span-1">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">E-mail *</label>
                <div class="relative">
                    <input type="email" id="email" name="email" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus"
                           placeholder="Digite seu e-mail">
                    <i class="fas fa-envelope absolute right-3 top-3 text-gray-400"></i>
                </div>
                <p id="email-error" class="text-red-500 text-xs mt-1 hidden">Por favor, insira um e-mail válido.</p>
            </div>
            
            <!-- Telefone -->
            <div class="col-span-2 md:col-span-1">
                <label for="telefone" class="block text-sm font-medium text-gray-700 mb-1">Telefone *</label>
                <div class="relative">
                    <input type="tel" id="telefone" name="telefone" required 
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus"
                           placeholder="(00) 00000-0000">
                    <i class="fas fa-phone-alt absolute right-3 top-3 text-gray-400"></i>
                </div>
                <p id="telefone-error" class="text-red-500 text-xs mt-1 hidden">Por favor, insira um telefone válido.</p>
            </div>
            
            <!-- Ano -->
            <div class="col-span-2 md:col-span-1">
                <label for="ano" class="block text-sm font-medium text-gray-700 mb-1">Ano *</label>
                <div class="relative">
                    <select id="ano" name="ano" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus appearance-none">
                        <option value="">Selecione o ano</option>
                        <option value="1">1º ano</option>
                        <option value="2">2º ano</option>
                        <option value="3">3º ano</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 select-icon text-gray-400 pointer-events-none"></i>
                </div>
                <p id="ano-error" class="text-red-500 text-xs mt-1 hidden">Por favor, selecione o ano.</p>
            </div>
            
            <!-- Turma -->
            <div class="col-span-2 md:col-span-1">
                <label for="turma" class="block text-sm font-medium text-gray-700 mb-1">Turma *</label>
                <div class="relative">
                    <select id="turma" name="turma" required 
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg input-focus appearance-none">
                        <option value="">Selecione a turma</option>
                        <option value="A">Turma A</option>
                        <option value="B">Turma B</option>
                        <option value="C">Turma C</option>
                        <option value="D">Turma D</option>
                    </select>
                    <i class="fas fa-chevron-down absolute right-3 select-icon text-gray-400 pointer-events-none"></i>
                </div>
                <p id="turma-error" class="text-red-500 text-xs mt-1 hidden">Por favor, selecione a turma.</p>
            </div>
        </div>
        
        <!-- Form Footer -->
        <div class="mt-8 pt-6 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
            <button type="submit" id="submitBtn" 
                    class="gradient-btn text-white font-semibold py-3 px-8 rounded-lg w-full sm:w-auto flex items-center justify-center">
                <span id="submitText">Cadastrar</span>
                <i id="submitSpinner" class="fas fa-spinner fa-spin ml-2 hidden"></i>
            </button>
        </div>
    </form>
</div>
    </main>

  

    <!-- Toast Notification -->
    <div id="toast" class="fixed bottom-6 right-6 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg z-50 hidden flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <span id="toastMessage"></span>
    </div>

    <script>
        // Mobile Menu Toggle
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
            
            // Toggle mobile login dropdown state
            const loginOptions = document.getElementById('mobile-loginOptions');
            if (!menu.classList.contains('hidden')) {
                loginOptions.classList.add('hidden');
                document.getElementById('mobile-loginDropdown').setAttribute('aria-expanded', 'false');
            }
        });

        // Mobile Login Dropdown Toggle
        document.getElementById('mobile-loginDropdown').addEventListener('click', function(e) {
            e.stopPropagation();
            const options = document.getElementById('mobile-loginOptions');
            const isExpanded = options.classList.toggle('hidden');
            this.setAttribute('aria-expanded', isExpanded ? 'false' : 'true');
            
            // Rotate chevron icon
            const icon = this.querySelector('i.fa-chevron-down');
            icon.classList.toggle('transform');
            icon.classList.toggle('rotate-180');
        });

        // Phone Number Mask
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length > 11) {
                value = value.substring(0, 11);
            }
            
            if (value.length > 2) {
                value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
            }
            if (value.length > 10) {
                value = `${value.substring(0, 10)}-${value.substring(10)}`;
            }
            
            e.target.value = value;
        });

        // Form Validation
        const form = document.getElementById('cadastroForm');
        const fields = ['nome', 'email', 'telefone', 'ano', 'turma'];
        
        // Add real-time validation
        fields.forEach(field => {
            const input = document.getElementById(field);
            const error = document.getElementById(`${field}-error`);
            
            input.addEventListener('blur', function() {
                validateField(field);
            });
            
            input.addEventListener('input', function() {
                if (this.classList.contains('border-red-500')) {
                    this.classList.remove('border-red-500');
                    error.classList.add('hidden');
                }
            });
        });
        
        function validateField(fieldId) {
            const field = document.getElementById(fieldId);
            const value = field.value.trim();
            const error = document.getElementById(`${fieldId}-error`);
            let isValid = true;
            
            switch(fieldId) {
                case 'nome':
                    isValid = value.length >= 3;
                    if (!isValid) error.textContent = 'O nome deve ter pelo menos 3 caracteres';
                    break;
                case 'email':
                    isValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value);
                    if (!isValid) error.textContent = 'Por favor, insira um e-mail válido';
                    break;
                case 'telefone':
                    const digits = value.replace(/\D/g, '');
                    isValid = digits.length >= 10;
                    if (!isValid) error.textContent = 'O telefone deve ter pelo menos 10 dígitos';
                    break;
                case 'ano':
                case 'turma':
                    isValid = value !== '';
                    if (!isValid) error.textContent = `Por favor, selecione ${fieldId === 'ano' ? 'o ano' : 'a turma'}`;
                    break;
            }
            
            if (!isValid) {
                field.classList.add('border-red-500');
                error.classList.remove('hidden');
                return false;
            }
            
            field.classList.remove('border-red-500');
            error.classList.add('hidden');
            return true;
        }
        
        // Form Submission
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            // Validate all fields
            let isValid = true;
            fields.forEach(field => {
                if (!validateField(field)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                showToast('Por favor, corrija os erros no formulário', 'error');
                return;
            }
            
            // Show loading state
            const submitBtn = document.getElementById('submitBtn');
            const submitText = document.getElementById('submitText');
            const submitSpinner = document.getElementById('submitSpinner');
            
            submitBtn.disabled = true;
            submitText.textContent = 'Cadastrando...';
            submitSpinner.classList.remove('hidden');
            
            try {
                const formData = new FormData(form);
                
                // Garante que o campo action seja incluído
                formData.set('action', 'cadastrar');
                
                // Log para depuração
                console.log('Enviando dados:');
                for (let pair of formData.entries()) {
                    console.log(pair[0] + ': ' + pair[1]);
                }
                
                // Use um caminho absoluto para o controlador
                const controllerPath = window.location.pathname.substring(0, window.location.pathname.lastIndexOf('/') + 1) + 'controllers/UsuarioController.php';
                console.log('Enviando para:', controllerPath);
                
                const response = await fetch(controllerPath, {
                    method: 'POST',
                    body: formData
                });
                
                console.log('Status da resposta:', response.status);
                
                // Tentar obter a resposta como texto primeiro para depuração
                const responseText = await response.text();
                console.log('Resposta do servidor (texto):', responseText);
                
                // Tentar extrair apenas o JSON da resposta
                let jsonStr = responseText;
                const jsonStart = responseText.indexOf('{');
                const jsonEnd = responseText.lastIndexOf('}');
                
                if (jsonStart >= 0 && jsonEnd >= 0) {
                    // Extrair apenas a parte JSON da resposta
                    jsonStr = responseText.substring(jsonStart, jsonEnd + 1);
                }
                
                // Tentar parsear como JSON
                let data;
                try {
                    data = JSON.parse(jsonStr);
                    console.log('Resposta do servidor (JSON):', data);
                } catch (jsonError) {
                    console.error('Erro ao parsear JSON:', jsonError);
                    throw new Error('Resposta inválida do servidor: ' + responseText);
                }
                
                if (data.success) {
                    // Show success message
                    Swal.fire({
                        title: 'Cadastro realizado com sucesso!',
                        text: 'Agora você pode fazer login para gerenciar suas inscrições.',
                        icon: 'success',
                        confirmButtonText: 'Ir para o login',
                        confirmButtonColor: '#005A24',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'usuario/login.php';
                        }
                    });
                } else {
                    // Show error message
                    Swal.fire({
                        title: 'Erro no cadastro',
                        text: data.message || 'Ocorreu um erro ao processar seu cadastro.',
                        icon: 'error',
                        confirmButtonColor: '#005A24'
                    });
                }
            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Erro de conexão',
                    text: 'Não foi possível conectar ao servidor. Tente novamente mais tarde.',
                    icon: 'error',
                    confirmButtonColor: '#005A24'
                });
            } finally {
                // Reset button state
                submitBtn.disabled = false;
                submitText.textContent = 'Cadastrar';
                submitSpinner.classList.add('hidden');
            }
        });
        
        // Toast Notification
        function showToast(message, type = 'success') {
            const toast = document.getElementById('toast');
            const toastMessage = document.getElementById('toastMessage');
            
            // Set style based on type
            if (type === 'error') {
                toast.classList.remove('bg-green-600');
                toast.classList.add('bg-red-600');
            } else {
                toast.classList.remove('bg-red-600');
                toast.classList.add('bg-green-600');
            }
            
            toastMessage.textContent = message;
            toast.classList.remove('hidden');
            
            // Auto-hide after 3 seconds
            setTimeout(() => {
                toast.classList.add('hidden');
            }, 3000);
        }
        
        // Initialize animations
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to form elements
            const inputs = document.querySelectorAll('input, select');
            inputs.forEach((input, index) => {
                input.style.animationDelay = `${index * 0.05}s`;
                input.classList.add('animate-fade-in');
            });
        });
    </script>
</body>
</html>