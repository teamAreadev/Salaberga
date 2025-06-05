<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleção Área Dev</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#007A33',
                        secondary: '#FFA500',
                        success: '#10B981',
                        danger: '#EF4444',
                        warning: '#F59E0B',
                        info: '#3B82F6'
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #374151 0%, #1f2937 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 80%, rgba(0, 122, 51, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 165, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(59, 130, 246, 0.05) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .floating-shape {
            position: absolute;
            border-radius: 50%;
            opacity: 0.1;
            animation: float 6s ease-in-out infinite;
        }

        .floating-shape:nth-child(1) {
            width: 120px;
            height: 120px;
            background: #007A33;
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-shape:nth-child(2) {
            width: 80px;
            height: 80px;
            background: #FFA500;
            top: 20%;
            right: 15%;
            animation-delay: 2s;
        }

        .floating-shape:nth-child(3) {
            width: 100px;
            height: 100px;
            background: #3B82F6;
            bottom: 15%;
            left: 20%;
            animation-delay: 4s;
        }

        .floating-shape:nth-child(4) {
            width: 60px;
            height: 60px;
            background: #10B981;
            bottom: 25%;
            right: 25%;
            animation-delay: 1s;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            33% { transform: translateY(-20px) rotate(120deg); }
            66% { transform: translateY(10px) rotate(240deg); }
        }

        .form-container {
            background: rgba(75, 85, 99, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(156, 163, 175, 0.2);
            border-radius: 20px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 500px;
            width: 100%;
            position: relative;
            z-index: 10;
        }

        .title {
            color: #10B981;
            font-size: 2.5rem;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            position: relative;
        }

        .title::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #007A33, #FFA500);
            border-radius: 2px;
        }

        .subtitle {
            color: #d1d5db;
            text-align: center;
            margin-bottom: 30px;
            font-size: 1rem;
        }

        .field-label {
            color: #f3f4f6;
            font-weight: 600;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .field-label::before {
            content: '';
            width: 8px;
            height: 8px;
            background: #007A33;
            border-radius: 50%;
            margin-right: 8px;
        }

        .input-field {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid #6b7280;
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: #4b5563;
            color: #f9fafb;
        }

        .input-field:focus {
            outline: none;
            border-color: #007A33;
            background: #374151;
            box-shadow: 0 0 0 4px rgba(0, 122, 51, 0.2);
        }

        .input-field::placeholder {
            color: #9ca3af;
        }

        .options-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-top: 12px;
        }

        .option-item {
            position: relative;
        }

        .option-input {
            display: none;
        }

        .option-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 16px 8px;
            border: 2px solid #6b7280;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #4b5563;
            text-align: center;
            color: #f3f4f6;
        }

        .option-label:hover {
            border-color: #007A33;
            background: #374151;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 122, 51, 0.25);
        }

        .option-input:checked + .option-label {
            border-color: #007A33;
            background: #007A33;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 122, 51, 0.4);
        }

        .option-icon {
            font-size: 1.5rem;
            margin-bottom: 4px;
        }

        .option-text {
            font-size: 0.85rem;
            font-weight: 500;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #007A33, #10B981);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 24px;
            position: relative;
            overflow: hidden;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 122, 51, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .result-message {
            margin-top: 20px;
            padding: 16px;
            border-radius: 12px;
            text-align: center;
            font-weight: 500;
            display: none;
            animation: slideIn 0.5s ease;
        }

        .result-message.success {
            background: rgba(16, 185, 129, 0.1);
            color: #10B981;
            border: 2px solid #10b981;
        }

        .result-message.error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 2px solid #ef4444;
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

        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
            margin-right: 8px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .fade-in {
            animation: fadeIn 0.5s ease forwards;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @media (max-width: 640px) {
            .form-container {
                padding: 30px 20px;
                margin: 20px;
            }
            
            .title {
                font-size: 2rem;
            }
            
            .options-container {
                grid-template-columns: 1fr;
                gap: 8px;
            }
            
            .option-label {
                flex-direction: row;
                justify-content: center;
                padding: 12px;
            }
            
            .option-icon {
                margin-bottom: 0;
                margin-right: 8px;
            }
        }
    </style>
</head>
<body>
    <!-- Floating Shapes -->
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>
    <div class="floating-shape"></div>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="form-container fade-in">
            <h1 class="title">Seleção Área Dev</h1>
            <p class="subtitle">Escolha sua área de especialização</p>
            
            <form id="devForm">
                <div style="margin-bottom: 24px;">
                    <label class="field-label">Nome Completo</label>
                    <input 
                        type="text" 
                        id="nome" 
                        name="nome" 
                        class="input-field"
                        placeholder="Digite seu nome completo"
                        required
                    >
                </div>
                
                <div style="margin-bottom: 24px;">
                    <label class="field-label">Área de Especialização</label>
                    <div class="options-container">
                        <div class="option-item">
                            <input type="radio" id="backend" name="funcao" value="Back-end" class="option-input" required>
                            <label for="backend" class="option-label">
                                <span class="option-icon">⚙️</span>
                                <span class="option-text">Back-end</span>
                            </label>
                        </div>
                        <div class="option-item">
                            <input type="radio" id="frontend" name="funcao" value="Front-end" class="option-input">
                            <label for="frontend" class="option-label">
                                <span class="option-icon">🎨</span>
                                <span class="option-text">Front-end</span>
                            </label>
                        </div>
                        <div class="option-item">
                            <input type="radio" id="design" name="funcao" value="Design" class="option-input">
                            <label for="design" class="option-label">
                                <span class="option-icon">✨</span>
                                <span class="option-text">Design</span>
                            </label>
                        </div>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn" id="submitBtn">
                    <span id="btnText">Enviar Inscrição</span>
                    <span id="btnLoading" style="display: none;">
                        <span class="loading"></span>
                        Processando...
                    </span>
                </button>
            </form>
            
            <div id="resultMessage" class="result-message"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('devForm');
            const resultMessage = document.getElementById('resultMessage');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const btnLoading = document.getElementById('btnLoading');
            const nomeInput = document.getElementById('nome');

            // Validação em tempo real
            nomeInput.addEventListener('input', function() {
                if (this.value.trim().length > 0 && this.value.trim().length < 2) {
                    this.style.borderColor = '#ef4444';
                } else {
                    this.style.borderColor = '#6b7280';
                }
            });

            // Efeitos visuais nas opções
            const radioInputs = document.querySelectorAll('input[name="funcao"]');
            radioInputs.forEach(input => {
                input.addEventListener('change', function() {
                    // Remover efeito de todas as labels
                    document.querySelectorAll('.option-label').forEach(label => {
                        label.style.transform = '';
                    });
                    
                    // Adicionar efeito na label selecionada
                    if (this.checked) {
                        const label = document.querySelector(`label[for="${this.id}"]`);
                        label.style.transform = 'translateY(-2px) scale(1.05)';
                        setTimeout(() => {
                            label.style.transform = 'translateY(-2px)';
                        }, 200);
                    }
                });
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                
                // Mostrar loading
                btnText.style.display = 'none';
                btnLoading.style.display = 'inline-flex';
                submitBtn.disabled = true;
                
                // Simular processamento
                setTimeout(() => {
                    const nome = document.getElementById('nome').value.trim();
                    const funcaoSelecionada = document.querySelector('input[name="funcao"]:checked');
                    
                    if (!nome || nome.length < 2) {
                        showResult('Por favor, digite um nome válido com pelo menos 2 caracteres.', 'error');
                        resetButton();
                        return;
                    }
                    
                    if (!funcaoSelecionada) {
                        showResult('Por favor, selecione uma área de especialização.', 'error');
                        resetButton();
                        return;
                    }
                    
                    // Sucesso
                    showResult(`
                        <div style="text-align: center;">
                            <div style="font-size: 2rem; margin-bottom: 8px;">🎉</div>
                            <div style="font-weight: 600; margin-bottom: 8px;">Inscrição realizada com sucesso!</div>
                            <div><strong>Nome:</strong> ${nome}</div>
                            <div><strong>Área:</strong> ${funcaoSelecionada.value}</div>
                        </div>
                    `, 'success');
                    
                    // Limpar formulário após 3 segundos
                    setTimeout(() => {
                        form.reset();
                        hideResult();
                    }, 3000);
                    
                    resetButton();
                }, 1500);
            });
            
            function showResult(message, type) {
                resultMessage.innerHTML = message;
                resultMessage.className = `result-message ${type}`;
                resultMessage.style.display = 'block';
            }
            
            function hideResult() {
                resultMessage.style.display = 'none';
            }
            
            function resetButton() {
                btnText.style.display = 'inline';
                btnLoading.style.display = 'none';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>