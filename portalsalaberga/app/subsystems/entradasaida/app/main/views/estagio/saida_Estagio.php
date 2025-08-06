<?php
require_once('../../model/select_model.php');
$select = new select_model;
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Saída Estágio - Salaberga</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-light-green': '#3CB371',
                        'ceara-olive': '#8CA03E',
                        'ceara-orange': '#FFA500',
                    }
                }
            }
        }
    </script>

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8fafc;
            min-height: 100vh;
        }

        .header {
            background: linear-gradient(90deg, #008C45, #3CB371);
        }

        .gradient-text {
            background: linear-gradient(45deg, #008C45, #3CB371);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .form-card {
            background: white;
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
        }

        .input-focus-ring:focus {
            box-shadow: 0 0 0 3px rgba(0, 140, 69, 0.1);
        }

        .btn-primary {
            background: linear-gradient(90deg, #008C45, #3CB371);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(90deg, #006d35, #2e8b57);
            transform: translateY(-1px);
            box-shadow: 0 6px 12px -2px rgba(0, 140, 69, 0.2);
        }

        .loading-spinner {
            border: 2px solid #f3f3f3;
            border-top: 2px solid #008C45;
            border-radius: 50%;
            width: 16px;
            height: 16px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .footer {
            background: white;
            border-top: 1px solid #e5e7eb;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 2px;
            background: linear-gradient(70deg, #008C45, #FFA500);
        }

        .icon-container {
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            background: rgba(0, 140, 69, 0.1);
            color: #008C45;
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .shake {
            animation: shake 0.5s ease-in-out;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .success-message {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="min-h-screen flex flex-col">
    <!-- Header -->
    <header class="header fixed top-0 left-0 right-0 h-16 flex items-center justify-between px-6 text-white shadow-md z-50">
        <div class="text-xl font-semibold">
            <i class="fas fa-graduation-cap mr-2"></i>
            Salaberga
        </div>
        <nav class="flex items-center gap-3">
            <a href="inicio.php" class="flex items-center gap-2 px-3 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors text-sm">
                <i class="fas fa-home"></i>
                <span>Menu</span>
            </a>
            <a href="saida_estagio_view.php" class="flex items-center gap-2 px-3 py-2 bg-white/10 rounded-lg hover:bg-white/20 transition-colors text-sm">
                <i class="fas fa-eye"></i>
                <span class="hidden sm:inline">Tempo Real</span>
                <span class="sm:hidden">Ver</span>
            </a>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-1 container mx-auto px-4 py-8 mt-16">
        <div class="max-w-lg mx-auto slide-in">
            <!-- Title Section -->
            <div class="text-center mb-8">
                <div class="icon-container mx-auto mb-4">
                    <i class="fas fa-briefcase text-2xl"></i>
                </div>
                <h1 class="text-3xl font-bold mb-2">
                    <span class="gradient-text">Registro de Saída Estágio</span>
                </h1>
                <p class="text-gray-600 text-sm">Registre a saída dos alunos para estágio</p>
            </div>

            <!-- Success Message -->
            <div id="successMessage" class="hidden mb-6 p-4 bg-green-50 border border-green-200 rounded-lg success-message">
                <div class="flex items-center">
                    <i class="fas fa-check-circle text-green-600 mr-3"></i>
                    <span class="text-green-700 font-medium">Saída registrada com sucesso!</span>
                </div>
            </div>

            <!-- Form Container -->
            <div class="form-card p-8 border-t-4 border-ceara-green">
                <form id="saida-estagio" action="../../control/control_index.php" method="POST" class="space-y-6">
                    
                    <!-- Aluno Selection -->
                    <div class="space-y-2">
                        <label for="id_aluno" class="block text-sm font-medium text-gray-700">
                            <i class="fas fa-user mr-2 text-ceara-green"></i>
                            Aluno
                        </label>
                        <select 
                            class="js-example-basic-single" name="id_aluno" required
                        >
                            <option value="" disabled selected>Selecione o aluno</option>
                            <?php
                            $dados = $select->select_alunosE();
                            foreach ($dados as $dado) {
                            ?>
                                <option value="<?=$dado['id_aluno']?>"><?=$dado['nome']?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <div id="aluno-error" class="hidden text-red-500 text-xs flex items-center mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i>
                            <span>Por favor, selecione um aluno</span>
                        </div>
                    </div>

                    <!-- Data e Hora Section -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-medium text-gray-700 flex items-center">
                            <i class="fas fa-calendar-alt mr-2 text-ceara-green"></i>
                            Data e Hora da Saída
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Data -->
                            <div class="space-y-2">
                                <label for="data" class="block text-xs font-medium text-gray-600">
                                    Data
                                </label>
                                <input 
                                    type="date" 
                                    id="data"
                                    name="data" 
                                    class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-ceara-green input-focus-ring outline-none transition-all duration-300 text-sm"
                                    required
                                >
                                <div id="data-error" class="hidden text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <span>Data é obrigatória</span>
                                </div>
                            </div>

                            <!-- Hora -->
                            <div class="space-y-2">
                                <label for="hora" class="block text-xs font-medium text-gray-600">
                                    Hora
                                </label>
                                <input 
                                    type="time" 
                                    id="hora"
                                    name="hora" 
                                    class="w-full p-3 border-2 border-gray-200 rounded-lg focus:border-ceara-green input-focus-ring outline-none transition-all duration-300 text-sm"
                                    required
                                >
                                <div id="hora-error" class="hidden text-red-500 text-xs flex items-center mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    <span>Hora é obrigatória</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="submitBtn"
                        name="Registrar"
                        class="w-full btn-primary text-white font-medium py-4 px-6 rounded-lg focus:outline-none focus:ring-4 focus:ring-green-200 disabled:opacity-50 disabled:cursor-not-allowed text-sm"
                    >
                        <span id="submitText" class="flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i>
                            Registrar Saída
                        </span>
                        <span id="submitLoading" class="hidden flex items-center justify-center gap-2">
                            <div class="loading-spinner"></div>
                            Registrando...
                        </span>
                    </button>
                </form>

                <!-- Back Links -->
                <div class="flex flex-col sm:flex-row gap-3 mt-6 text-center">
                    <a href="../../views/inicio.php" class="flex-1 inline-flex items-center justify-center gap-2 text-ceara-green hover:text-ceara-light-green font-medium transition-colors duration-300 text-sm">
                        <i class="fas fa-arrow-left text-sm"></i>
                        Voltar ao Menu
                    </a>
                    <a href="saida_estagio_view.php" class="flex-1 inline-flex items-center justify-center gap-2 text-blue-600 hover:text-blue-700 font-medium transition-colors duration-300 text-sm">
                        <i class="fas fa-eye text-sm"></i>
                        Ver em Tempo Real
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer relative py-4 text-center text-gray-600 text-xs">
        <div class="container mx-auto">
            <p>© 2025 Sistema Escolar Salaberga. Todos os direitos reservados.</p>
        </div>
    </footer>

    <script>
        $(document).ready(function() {
    $('.js-example-basic-single').select2();
});

        class SaidaEstagioForm {
            constructor() {
                this.form = document.getElementById('saida-estagio');
                this.fields = {
                    aluno: document.getElementById('id_aluno'),
                    data: document.getElementById('data'),
                    hora: document.getElementById('hora')
                };
                this.submitBtn = document.getElementById('submitBtn');
                this.init();
            }

            init() {
                // Set current date and time as default
                this.setCurrentDateTime();

                // Add event listeners for validation
                Object.keys(this.fields).forEach(fieldName => {
                    const field = this.fields[fieldName];
                    field.addEventListener('change', () => this.validateField(fieldName));
                    field.addEventListener('blur', () => this.validateField(fieldName));
                });

                // Form submission
                this.form.addEventListener('submit', (e) => this.handleSubmit(e));

                // Add visual feedback on field changes
                Object.values(this.fields).forEach(field => {
                    field.addEventListener('change', () => {
                        if (field.value) {
                            field.classList.add('border-green-500');
                            field.classList.remove('border-gray-200');
                        } else {
                            field.classList.remove('border-green-500');
                            field.classList.add('border-gray-200');
                        }
                    });
                });
            }

            setCurrentDateTime() {
                const now = new Date();
                const today = now.toISOString().split('T')[0];
                const currentTime = now.toTimeString().slice(0, 5);
                
                this.fields.data.value = today;
                this.fields.hora.value = currentTime;
                
                // Trigger change events to update visual feedback
                this.fields.data.dispatchEvent(new Event('change'));
                this.fields.hora.dispatchEvent(new Event('change'));
            }

            validateField(fieldName) {
                const field = this.fields[fieldName];
                const errorElement = document.getElementById(`${fieldName}-error`);
                
                if (!field.value) {
                    if (errorElement) {
                        errorElement.classList.remove('hidden');
                    }
                    return false;
                } else {
                    if (errorElement) {
                        errorElement.classList.add('hidden');
                    }
                    return true;
                }
            }

            validateForm() {
                let isValid = true;
                Object.keys(this.fields).forEach(fieldName => {
                    if (!this.validateField(fieldName)) {
                        isValid = false;
                    }
                });
                return isValid;
            }

            handleSubmit(e) {
                if (!this.validateForm()) {
                    e.preventDefault();
                    
                    // Shake effect for invalid form
                    const container = document.querySelector('.form-card');
                    container.classList.add('shake');
                    
                    setTimeout(() => {
                        container.classList.remove('shake');
                    }, 500);
                    
                    return;
                }

                // Show loading state
                this.showLoadingState();
            }

            showLoadingState() {
                const submitText = document.getElementById('submitText');
                const submitLoading = document.getElementById('submitLoading');
                
                submitText.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                this.submitBtn.disabled = true;
            }

            showSuccessState() {
                const successMessage = document.getElementById('successMessage');
                const container = document.querySelector('.form-card');
                
                // Reset button state
                const submitText = document.getElementById('submitText');
                const submitLoading = document.getElementById('submitLoading');
                submitText.classList.remove('hidden');
                submitLoading.classList.add('hidden');
                this.submitBtn.disabled = false;

                // Show success message
                successMessage.classList.remove('hidden');
                
                // Reset form
                this.form.reset();
                this.setCurrentDateTime();
                
                // Remove visual feedback
                Object.values(this.fields).forEach(field => {
                    field.classList.remove('border-green-500');
                    field.classList.add('border-gray-200');
                });

                // Hide success message after 5 seconds
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                }, 5000);
            }
        }

        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new SaidaEstagioForm();
        });

        // Handle URL parameters for success messages
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === 'true') {
            document.addEventListener('DOMContentLoaded', () => {
                document.getElementById('successMessage').classList.remove('hidden');
            });
        }
    </script>
</body>
</html>