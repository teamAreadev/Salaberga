<?php
require_once('../models/select_model.php');
$select_model = new select_model();
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Formulário Biblioteca</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="../assets/img/icon.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#007A33',
                        'ceara-green-dark': '#005F27',
                        'ceara-orange': '#FFA500',
                        'ceara-orange-dark': '#FF8C00',
                    },
                    boxShadow: {
                        'custom': '0 10px 25px -5px rgba(0, 122, 51, 0.1), 0 8px 10px -6px rgba(0, 122, 51, 0.1)',
                    },
                    backgroundImage: {
                        'gradient-ceara': 'linear-gradient(to right, #007A33, #005F27)',
                        'gradient-orange': 'linear-gradient(to right, #FFA500, #FF8C00)',
                    }
                }
            }
        }
    </script>
    <style>
        input[type="checkbox"]:checked,
        input[type="radio"]:checked {
            background-color: #007A33 !important;
            border-color: #007A33 !important;
        }

        input[type="checkbox"]:checked:focus,
        input[type="radio"]:checked:focus {
            --tw-ring-color: rgba(0, 122, 51, 0.2);
        }

        input[type="radio"] {
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            width: 1.25rem;
            height: 1.25rem;
            border: 2px solid #d1d5db;
            border-radius: 50%;
            outline: none;
            transition: all 0.2s ease-in-out;
        }

        input[type="radio"]:checked {
            border-color: #007A33;
            background-color: #007A33;
            box-shadow: inset 0 0 0 4px #fff;
        }

        input[type="radio"]:focus {
            box-shadow: 0 0 0 3px rgba(0, 122, 51, 0.2);
        }

        .tab-button.active {
            color: #007A33 !important;
            border-bottom: 2px solid #007A33 !important;
        }

        input[type="checkbox"] {
            accent-color: #007A33;
        }

        /* Select2 Custom Styling */
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple {
            background-color: white;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            min-height: 48px;
            padding: 4px;
            transition: all 0.2s ease-in-out;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #007A33;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2);
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #007A33;
            border: none;
            border-radius: 0.375rem;
            color: white;
            padding: 4px 8px;
            margin: 2px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
            margin-right: 4px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover {
            color: #ff4444;
            background: none;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #007A33;
        }

        .select2-dropdown {
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 2px solid #e5e7eb;
            border-radius: 0.375rem;
            padding: 8px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #007A33;
            outline: none;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.2);
        }

        .select2-container--default .select2-results__option {
            padding: 8px 12px;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e6f3ed;
            color: #007A33;
        }
        /* Customização extra para o Select2 do campo de autor */
        .select2-container--default .select2-selection--single {
            background-color: #fff;
            border: 2px solid #e5e7eb;
            border-radius: 0.75rem;
            min-height: 48px;
            padding: 8px 16px;
            font-size: 1.125rem;
            color: #374151;
            box-shadow: 0 1px 2px 0 rgba(0,0,0,0.03);
            transition: border 0.2s, box-shadow 0.2s;
        }
        .select2-container--default .select2-selection--single:focus,
        .select2-container--default .select2-selection--single.select2-selection--focus {
            border-color: #007A33;
            box-shadow: 0 0 0 2px rgba(0, 122, 51, 0.15);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151;
            font-size: 1.125rem;
            line-height: 2.25rem;
            padding-left: 0;
        }
        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af;
            font-size: 1.125rem;
            opacity: 1;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 48px;
            right: 8px;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-b from-gray-50 to-gray-100 p-4 sm:p-6 md:p-8 lg:p-12 select-none"
    style="background-image: url('../assets/img/layout.png'); background-size: cover; background-attachment: fixed;">
    <a href="decisão.php"
        class="fixed top-5 left-5 z-50 group flex items-center space-x-2 bg-white/80 rounded-full px-4 py-2 shadow-lg hover:bg-ceara-green transition-all duration-300">
        <i class="fa-solid fa-arrow-left text-ceara-green group-hover:text-white"></i>
        <span class="text-ceara-green group-hover:text-white font-medium">Voltar</span>
    </a>

    <div class="max-w-4xl mx-auto">
        <img src="../assets/img/logo1.png"
            class="w-[200px] sm:w-[250px] md:w-[300px] mx-auto mb-8 drop-shadow-xl hover:scale-105 transition-transform duration-300"
            alt="Logo">
        <div class="bg-white/90 rounded-2xl shadow-2xl overflow-hidden border border-gray-200 transition-all duration-300 hover:shadow-2xl mt-8 mb-12">
            <div class="bg-gradient-ceara p-8 flex flex-col items-center">
                <h2 class="text-3xl md:text-4xl font-extrabold text-white text-center tracking-wide drop-shadow-lg flex items-center gap-3">
                    <i class="fas fa-user-edit"></i> Editar Autor
                </h2>
            </div>
            <form id="editAuthorForm" action="../controllers/excluir_editar_livro.php" method="post" class="p-8 md:p-12 space-y-8">
                <div class="mb-8">
                    <div class="flex justify-center border-b border-gray-200 pb-2">
                        <button type="button"
                            class="tab-button py-2 px-6 font-semibold text-ceara-green border-b-2 border-ceara-green cursor-default active text-lg bg-gray-50 rounded-t-lg shadow-sm"
                            data-tab="search-author">Buscar Autor</button>
                    </div>
                </div>
                <div id="validationMessage" class="hidden"></div>
                <div id="search-author" class="tab-content space-y-8">
                    <div class="space-y-8">
                        <!-- Campo de Busca -->
                        <div class="relative">
                          
                            <div class="relative">
                                <select class="js-example-basic-single border-2 border-gray-200 rounded-lg px-5 py-3 w-full focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none text-lg bg-white text-gray-700 transition-all duration-200" name="id_autor">
                                    <option value="" selected disabled>Selecione um autor para editar</option>
                                    <?php
                                    $autores = $select_model->select_nome_autor();
                                    foreach ($autores as $autor) { ?>
                                        <option value="<?= $autor['id'] ?>" 
                                            data-nome="<?= $autor['nome_autor'] ?>"
                                            data-sobrenome="<?= $autor['sobrenome_autor'] ?>">
                                            <?= $autor['nome_autor'] ?> <?= $autor['sobrenome_autor'] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <!-- Formulário de Edição -->
                        <div id="editForm" class="hidden mt-8 space-y-8">
                            <div class="bg-gray-50 rounded-2xl p-8 border border-gray-200 shadow-inner">
                                <h3 class="text-xl font-bold text-ceara-green mb-6 flex items-center gap-2"><i class="fas fa-id-card-alt"></i> Informações do Autor</h3>
                                <!-- Nome e Sobrenome -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                    <div>
                                        <label for="editNome" class="block text-base font-medium text-gray-700 mb-2">Nome</label>
                                        <input type="text" id="editNome" name="nome" class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-700 placeholder-gray-400 transition-all duration-200 text-lg">
                                    </div>
                                    <div>
                                        <label for="editSobrenome" class="block text-base font-medium text-gray-700 mb-2">Sobrenome</label>
                                        <input type="text" id="editSobrenome" name="sobrenome" class="w-full px-5 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-700 placeholder-gray-400 transition-all duration-200 text-lg">
                                    </div>
                                </div>
                                <!-- Botões de Ação -->
                                <div class="flex flex-col md:flex-row gap-4 mt-6">
                                    <button type="submit" name="action" value="edit"
                                        class="flex-1 bg-ceara-green hover:bg-ceara-green-dark text-white font-bold py-4 px-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg flex items-center justify-center text-lg shadow-md">
                                        <i class="fas fa-save mr-3"></i>
                                        Salvar Alterações
                                    </button>
                                    <button type="button" id="cancelEdit"
                                        class="flex-1 bg-gray-400 hover:bg-gray-600 text-white font-bold py-4 px-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg flex items-center justify-center text-lg shadow-md">
                                        <i class="fas fa-times mr-3"></i>
                                        Cancelar
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Botão de Editar Principal -->
                    </div>
                    <?php if (isset($_GET['true'])): ?>
                        <div class="flex items-center p-4 mb-4 text-green-800 border-l-4 border-green-500 bg-green-50 rounded-md"
                            role="alert">
                            <i class="fas fa-check-circle text-xl mr-3"></i>
                            <span class="text-base font-semibold">Autor editado com sucesso!</span>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($_GET['error'])): ?>
                        <div class="flex items-center p-4 mb-4 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-md"
                            role="alert">
                            <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                            <span class="text-base font-semibold">ERRO ao editar autor!</span>
                        </div>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const validationMessage = document.getElementById('validationMessage');
            const editForm = document.getElementById('editForm');
            const cancelEditBtn = document.getElementById('cancelEdit');

            // Initialize Select2 with custom configuration
            $('.js-example-basic-single').select2({
                placeholder: "Digite o nome do autor...",
                allowClear: true,
                language: {
                    noResults: function() {
                        return "Nenhum autor encontrado";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            }).on('select2:select', function(e) {
                const selectedOption = e.params.data.element;
                if (selectedOption) {
                    // Update form fields with selected author data
                    document.getElementById('editNome').value = selectedOption.dataset.nome;
                    document.getElementById('editSobrenome').value = selectedOption.dataset.sobrenome;

                    // Show the edit form
                    editForm.classList.remove('hidden');
                }
            });

            // Handle cancel button
            cancelEditBtn.addEventListener('click', function() {
                editForm.classList.add('hidden');
                $('.js-example-basic-single').val('').trigger('change');
            });

            // Form validation
            document.getElementById('editAuthorForm').addEventListener('submit', function(e) {
                const selectedAuthor = $('.js-example-basic-single').val();
                if (!selectedAuthor) {
                    e.preventDefault();
                    validationMessage.innerHTML = `
                        <div class="flex items-center p-4 mb-4 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-md" role="alert">
                            <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                            <span class="text-sm font-medium">Por favor, selecione um autor para editar!</span>
                        </div>
                    `;
                    validationMessage.classList.remove('hidden');
                }
            });
        });
    </script>
</body>

</html>