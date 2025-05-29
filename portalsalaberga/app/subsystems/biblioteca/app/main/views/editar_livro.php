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
        <div class="bg-white rounded-xl shadow-custom overflow-hidden border border-gray-100 transition-all duration-300 hover:shadow-lg">
            <div class="bg-gradient-ceara p-6 sm:p-8">
                <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-white text-center tracking-wide">
                    <i class="fas fa-trash-alt mr-3"></i>Editar Livro
                </h2>
            </div>

            <form id="deleteBookForm" action="../controllers/excluir_editar_livro.php" method="post" class="p-6 sm:p-8">
                <div class="mb-8">
                    <div class="flex border-b border-gray-200">
                        <button type="button"
                            class="tab-button py-2 px-4 font-medium text-ceara-green border-b-2 border-ceara-green cursor-default active"
                            data-tab="search-book">Buscar Livro</button>
                    </div>
                </div>

                <div id="validationMessage" class="hidden"></div>

                <div id="search-book" class="tab-content space-y-6">
                    <div class="space-y-6">
                        <!-- Campo de Busca -->
                        <div class="relative">
                            <label for="searchBook" class="block text-sm font-medium text-gray-700 mb-1">Buscar Livro</label>
                            <div class="relative">
                                <select class="js-example-basic-single" name="id_livro">
                                    <option value="" selected disabled>Selecione um livro para editar</option>
                                    <?php
                                    $livros = $select_model->select_nome_livro();
                                    foreach ($livros as $livro) { ?>
                                        <option value="<?= $livro['id'] ?>"
                                            data-titulo="<?= $livro['titulo_livro'] ?>"
                                            data-edicao="<?= $livro['edicao'] ?>"
                                            data-editora="<?= $livro['editora'] ?>"
                                            data-estante="<?= $livro['estantes'] ?>"
                                            <?php if ($livro['prateleiras'] == 'p1') {
                                            ?>data-prateleira="P1" <?php
                                                                } else if ($livro['prateleiras'] == 'p2') {
                                                                    ?>data-prateleira="P2" <?php
                                                                                        } else if ($livro['prateleiras'] == 'p3') {
                                                                                            ?>data-prateleira="P3" <?php
                                                                                                                    } else if ($livro['prateleiras'] == 'p4') {
                                                                                                                        ?>data-prateleira="P4" <?php
                                                                                                                    } else if ($livro['prateleiras'] == 'p5') {
                                                                                                                        ?>data-prateleira="P5" <?php
                                                                                                                    }
                                                                                                                        ?>
                                            data-quantidade="<?= $livro['quantidade'] ?>"
                                            data-genero="<?= $livro['generos'] ?>"
                                            data-subgenero="<?= $livro['subgenero'] ?>"
                                            data-ano_publicacao="<?= $livro['ano_publicacao'] ?>"
                                            data-corredor="<?= $livro['corredor'] ?>"
                                            data-ficcao="<?= $livro['ficcao'] ?>"
                                            data-brasileira="<?= $livro['brasileira'] ?>"
                                            data-cativo="<?= $livro['cativo'] ?>"
                                            <?= $livro['titulo_livro'] ?> | edição: <?= $livro['edicao'] ?> | editora: <?= $livro['editora'] ?> | estante: <?= $livro['estantes'] ?> | prateleira: <?= $livro['prateleiras'] ?> | quantidade: <?= $livro['quantidade'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>

                        <!-- Formulário de Edição -->
                        <div id="editForm" class="hidden mt-6 space-y-6">
                            <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Informações do Livro</h3>

                                <!-- Título -->
                                <div class="mb-4">
                                    <label for="editTitulo" class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                                    <input type="text" id="editTitulo" name="titulo" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                </div>

                                <!-- Edição -->
                                <div class="mb-4">
                                    <label for="editEdicao" class="block text-sm font-medium text-gray-700 mb-1">Edição</label>
                                    <input type="text" id="editEdicao" name="edicao" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                </div>

                                <!-- Editora -->
                                <div class="mb-4">
                                    <label for="editEditora" class="block text-sm font-medium text-gray-700 mb-1">Editora</label>
                                    <input type="text" id="editEditora" name="editora" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                </div>

                                <!-- Localização -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="editEstante" class="block text-sm font-medium text-gray-700 mb-1">Estante</label>
                                        <select id="editEstante" name="estante" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 transition-all duration-200">
                                            <?php for ($i = 1; $i <= 32; $i++) { ?>
                                                <option value="<?= $i ?>">Estante <?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="editPrateleira" class="block text-sm font-medium text-gray-700 mb-1">Prateleira</label>
                                        <select id="editPrateleira" name="prateleira" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 transition-all duration-200">
                                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                                <option value="P<?= $i ?>">Prateleira <?= $i ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Quantidade -->
                                <div class="mb-4">
                                    <label for="editQuantidade" class="block text-sm font-medium text-gray-700 mb-1">Quantidade</label>
                                    <input type="number" id="editQuantidade" name="quantidade" min="1" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                </div>

                                <!-- Gênero e Subgênero -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="editGenero" class="block text-sm font-medium text-gray-700 mb-1">Gênero</label>
                                        <select name="genero" id="editGenero" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                            <?php
                                            $generos = $select_model->select_genero();
                                            foreach ($generos as $genero) { ?>
                                                <option value="<?= $genero['id'] ?>"><?= $genero['generos'] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="editSubgenero" class="block text-sm font-medium text-gray-700 mb-1">Subgênero</label>
                                        <select name="subgenero" id="editSubgenero" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                            <?php
                                            $generos = $select_model->select_genero();
                                            foreach ($generos as $genero) {
                                                $subgeneros = $select_model->select_subgenero(genero: $genero['generos']);
                                            ?>
                                                <optgroup label="<?= $genero['generos'] ?>"></optgroup>
                                                <?php
                                                foreach ($subgeneros as $subgenero) {
                                                ?>
                                                    <option value="<?= $subgenero['id'] ?>"><?= $subgenero['subgenero'] ?></option>
                                                <?php } ?>
                                                </optgroup>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- Ano de Publicação e Corredor -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label for="editAnoPublicacao" class="block text-sm font-medium text-gray-700 mb-1">Ano de Publicação</label>
                                        <input type="text" id="editAnoPublicacao" name="ano_publicacao" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                    </div>
                                    <div>
                                        <label for="editCorredor" class="block text-sm font-medium text-gray-700 mb-1">Corredor</label>
                                        <input type="text" id="editCorredor" name="corredor" class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg focus:border-ceara-green focus:ring-2 focus:ring-ceara-green/20 focus:outline-none hover:border-gray-300 text-gray-600 placeholder-gray-400 transition-all duration-200">
                                    </div>
                                </div>

                                <!-- Checkboxes -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div class="flex items-center">
                                        <input type="checkbox" id="editFiccao" name="ficcao" class="w-4 h-4 text-ceara-green border-gray-300 rounded focus:ring-ceara-green">
                                        <label for="editFiccao" class="ml-2 text-sm font-medium text-gray-700">Ficção</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="editLiteratura" name="literatura" class="w-4 h-4 text-ceara-green border-gray-300 rounded focus:ring-ceara-green">
                                        <label for="editLiteratura" class="ml-2 text-sm font-medium text-gray-700">Brasileira</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="checkbox" id="editCativo" name="cativo" class="w-4 h-4 text-ceara-green border-gray-300 rounded focus:ring-ceara-green">
                                        <label for="editCativo" class="ml-2 text-sm font-medium text-gray-700">Cativo</label>
                                    </div>
                                </div>
                            </div>

                            <!-- Botões de Ação -->
                            <div class="flex space-x-4">
                                <button type="submit"
                                    class="flex-1 bg-ceara-green hover:bg-ceara-green-dark text-white font-medium py-4 px-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg flex items-center justify-center text-lg shadow-md">
                                    <i class="fas fa-save mr-3"></i>
                                    Salvar Alterações
                                </button>
                                <button type="button" id="cancelEdit"
                                    class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-medium py-4 px-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg flex items-center justify-center text-lg shadow-md">
                                    <i class="fas fa-times mr-3"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>

                        <!-- Botão de Exclusão -->
                        <button type="submit" name="action" value="delete"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-4 px-6 rounded-lg transition duration-300 ease-in-out hover:shadow-lg flex items-center justify-center text-lg shadow-md">
                            <i class="fas fa-trash-alt mr-3"></i>
                            Buscar Livro
                        </button>
                    </div>

                    <?php if (isset($_GET['true'])): ?>
                        <div class="flex items-center p-4 mb-4 text-green-800 border-l-4 border-green-500 bg-green-50 rounded-md"
                            role="alert">
                            <i class="fas fa-check-circle text-xl mr-3"></i>
                            <span class="text-sm font-medium">Livro editado com sucesso!</span>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="flex items-center p-4 mb-4 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-md"
                            role="alert">
                            <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                            <span class="text-sm font-medium">ERRO ao editar livro!</span>
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
                placeholder: "Digite o título do livro...",
                allowClear: true,
                language: {
                    noResults: function() {
                        return "Nenhum livro encontrado";
                    },
                    searching: function() {
                        return "Buscando...";
                    }
                }
            }).on('select2:select', function(e) {
                const selectedOption = e.params.data.element;
                if (selectedOption) {
                    // Update form fields with selected book data
                    document.getElementById('editTitulo').value = selectedOption.dataset.titulo;
                    document.getElementById('editEdicao').value = selectedOption.dataset.edicao;
                    document.getElementById('editEditora').value = selectedOption.dataset.editora;
                    document.getElementById('editEstante').value = selectedOption.dataset.estante;
                    // Handle prateleira with P prefix
                    const prateleiraValue = selectedOption.dataset.prateleira;
                    document.getElementById('editPrateleira').value = prateleiraValue;
                    document.getElementById('editQuantidade').value = selectedOption.dataset.quantidade;

                    // Populate new fields
                    // Encontrar a opção do gênero que corresponde ao texto
                    const generoSelect = document.getElementById('editGenero');
                    const generoOptions = Array.from(generoSelect.options);
                    const generoOption = generoOptions.find(option => option.text === selectedOption.dataset.genero);
                    if (generoOption) {
                        generoSelect.value = generoOption.value;
                    }

                    // Encontrar a opção do subgênero que corresponde ao texto
                    const subgeneroSelect = document.getElementById('editSubgenero');
                    const subgeneroOptions = Array.from(subgeneroSelect.options);
                    const subgeneroOption = subgeneroOptions.find(option => option.text === selectedOption.dataset.subgenero);
                    if (subgeneroOption) {
                        subgeneroSelect.value = subgeneroOption.value;
                    }

                    document.getElementById('editAnoPublicacao').value = selectedOption.dataset.ano_publicacao;
                    document.getElementById('editCorredor').value = selectedOption.dataset.corredor;
                    document.getElementById('editFiccao').checked = selectedOption.dataset.ficcao === '1';
                    document.getElementById('editLiteratura').checked = selectedOption.dataset.brasileira === '1';
                    document.getElementById('editCativo').checked = selectedOption.dataset.cativo === '1';

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
            document.getElementById('deleteBookForm').addEventListener('submit', function(e) {
                const selectedBook = $('.js-example-basic-single').val();
                if (!selectedBook) {
                    e.preventDefault();
                    validationMessage.innerHTML = `
                        <div class="flex items-center p-4 mb-4 text-red-800 border-l-4 border-red-500 bg-red-50 rounded-md" role="alert">
                            <i class="fas fa-exclamation-circle text-xl mr-3"></i>
                            <span class="text-sm font-medium">Por favor, selecione um livro para editar!</span>
                        </div>
                    `;
                    validationMessage.classList.remove('hidden');
                }
            });
        });
    </script>
</body>

</html>