<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil | EEEP Salaberg</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="../../assets/img/Design sem nome.svg" type="image/x-icon">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, rgba(255, 165, 0, 0.1) 0%, rgba(0, 140, 69, 0.2) 100%);
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 140, 69, 0.15);
        }

        .profile-header {
            background: linear-gradient(90deg, #008C45 0%, #FFA500 100%);
        }

        /* Botões e controles atualizados */
        .action-button {
            background: #008C45;
            color: white;
            padding: 12px 16px;
            /* Padding padrão */
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 15px rgba(0, 140, 69, 0.2);
        }

        .action-button:hover {
            background: #006633;
            transform: translateY(-2px);
        }

        .photo-control {
            background: #008C45;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .photo-control:hover {
            background: #006633;
            transform: scale(1.1);
        }

        /* Navegação e tabs */
        .tab-link {
            color: #008C45;
            border-color: #008C45;
        }

        .tab-link:hover {
            color: #006633;
            border-color: #006633;
        }

        /* Modal updates */
        .modal-content {
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(0, 140, 69, 0.25);
        }

        /* Animações */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }

        /* Responsividade melhorada */
        @media (max-width: 640px) {
            .profile-header {
                padding: 20px;
            }

            .action-button {
                padding: 8px 12px;
                /* Padding reduzido para dispositivos móveis */
                font-size: 14px;
                /* Tamanho de fonte reduzido */
                margin-bottom: 8px;
                width: auto;
                /* Remover largura total para botões menores */
            }

            .photo-control {
                width: 36px;
                height: 36px;
            }
        }

        /* Tooltips melhorados */
        .tooltip:before {
            background: rgba(0, 140, 69, 0.95);
            font-weight: 500;
            padding: 8px 12px;
            font-size: 13px;
            border-radius: 6px;
        }

        #logoutBtn {
            background: #dc3545;
        }

        #logoutBtn:hover {
            background: #c82333;
        }

        .photo-control {
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 8px;
            border-radius: 50%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
        }

        .photo-control:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        /* Adicionar animação de fade para o preview da imagem */
        #profileIcon {
            transition: all 0.3s ease;
        }

        /* Estilo para o tooltip */
        .tooltip {
            position: relative;
        }

        .tooltip:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%);
            padding: 4px 8px;
            background: rgba(0, 0, 0, 0.8);
            color: white;
            font-size: 12px;
            border-radius: 4px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .tooltip:hover:before {
            opacity: 1;
            visibility: visible;
        }

        .modal {
            animation: fadeIn 0.3s ease-out;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            animation: slideIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .modal input {
            transition: all 0.3s ease;
        }

        .modal input:focus {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .modal button {
            transition: all 0.2s ease;
        }

        .modal button:hover {
            transform: translateY(-1px);
        }

        .modal button:active {
            transform: translateY(0px);
        }

        .photo-control {
            background: rgba(255, 255, 255, 0.9);
            padding: 8px;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .photo-control:hover {
            background: white;
            transform: scale(1.1);
        }

        #photoControlsHub {
            min-width: 160px;
            z-index: 10;
        }


        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            background-color: rgba(255, 255, 255, 0.8);
            color: #005A24;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .back-button:hover {
            background-color: #005a24c7;
            color: white;
            transform: scale(1.1);
        }

        .back-button:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.5);
        }
    </style>
</head>

<body class="fade-in">
    <a aria-label='Voltar para a página inicial' class='back-button' href="javascript:history.back()">
        <i class="fas fa-arrow-left"></i>
    </a>

    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="glass-effect w-full max-w-4xl animate-fadeIn">
            <div
                class="profile-header text-white p-6 md:p-10 text-center md:text-left md:flex md:items-center md:justify-between rounded-t-2xl">
                <div class="md:flex md:items-center">
                    <div class="relative">
                        <!-- Imagem de Perfil -->
                        <img id="profileIcon" src="https://via.placeholder.com/80" alt="Profile Icon"
                            class="w-24 h-24 rounded-full profile-icon mx-auto md:mx-0 mb-4 md:mb-0 md:mr-6 border-4 border-white">

                        <!-- Botão para abrir o hub de controles -->
                        <button id="controlsToggle"
                            class="absolute bottom-0 right-4 bg-gray-800 text-white hover:bg-gray-700 rounded-full w-8 h-8 flex items-center justify-center">

                            <i class="fas fa-ellipsis-h"></i>
                        </button>

                        <!-- Hub de controles (inicialmente oculto) -->
                        <div id="photoControlsHub"
                            class="hidden absolute bottom-12 right-0 bg-white rounded-lg shadow-lg p-2 border">
                            <div class="flex flex-col space-y-2">
                                <label for="profilePicture"
                                    class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded cursor-pointer">
                                    <i class="fas fa-camera text-gray-600"></i>
                                    <span class="text-black">Adicionar foto</span>
                                </label>
                                <button id="takePictureBtn"
                                    class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded">
                                    <i class="fas fa-video text-gray-600 "></i>
                                    <span class="text-black">Tirar foto</span>
                                </button>
                                <button id="deletePhotoBtn"
                                    class="flex items-center space-x-2 p-2 hover:bg-gray-100 rounded">
                                    <i class="fas fa-trash text-gray-600"></i>
                                    <span class="text-black">Remover foto</span>
                                </button>
                            </div>
                        </div>

                        <!-- Input file oculto -->
                        <input type="file" id="profilePicture" class="hidden" accept="image/png, image/jpeg, image/gif"
                            capture="user">
                    </div>

                    <div>
                        <h2 class="text-3xl md:text-3xl font-bold mb-2" id="nomeDisplay">
                            <?php echo $_SESSION['Nome']; ?></h2>
                        <?php if (isset($_SESSION['Tipo']) && $_SESSION['Tipo'] == 'aluno') { ?>
                            <p class="text-sm md:text-base opacity-75">Aluno da EEEP Salaberga</p>
                        <?php } else { ?>
                            <p class="text-sm md:text-base opacity-75">Professor da EEEP Salaberga</p>
                        <?php } ?>
                    </div>
                </div>
                <?php if (isset($_SESSION['Telefone'])){ ?>
                <button id="editProfileBtn" class="action-button">
                    <i class="fas fa-edit"></i> Alterar Telefone
                </button>
                <?php } ?>
                <p id="telefoneDisplay" class="mt-1 text-lg text-gray-900 font-medium"></p>
                <div class="flex flex-col md:flex-row gap-3 mt-6 md:mt-0">
                    <a href="recuperacaodesenha.php" class="action-button">
                        <i class="fas fa-key"></i> Mudar Senha
                    </a>
                    <button id="logoutBtn" class="action-button">
                        <a href="../../controllers/controller_login/controller_login.php?sair">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </a>
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-b-2xl">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <a href="#"
                            class="tab-link w-full py-4 px-1 text-center border-b-2 font-medium text-sm leading-5"
                            data-tab="info">
                            Informações
                        </a>
                    </nav>
                </div>
                <div id="infoTab" class="tab-content active p-6 md:p-10 fade-in">
                    <h3 class="text-xl font-semibold text-gray-700 mb-4">Informações Pessoais</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="info-card p-4 rounded-lg bg-gray-50">
                            <label class="block text-sm font-medium text-gray-500">E-mail</label>
                            <p id="emailDisplay" class="mt-1 text-lg text-gray-900 font-medium">
                                <?php echo $_SESSION['Email']; ?>
                            </p>
                        </div>
                        <div class="info-card p-4 rounded-lg bg-gray-50">
                            <?php if (isset($_SESSION['Telefone'])) { ?>
                                <label class="block text-sm font-medium text-gray-500">Telefone</label>
                                <p id="telefoneDisplay" class="mt-1 text-lg text-gray-900 font-medium">
                                    <?php echo $_SESSION['Telefone']; ?>
                                </p>
                            <?php } else { ?>
                                <button id="editProfileBtn" class="action-button">
                                    <i class="fas fa-edit"></i> Alterar Telefone
                                </button>
                                <p id="telefoneDisplay" class="mt-1 text-lg text-gray-900 font-medium"></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="logoutConfirmModal" class="modal fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="modal-content relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3 text-center">
                <h3 class="text-lg font-medium text-gray-900">Sair da Conta</h3>
                <div class="mt-2 px-7 py-3">
                    <p class="text-sm text-gray-500">Tem certeza que deseja sair da sua conta?</p>
                </div>
                <div class="items-center px-4 py-3">
                    <button id="confirmLogout" class="action-button w-full mb-2">Confirmar</button>
                    <button id="cancelLogout" class="action-button w-full">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', async function() {
            // Variáveis para elementos do DOM
            const profilePicture = document.getElementById('profilePicture');
            const profileIcon = document.getElementById('profileIcon');
            const photoControls = document.getElementById('photoControls');
            const deletePhotoBtn = document.getElementById('deletePhotoBtn');
            const editProfileBtn = document.getElementById('editProfileBtn');
            const emailDisplay = document.getElementById('emailDisplay');
            const telefoneDisplay = document.getElementById('telefoneDisplay');

            let isEditing = false;

            // Função para formatar telefone
            const formatPhone = (value) => {
                if (!value) return "";
                value = value.replace(/\D/g, '');
                value = value.replace(/(\d{2})(\d)/, "($1)$2");
                value = value.replace(/(\d{5})(\d)/, "$1-$2");
                return value;
            };

            // Função para validar email
            const validateEmail = (email) => {
                const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return re.test(email);
            };

            // Função para mostrar notificações
            const showNotification = (message, type = 'success') => {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg ${type === 'success' ? 'bg-green-500' : 'bg-red-500'
                    } text-white z-50`;
                notification.textContent = message;
                document.body.appendChild(notification);
                setTimeout(() => notification.remove(), 3000);
            };

            // Gerenciamento de foto de perfil
            profilePicture.addEventListener('change', async function(e) {
                const file = e.target.files[0];

                if (file) {
                    if (file.size > 5 * 1024 * 1024) {
                        showNotification('A imagem deve ter menos de 5MB', 'error');
                        return;
                    }

                    if (!file.type.match('image.*')) {
                        showNotification('Por favor, selecione apenas imagens', 'error');
                        return;
                    }

                    try {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            profileIcon.src = e.target.result;
                            localStorage.setItem('profileImage', e.target.result);
                            showNotification('Foto atualizada com sucesso!');
                        };
                        reader.readAsDataURL(file);
                    } catch (error) {
                        showNotification('Erro ao carregar a imagem', 'error');
                    }
                }
            });

            // Deletar foto
            deletePhotoBtn.addEventListener('click', function() {
                profileIcon.src = 'https://via.placeholder.com/80';
                localStorage.removeItem('profileImage');
                showNotification('Foto removida com sucesso!');
            });

            // Editar perfil
            editProfileBtn.addEventListener('click', async function() {
                const editModal = document.createElement('div');
                editModal.classList.add('modal', 'fixed', 'inset-0', 'z-50', 'flex', 'items-center', 'justify-center', 'bg-black', 'bg-opacity-50');
                editModal.innerHTML = `
            <div class="modal-content bg-white rounded-lg p-6 max-w-md w-full mx-4">
                <div class="flex items-center mb-4">
                    <i class="fas fa-user-edit mr-2"></i>
                    <h2 class="text-xl font-semibold">Alterar Telefone</h2>
                </div>
                
                <form action="../../controllers/controller_perfil/controller_telefone.php" method="POST">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-500">Telefone</label>
                        <input type="tel"
                            name="Telefone"
                               id="editTelefone"
                               maxlength="14"
                               class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2
                                      focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                               value="${telefoneDisplay.textContent}">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button id="cancelEdit"
                                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                            Cancelar
                        </button>
                        <button id="saveEdit"
                                class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                            Salvar
                        </button>
                </form>
                </div>
            </div>
        `;
                document.body.appendChild(editModal);

                // Adicionar máscara ao campo de telefone
                const telefoneInput = document.getElementById('editTelefone');
                telefoneInput.addEventListener('input', function(e) {
                    e.target.value = formatPhone(e.target.value);
                });

                const closeEditModal = () => {
                    editModal.remove();
                };

                document.getElementById('cancelEdit').addEventListener('click', closeEditModal);

                // Evento para salvar edição
                document.getElementById('saveEdit').addEventListener('click', async function() {
                    const editEmail = document.getElementById('editEmail').value.trim();
                    const editTelefone = document.getElementById('editTelefone').value.trim();

                    // Validação dos campos
                    if (!editEmail || !editTelefone) {
                        showNotification('Por favor, preencha todos os campos', 'error');
                        return;
                    }

                    // Validação de email
                    if (!validateEmail(editEmail)) {
                        showNotification('Por favor, insira um email válido', 'error');
                        return;
                    }

                    // Validação do formato do telefone
                    if (editTelefone.replace(/\D/g, '').length !== 11) {
                        showNotification('Por favor, insira um telefone válido com DDD', 'error');
                        return;
                    }

                    try {
                        // Salvar as informações
                        localStorage.setItem('email', editEmail);
                        localStorage.setItem('telefone', editTelefone);

                        // Atualizar informações exibidas
                        emailDisplay.textContent = editEmail;
                        telefoneDisplay.textContent = editTelefone;

                        showNotification('Perfil atualizado com sucesso!');
                        closeEditModal();
                    } catch (error) {
                        showNotification('Erro ao atualizar perfil', 'error');
                    }
                });
            });

            // Fechar modal ao clicar fora
            window.addEventListener('click', function(e) {
                if (e.target.classList.contains('modal')) {
                    e.target.remove();
                }
            });

            // Fechar modal com ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    const modals = document.querySelectorAll('.modal');
                    modals.forEach(modal => {
                        modal.remove();
                    });
                }
            });

            // Carregar dados salvos
            const savedImage = localStorage.getItem('profileImage');
            if (savedImage) {
                profileIcon.src = savedImage;
            }

            const savedEmail = localStorage.getItem('email');
            if (savedEmail) {
                emailDisplay.textContent = savedEmail;
            }

            const savedTelefone = localStorage.getItem('telefone');
            if (savedTelefone) {
                telefoneDisplay.textContent = savedTelefone;
            }
        });
        document.addEventListener('DOMContentLoaded', function() {
            const profileIcon = document.getElementById('profileIcon');
            const controlsToggle = document.getElementById('controlsToggle');
            const photoControlsHub = document.getElementById('photoControlsHub');
            const profilePicture = document.getElementById('profilePicture');
            const takePictureBtn = document.getElementById('takePictureBtn');
            const deletePhotoBtn = document.getElementById('deletePhotoBtn');

            // Carregar foto salva ao iniciar
            const savedImage = localStorage.getItem('profileImage');
            if (savedImage) {
                profileIcon.src = savedImage;
            }

            // Toggle do hub de controles
            controlsToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                photoControlsHub.classList.toggle('hidden');
            });

            // Fechar hub ao clicar fora
            document.addEventListener('click', function(e) {
                if (!photoControlsHub.contains(e.target) && e.target !== controlsToggle) {
                    photoControlsHub.classList.add('hidden');
                }
            });

            // Manipular upload de arquivo
            profilePicture.addEventListener('change', function(e) {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        profileIcon.src = e.target.result;
                        localStorage.setItem('profileImage', e.target.result);
                    };
                    reader.readAsDataURL(this.files[0]);
                }
                photoControlsHub.classList.add('hidden');
            });

            // Tirar foto com a câmera
            takePictureBtn.addEventListener('click', async function() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    const video = document.createElement('video');
                    const canvas = document.createElement('canvas');

                    video.srcObject = stream;
                    await video.play();

                    // Capturar frame do vídeo
                    canvas.width = video.videoWidth;
                    canvas.height = video.videoHeight;
                    canvas.getContext('2d').drawImage(video, 0, 0);

                    // Converter para base64 e salvar
                    const imageData = canvas.toDataURL('image/jpeg');
                    profileIcon.src = imageData;
                    localStorage.setItem('profileImage', imageData);

                    // Parar stream da câmera
                    stream.getTracks().forEach(track => track.stop());
                    photoControlsHub.classList.add('hidden');
                } catch (err) {
                    console.error('Erro ao acessar a câmera:', err);
                    alert('Não foi possível acessar a câmera');
                }
            });

            // Remover foto
            deletePhotoBtn.addEventListener('click', function() {
                profileIcon.src = 'https://via.placeholder.com/80';
                localStorage.removeItem('profileImage');
                photoControlsHub.classList.add('hidden');
            });
        });
    </script>
</body>