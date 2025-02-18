function showReportsModal() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Relatórios</h2>',
        html: `
        <form action="../controllers/controller_relatorio.php" id="searchForm" onsubmit="submitForm(); return false;" method="post" class="bg-ceara-white rounded-lg p-6">
            <div class="space-y-6">
                <div class="relative">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Relatório</label>
                    <select required id="type" name="tipo" class="form-select block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200">
                        <option value="">Selecione um tipo</option>
                        <option value="1">Publica Geral</option>
                        <option value="2">Publica Ampla Concorência</option>
                        <option value="3">Publica Cotas</option>
                        <option value="4">Privada Geral</option>
                        <option value="5">Privada Ampla Concorência</option>
                        <option value="6">Privada Cotas</option>
                    </select>
                </div>
                
                <div class="relative">
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-2">Curso</label>
                    <select required id="course" name="curso" class="form-select block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200">
                        <option value="">Selecione um curso</option>
                        <option value="1">Administração</option>
                        <option value="2">Informática</option>
                        <option value="3">Logística</option>
                        <option value="4">Redes de Computadores</option>
                    </select>
                </div>

                <div class="flex justify-center space-x-4 mt-8">
                    <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200 focus:ring-2 focus:ring-gray-300" onclick="Swal.close()">
                        Cancelar
                    </button>
                    <button type="submit" class="px-6 py-2.5 bg-ceara-green text-ceara-white rounded-lg font-medium hover:bg-ceara-green-dark transition-all duration-200 focus:ring-2 focus:ring-ceara-green">
                        Gerar Resultados
                    </button>
                </div>
            </div>
        </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}

function showatualizModal() {
    Swal.fire({
        title: '',
        html: `
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-lg shadow-xl overflow-hidden">
                <!-- Header -->
                <div class="bg-gradient-to-r from-ceara-green to-green-500 px-6 py-4">
                    <h2 class="text-2xl font-bold text-white">Atualizar Notas</h2>
                </div>

                <div class="p-6">
                    <form action="../controllers/atualizar.php" 
                        method="post" 
                        id="searchForm" 
                        class="space-y-6">
                        <div class="space-y-4">
                            <div class="flex flex-col">
                                <label for="searchId" 
                                       class="text-sm font-medium text-gray-700 mb-2">
                                    Digite o ID do Relatório
                                </label>
                                <input type="text" 
                                       id="searchId" 
                                       name="id"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ceara-green focus:border-transparent transition-all duration-200 ease-in-out"
                                       placeholder="Digite o ID"
                                       required>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" 
                                    onclick="Swal.close()" 
                                    class="px-6 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transform hover:scale-105 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Cancelar
                            </button>
                            <button type="submit"   
                                class="px-6 py-2 bg-ceara-green text-white rounded-lg hover:bg-green-600 transform hover:scale-105 transition-all duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-ceara-orange focus:ring-offset-2">  
                                Buscar  
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-2xl border-0',
            container: 'backdrop-filter backdrop-blur-sm'
        },
        background: '#fff',
        width: 'auto',
        padding: 0
    });
}

function openUpdateNotesModal() {
    const subjects = [
        { id: 'portugues', label: 'Português' },
        { id: 'arte', label: 'Arte' },
        { id: 'edFisica', label: 'Ed. Física' },
        { id: 'ingles', label: 'Inglês' },
        { id: 'ciencias', label: 'Ciências' },
        { id: 'geografia', label: 'Geografia' },
        { id: 'historia', label: 'História' },
        { id: 'religiao', label: 'Religião' },
        { id: 'matematica', label: 'Matemática' }
    ];

    const inputFields = subjects.map(subject => `
        <div class="relative">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="${subject.id}">${subject.label}</label>
            <input type="number" step="0.1" min="0" max="10" id="${subject.id}" 
                class="form-input block w-full max-w-sm px-4 py-2.5 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200">
        </div>
    `).join('');

    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Atualizar Notas</h2>',
        html: `
            <form id="updateNotesForm" class="bg-ceara-white rounded-lg p-6">
                <div class="space-y-6">
                    <div class="relative">
                        <label class="block text-sm font-medium text-gray-700 mb-2" for="studentId">ID do Aluno</label>
                        <input type="number" id="studentId" 
                            class="form-input block w-full max-w-lg px-4 py-2.5 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200" required>
                    </div>
                    <div class="grid grid-cols-3 gap-6">
                        ${inputFields}
                    </div>
                    <div class="flex justify-center space-x-4 mt-8">
                        <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200 focus:ring-2 focus:ring-gray-300" onclick="Swal.close()">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-ceara-green text-ceara-white rounded-lg font-medium hover:bg-ceara-green-dark transition-all duration-200 focus:ring-2 focus:ring-ceara-green">
                            Atualizar
                        </button>
                    </div>
                </div>
            </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}


function openInsertUserModal() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Inserir Usuário</h2>',
        html: `
            <form id="insertUserForm" action="../controllers/controller_cadastrar.php" method="post" class="bg-ceara-white rounded-lg p-6">
                <div class="space-y-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="fullName">Nome Completo</label>
                            <input type="text" id="fullName" name="nomeC"
                                class="form-input block w-full max-w-lg px-4 py-2.5 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200" required>
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="email">E-mail Institucional</label>
                            <input type="email" id="email" name="email"
                                class="form-input block w-full max-w-lg px-4 py-2.5 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200" required>
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="password">Senha</label>
                            <input type="password" id="password" name="senha"
                                class="form-input block w-full max-w-lg px-4 py-2.5 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200" required>
                        </div>
                        
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 mb-2" for="status">Status</label>
                            <select id="status" name="status"
                                class="form-select block w-full max-w-lg px-4 py-2.5 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200">
                                <option value="">Selecione um status</option>
                                <option value="1">Admin</option>
                                <option value="0">Não Admin</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex justify-center space-x-4 mt-8">
                        <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200 focus:ring-2 focus:ring-gray-300" onclick="Swal.close()">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-ceara-green text-ceara-white rounded-lg font-medium hover:bg-ceara-green-dark transition-all duration-200 focus:ring-2 focus:ring-ceara-green">
                            Inserir
                        </button>
                    </div>
                </div>
            </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}



function showResultsModal() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Resultados</h2>',
        html: `
        <form action="../controllers/controller_resultados.php" id="searchForm" method="post" class="bg-ceara-white rounded-lg p-6">
            <div class="space-y-6">
                <div class="relative">
                    <label for="type" class="block text-sm font-medium text-gray-700 mb-2">Tipo de Resultado</label>
                    <select required id="type" name="tipo" 
                        class="form-select block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200">
                        <option value="">Selecione um tipo</option>
                        <option value="1">Classificados</option>
                        <option value="2">Lista de espera</option>
                    </select>
                </div>
                
                <div class="relative">
                    <label for="course" class="block text-sm font-medium text-gray-700 mb-2">Curso</label>
                    <select required id="course" name="curso" 
                        class="form-select block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200">
                        <option value="">Selecione um curso</option>
                        <option value="1">Administração</option>
                        <option value="2">Informática</option>
                        <option value="3">Logística</option>
                        <option value="4">Redes de Computadores</option>
                    </select>
                </div>

                <div class="flex justify-center space-x-4 mt-8">
                    <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200 focus:ring-2 focus:ring-gray-300" onclick="Swal.close()">
                        Cancelar
                    </button>
                    <button type="submit" onclick="submitForm()" class="px-6 py-2.5 bg-ceara-green text-ceara-white rounded-lg font-medium hover:bg-ceara-green-dark transition-all duration-200 focus:ring-2 focus:ring-ceara-green">
                        Gerar Resultados
                    </button>
                </div>
            </div>
        </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}

function showDeleteConfirmationModal() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Confirmação de Exclusão</h2>',
        html: `
        <form id="deleteForm" class="bg-ceara-white rounded-lg p-6">
            <p class="text-gray-700">Você tem certeza que quer apagar o banco?</p>
            <div class="relative mt-4">
             
                <input type="password" id="password" name="password" required 
                    class="form-input block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm  transition-all duration-200" 
                    placeholder="Digite sua senha">
            </div>
            <div class="flex justify-center space-x-4 mt-8">
                <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200" onclick="Swal.close()">
                    Cancelar
                </button>
                <button type="submit" onclick="confirmDelete(event)" class="px-6 py-2.5 bg-red-600 text-ceara-white rounded-lg font-medium hover:bg-red-700 transition-all duration-200 focus:ring-2 focus:ring-red-500">
                    Apagar Banco
                </button>
            </div>
        </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}

function confirmDelete(event) {
    event.preventDefault(); // Impede o envio do formulário padrão
    const password = document.getElementById('password').value;

    // Aqui você pode adicionar a lógica para verificar a senha e apagar o banco
    if (password === "suaSenhaSecreta") { // Exemplo de verificação de senha
        Swal.fire({
            title: 'Banco apagado!',
            text: 'O banco foi apagado com sucesso.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else {
        Swal.fire({
            title: 'Erro!',
            text: 'Senha incorreta. Tente novamente.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
}


function submitForm() {
    const courseSelect = document.getElementById('course');
    const typeSelect = document.getElementById('type');
    const form = document.getElementById('searchForm');

    if (courseSelect.value === '' || typeSelect.value === '') {
        Swal.fire({
            icon: 'error',
            title: 'Erro',
            text: 'Por favor, selecione um curso e um tipo',
            customClass: {
                popup: 'rounded-xl shadow-xl'
            }
        });
        return;
    }

    Swal.fire({
        title: 'Gerando Relatórios...',
        text: 'Por favor, aguarde.',
        allowOutsideClick: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        },
        didOpen: () => {
            Swal.showLoading();
        }
    });

    setTimeout(() => {
        form.submit();
    }, 1500);
}

function showExcluirCandidatoModal() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Excluir candidato</h2>',
        html: `
        <form action="../controllers/controller_excluir/excluir_candidato.php" method="post" id="courseForm" class="bg-ceara-white rounded-lg p-6">
            <div class="mb-4">
             
                <input type="id" id="courseName" name="id_candidato" required 
                    class="form-input block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200" 
                    placeholder="ID do candidato">
            </div>
         <div class="flex justify-center space-x-4 mt-8">
                    <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200 focus:ring-2 focus:ring-gray-300" onclick="Swal.close()">
                        Cancelar
                    </button>
                    <button type="submit" onclick="submitForm()" class="px-6 py-2.5 bg-ceara-green text-ceara-white rounded-lg font-medium hover:bg-ceara-green-dark transition-all duration-200 focus:ring-2 focus:ring-ceara-green">
                      Excluir
                    </button>
                </div>
        </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}

function showExcluirUsuarioModal() {
    Swal.fire({
        title: '<h2 class="text-2xl font-bold text-gray-800 mb-4">Excluir usuario</h2>',
        html: `
        <form action="../controllers/controller_excluir/excluir_usuario.php" method="post" id="courseForm" class="bg-ceara-white rounded-lg p-6">
            <div class="mb-4">
             
                <input type="text" id="courseName" name="id_usuario" required 
                    class="form-input block w-full px-4 py-3 bg-ceara-white border border-gray-600 rounded-lg shadow-sm focus:ring-2 focus:ring-ceara-green focus:border-ceara-green transition-all duration-200" 
                    placeholder="ID do usuário">
            </div>

         <div class="flex justify-center space-x-4 mt-8">
                    <button type="button" class="px-6 py-2.5 bg-gray-400 text-ceara-white rounded-lg font-medium hover:bg-gray-500 transition-all duration-200 focus:ring-2 focus:ring-gray-300" onclick="Swal.close()">
                        Cancelar
                    </button>
                    <button type="submit" onclick="submitForm()" class="px-6 py-2.5 bg-ceara-green text-ceara-white rounded-lg font-medium hover:bg-ceara-green-dark transition-all duration-200 focus:ring-2 focus:ring-ceara-green">
                      Excluir
                    </button>
                </div>
        </form>
        `,
        showConfirmButton: false,
        showCancelButton: false,
        customClass: {
            popup: 'rounded-xl shadow-xl'
        }
    });
}

function submitCourse(event) {
    event.preventDefault(); // Impede o envio do formulário padrão
    const courseName = document.getElementById('courseName').value;
    const courseColor = document.getElementById('courseColor').value;

    // Aqui você pode adicionar a lógica para cadastrar o curso
    console.log("Curso cadastrado:", courseName, "Cor:", courseColor);

    Swal.fire({
        title: 'Curso Cadastrado!',
        text: 'O curso foi cadastrado com sucesso.',
        icon: 'success',
        confirmButtonText: 'OK'
    });
}





const modalConfig = {
    allowOutsideClick: false,
    allowEscapeKey: false,
    customClass: {
        popup: 'rounded-2xl shadow-2xl bg-white border border-gray-200 custom-scrollbar',
        title: 'text-gray-800',
        input: 'bg-white border-gray-300 text-gray-800 rounded-lg',
    },
    buttonsStyling: false,
    background: 'transparent',
    showClass: {
        popup: 'animate__animated animate__fadeInUp animate__faster'
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutDown animate__faster'
    },
    didOpen: () => { },
    preConfirm: (courseId) => {
        return validateAndCollectData(courseId);
    }
};

// Funções para abrir os modais
function administracaoPub() {
    showModal('Administração', 'Escola Pública');
}

function administracaoPriv() {
    showModal('Administração', 'Escola Privada');
}

function informaticaPub() {
    showModal('Informática', 'Escola Pública');
}

function informaticaPriv() {
    showModal('Informática', 'Escola Privada');
}

function logisticaPub() {
    showModal('Logística', 'Escola Pública');
}

function logisticaPriv() {
    showModal('Logística', 'Escola Privada');
}

function redesComputadoresPub() {
    showModal('Redes de Computadores', 'Escola Pública');
}

function redesComputadoresPriv() {
    showModal('Redes de Computadores', 'Escola Privada');
}


// Função genérica para mostrar modal
function showModal(courseName, schoolType) {
    Swal.fire({
        ...modalConfig,

        width: '70%',
        html: createModalContent(courseName, schoolType)
    });
}

function createModalContent(courseName, schoolType) {
    const subjects = [{
        id: 'lp',
        name: 'Português'
    },
    {
        id: 'ar',
        name: 'Arte'
    },
    {
        id: 'ef',
        name: 'Ed. Física'
    },
    {
        id: 'li',
        name: 'Inglês'
    },
    {
        id: 'ci',
        name: 'Ciências'
    },
    {
        id: 'ge',
        name: 'Geografia'
    },
    {
        id: 'hi',
        name: 'História'
    },
    {
        id: 're',
        name: 'Religião'
    },
    {
        id: 'ma',
        name: 'Matemática'
    }
    ];

    switch (courseName) {
        case 'Administração':
            return createAdministracaoForm(schoolType, subjects);
        case 'Informática':
            return createInformaticaForm(schoolType, subjects);
        case 'Logística':
            return createLogisticaForm(schoolType, subjects);
        case 'Redes de Computadores':
            return createRedesdecomputadoresForm(schoolType, subjects);
        default:
            return '';
    }
}

function createAdministracaoForm(schoolType, subjects) {
    return createForm('Administração', schoolType, subjects);
}
function createInformaticaForm(schoolType, subjects) {
    return createForm('Informática', schoolType, subjects);
}
function createLogisticaForm(schoolType, subjects) {
    return createForm('Logística', schoolType, subjects);
}

function createRedesdecomputadoresForm(schoolType, subjects) {
    return createForm('Redes de Computadores', schoolType, subjects);
}


// Função para criar o conteúdo do modal com formulários específicos
function createModalContent(courseName, schoolType) {
    switch (courseName) {
        case 'Administração':
            return createAdministracaoForm(schoolType);
        case 'Informática':
            return createInformaticaForm(schoolType);
        case 'Logística':
            return createLogisticaForm(schoolType);
        case 'Redes de Computadores':
            return createRedesdecomputadoresForm(schoolType);
        default:
            return '';
    }
}
function maskNascimento(input) {
    // Remove non-numeric characters
    let value = input.value.replace(/\D/g, '');

    // Limit to 8 digits
    value = value.slice(0, 8);

    // Format the date
    let formattedValue = '';
    if (value.length >= 6) {
        // Insert slashes for DD/MM/YYYY
        formattedValue = `${value.slice(0, 2)}/${value.slice(2, 4)}/${value.slice(4)}`;
    } else if (value.length >= 4) {
        formattedValue = `${value.slice(0, 2)}/${value.slice(2)}`;
    } else if (value.length >= 2) {
        formattedValue = `${value.slice(0, 2)}/${value.slice(2)}`;
    } else {
        formattedValue = value;
    }

    // Se o valor for vazio, não aplica a máscara
    if (value.length === 0) {
        formattedValue = '';
    }

    input.value = formattedValue;

    // Optional: Basic date validation
    if (formattedValue.length === 10) {
        const [day, month, year] = formattedValue.split('/').map(Number);
        const date = new Date(year, month - 1, day);
        const today = new Date();

        // Check if date is valid and not in the future
        if (
            date.getFullYear() !== year ||
            date.getMonth() + 1 !== month ||
            date.getDate() !== day ||
            date > today
        ) {
            input.setCustomValidity('Data inválida');
        } else {
            input.setCustomValidity('');
        }
    } else {
        input.setCustomValidity('');
    }
}

function removeAccents(input) {
    // Armazena o valor atual do cursor
    const cursorPosition = input.selectionStart;

    // String de caracteres com acentos e suas substituições
    const accents = 'àáâãäçèéêëìíîïñòóôõöùúûüýÿÀÁÂÃÄÇÈÉÊËÌÍÎÏÑÒÓÔÕÖÙÚÛÜÝ';
    const noAccents = 'aaaaaceeeeiiiinooooouuuuyyAAAAACEEEEIIIINOOOOOUUUUY';

    let value = input.value;
    let result = '';

    // Percorre cada caractere do input
    for (let i = 0; i < value.length; i++) {
        const char = value[i];
        const index = accents.indexOf(char);

        // Se encontrar um caractere acentuado, substitui pelo equivalente sem acento
        if (index !== -1) {
            result += noAccents[index];
        } else {
            result += char;
        }
    }

    // Atualiza o valor do input
    input.value = result;

    // Restaura a posição do cursor
    input.setSelectionRange(cursorPosition, cursorPosition);
}

function createAdministracaoForm(schoolType) {
    return `
    <form id="AdministracaoForm" action="../controllers/controller.php" method="POST" class="w-auto bg-[--ceara-white] rounded-xl shadow-md">
        <!-- Cabeçalho -->
        <div class="bg-[#008000] p-3 rounded-t-xl">
            <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Formulário de Administração</h2>
        </div>

        <!-- Informações Pessoais -->
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4 p-4">
            <div class="flex flex-col md:col-span-6">
                <input type="text" name="nome" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#008000] w-full text-center"  oninput="removeAccents(this)"   placeholder="Nome Completo" required>
            </div>

           <div class="flex flex-col md:col-span-1">
    <input type="text" name="nasc" maxlength="10" placeholder="DD/MM/AAAA" 
           class="px-6 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#008000] w-full" 
           oninput="maskNascimento(this)" required>
</div>

            <div class="flex flex-col md:col-span-1">
                <input type="text" name="curso" value="Administração" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
                <input type="hidden" name="curso" value="Administração">
            </div>

            <div class="flex flex-col md:col-span-1">
                <input type="text" name="${schoolType}" value="${schoolType}" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
                <input type="hidden" name="publica" value="${schoolType}">
            </div>

            <div class="flex flex-col md:col-span-2">
                <select name="bairro" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#008000] w-full" required>
                    <option value="">Selecione um bairro</option>
                    <option value="Outra Banda">Outra Banda</option>
                    <option value="Outros Bairros">Outros Bairros</option>
                </select>
            </div>

            <div class="flex items-center md:col-span-1">
                <label for="pcd" class="text-sm text-[--gray-600] mr-2">PCD</label>
                <input type="checkbox" id="pcd" name="pcd" value="1" class="w-4 h-4 text-[#008000] border border-[--gray-600] rounded">
            </div>
        </div>

        <!-- Notas -->
        <div class="space-y-3 px-4">
            <!-- 6º Ano -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-2 pb-1 border-b">6º Ano</h3>
                    </div>
                    <div>
                        <input type="text" name="lp6" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="a6" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="m6" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="h6" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="g6" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="c6" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="i6" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="ef6" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="r6" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                </div>
            </div>

            <!-- 7º Ano -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-2 pb-1 border-b">7º Ano</h3>
                    </div>
                    <div>
                        <input type="text" name="lp7" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="a7" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="m7" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="h7" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="g7" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="c7" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="i7" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="ef7" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="r7" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                </div>
            </div>

            <!-- 8º Ano -->
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-2 pb-1 border-b">8º Ano</h3>
                    </div>
                    <div>
                        <input type="text" name="lp8" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="a8" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="m8" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="h8" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="g8" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="c8" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="i8" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="ef8" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)">
                    </div>
                    <div>
                        <input type="text" name="r8" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                    </div>
                </div>
            </div>
        </div>
    <div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="closeModalAndRedirect('AdministracaoForm', 'inicio.php');" 
            class="px-6 py-2.5 border-2 border-green-600 rounded-md text-green-600 hover:bg-green-600/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancelar
        </button>
        <button type="button" onclick="handleAvancar()" 
            class="px-6 py-2.5 bg-[#008000] text-white rounded-md hover:bg-[#008000]/90 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Avançar
        </button>
    </div>


    <!-- Modal para Nono Ano -->

        <div id="bimestreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg rounded-xl w-[70%]" style = "margin-top: -50px">
            <div class="bg-[#008000] p-3 rounded-t-xl">
            <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Notas 9º ano</h2>
        </div>
            <div class="bg-white p-4 rounded-lg shadow-sm">
                <!-- 1º Bimestre -->
                <div class="mb-6">
                
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                    <div>
                    <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-4 pb-1 border-b">1º Bimestre</h3>
                        </div>
                        <div>
                            <input type="text" name="lp9_1" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="m9_1" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="h9_1" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="g9_1" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="c9_1" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="i9_1" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="a9_1" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="ef9_1" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="r9_1" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                    </div>
                </div>

                <!-- 2º Bimestre -->
                <div class="mb-6">
                
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                    <div>
                        <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-4 pb-1 border-b">2º Bimestre</h3>
                        </div>
                        <div>
                            <input type="text" name="lp9_2" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="m9_2" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="h9_2" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="g9_2" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="c9_2" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="i9_2" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="a9_2" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="ef9_2" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="r9_2" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                    </div>
                </div>

                <!-- 3º Bimestre -->
                <div class="mb-6">
                    
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                        <div>
                        <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-4 pb-1 border-b">3º Bimestre</h3>
                        </div>
                        <div>
                            <input type="text" name="lp9_3" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="m9_3" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="h9_3" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="g9_3" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="c9_3" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="i9_3" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="a9_3" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="ef9_3" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)">
                        </div>
                        <div>
                            <input type="text" name="r9_3" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" required oninput="maskNota(this)">
                        </div>
                    </div>
                </div>
                <!-- 4º Bimestre -->
    <!-- 4º Bimestre -->
<!-- 4º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#008000] mb-4 pb-1 border-b">Média Geral</h3>
        </div>
        <div>
            <input type="text" name="lp9_4" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_4" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_4" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_4" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_4" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_4" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_4" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_4" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_4" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#008000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>
    <div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
            <button type="button" onclick="hideBimestreModal()" 
                class="px-6 py-2.5 border-2 border-[#008000] rounded-md text-[#008000] hover:bg-[#008000]/10 text-base flex items-center font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Voltar
            </button>
            <button type="submit" 
                class="px-6 py-2.5 bg-[#008000] text-white rounded-md hover:bg-[#008000]/90 text-base flex items-center font-medium">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Cadastrar
            </button>
        </div>
    </div>
            </div>
        </div>
    </div>
        
        </div>
        
    </div>

    </form>
    `;
}




function Event() {
    const inputs4Bimestre = document.querySelectorAll(
        'input[name="lp9_4"], input[name="m9_4"], input[name="h9_4"], input[name="g9_4"], input[name="c9_4"], input[name="i9_4"], input[name="a9_4"], input[name="ef9_4"], input[name="r9_4"]'
    );

    const inputs123Bimestre = document.querySelectorAll(
        'input[name="lp9_1"], input[name="m9_1"], input[name="h9_1"], input[name="g9_1"], input[name="c9_1"], input[name="i9_1"], input[name="a9_1"], input[name="ef9_1"], input[name="r9_1"], ' +
        'input[name="lp9_2"], input[name="m9_2"], input[name="h9_2"], input[name="g9_2"], input[name="c9_2"], input[name="i9_2"], input[name="a9_2"], input[name="ef9_2"], input[name="r9_2"], ' +
        'input[name="lp9_3"], input[name="m9_3"], input[name="h9_3"], input[name="g9_3"], input[name="c9_3"], input[name="i9_3"], input[name="a9_3"], input[name="ef9_3"], input[name="r9_3"]'
    );

    function check4Bimestre() {
        return Array.from(inputs4Bimestre).some(input => input.value.trim() !== '');
    }

    function check123Bimestre() {
        return Array.from(inputs123Bimestre).some(input => input.value.trim() !== '');
    }

    function updateInputsState() {
        const has4BimestreValue = check4Bimestre();
        const has123BimestreValue = check123Bimestre();

        inputs123Bimestre.forEach(input => {
            input.disabled = has4BimestreValue;
        });

        inputs4Bimestre.forEach(input => {
            input.disabled = has123BimestreValue;
        });
    }

   
    inputs4Bimestre.forEach(input => {
        input.addEventListener('input', updateInputsState);
    });

    inputs123Bimestre.forEach(input => {
        input.addEventListener('input', updateInputsState);
    });

   
    updateInputsState();
}

document.addEventListener('DOMContentLoaded', Event);

function handleAvancar() {
    // Personal Information Fields
    const personalFields = [
        document.querySelector('input[name="nome"]'),
        document.querySelector('input[name="nasc"]'),
        document.querySelector('select[name="bairro"]')
    ];

    // Required Grade Fields
    const requiredFields = document.querySelectorAll(
        'input[name="lp6"], input[name="a6"], input[name="m6"], input[name="h6"], input[name="g6"], input[name="c6"], input[name="i6"], input[name="r6"],' +
        'input[name="lp7"], input[name="a7"], input[name="m7"], input[name="h7"], input[name="g7"], input[name="c7"], input[name="i7"], input[name="r7"],' +
        'input[name="lp8"], input[name="a8"], input[name="m8"], input[name="h8"], input[name="g8"], input[name="c8"], input[name="i8"], input[name="r8"]'
    );

   
    const personalInfoValid = personalFields.every(field => field.value.trim() !== '');


    const gradeFieldsValid = Array.from(requiredFields).every(field => field.value.trim() !== '');

    if (personalInfoValid && gradeFieldsValid) {
      
        document.getElementById('bimestreModal').classList.remove('hidden');
    } else {
       
        if (!personalInfoValid) {
            alert('Por favor, preencha todas as informações pessoais (Nome, Data de Nascimento, Bairro).');
        } else {
            alert('Por favor, preencha todas as notas dos anos 6º, 7º e 8º antes de avançar.');
        }
    }
}

// Function to handle closing the modal
function hideBimestreModal() {
    document.getElementById('bimestreModal').classList.add('hidden');
}
function maskNota(input) {
    // Remove tudo exceto números e ponto
    let value = input.value.replace(/[^0-9.]/g, '');
    
    // Remove pontos extras (mantém apenas o primeiro)
    const parts = value.split('.');
    if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
    }

    // Caso especial para 100
    if (value === '100' || value === '1.00') {
        value = '10.0';
        input.value = value;
        return;
    }

    // Se não tiver ponto e tiver 2 ou mais dígitos, insere o ponto após o primeiro dígito
    if (!value.includes('.') && value.length >= 2) {
        value = value.slice(0, 1) + '.' + value.slice(1);
    }

    // Garante que temos no máximo 2 casas decimais
    if (value.includes('.')) {
        const decimals = value.split('.')[1];
        if (decimals.length > 2) {
            value = value.slice(0, value.indexOf('.') + 3);
        }
    }

    // Converte para número e verifica se é maior que 10
    const numericValue = parseFloat(value);
    if (numericValue > 10) {
        // Pega apenas o primeiro dígito e adiciona .0
        value = value[0] + '.0';
    }

    // Atualiza o valor no input
    input.value = value;
}
function showBimestreModal() {
    document.getElementById('bimestreModal').classList.remove('hidden');
}

function hideBimestreModal() {
    document.getElementById('bimestreModal').classList.add('hidden');
}

function showBimestreModal() {
    document.getElementById('bimestreModal').classList.remove('hidden');
}

function closeBimestreModal() {
    document.getElementById('bimestreModal').classList.add('hidden');
}

function showNonoAnoModal(bimestre) {
    document.getElementById('bimestreModal').classList.add('hidden');
    document.getElementById('nonoAnoModal').classList.remove('hidden');
}

function closeNonoAnoModal() {
    document.getElementById('nonoAnoModal').classList.add('hidden');
    document.getElementById('bimestreModal').classList.remove('hidden');
}


function submitForm() {
    document.getElementById('EnfermagemForm').submit();
}

function closeModalAndRedirect(formId, redirectUrl) {
    document.getElementById(formId).reset();
    document.getElementById('bimestreModal').classList.add('hidden');
    document.getElementById('nonoAnoModal').classList.add('hidden');
    window.location.href = redirectUrl;
}
function createInformaticaForm(schoolType) {
    return `
<form id="InformaticaForm" action="../controllers/controller.php" method="POST" class="w-auto bg-[--ceara-white] rounded-xl shadow-md">
    <!-- Cabeçalho -->
    <div class="bg-[#4a90e2] p-3 rounded-t-xl">
        <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Formulário de Informatica</h2>
    </div>

    <!-- Informações Pessoais -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 p-4">
        <div class="flex flex-col md:col-span-6">
            <input type="text" name="nome" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#0000ff] w-full text-center"  oninput="removeAccents(this)"  placeholder="Nome Completo" required>
        </div>
     <div class="flex flex-col md:col-span-1">
    <input type="text" name="nasc" maxlength="10" placeholder="DD/MM/AAAA" 
           class="px-6 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#0000ff] w-full" 
           oninput="maskNascimento(this)" required>
</div>

        <div class="flex flex-col md:col-span-1">
            <input type="text" name="curso" value="Informática" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
            <input type="hidden" name="curso" value="Informática">
        </div>

        <div class="flex flex-col md:col-span-1">
            <input type="text" name="${schoolType}" value="${schoolType}" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
            <input type="hidden" name="publica" value="${schoolType}">
        </div>

        <div class="flex flex-col md:col-span-2">
            <select name="bairro" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#0000ff] w-full" required>
                <option value="">Selecione um bairro</option>
                <option value="Outra Banda">Outra Banda</option>
                <option value="Outros Bairros">Outros Bairros</option>
            </select>
        </div>

        <div class="flex items-center md:col-span-1">
            <label for="pcd" class="text-sm text-[--gray-600] mr-2">PCD</label>
            <input type="checkbox" id="pcd" name="pcd" value="1" class="w-4 h-4 text-[#0000ff] border border-[--gray-600] rounded">
        </div>
    </div>

    <!-- Notas -->
  <div class="space-y-3 px-4">
    <!-- 6º Ano -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
     
   

   <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
              <div>
                <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-2 pb-1 border-b">6º Ano</h3>
            </div>

            <!-- Português -->
            <input type="text" name="lp6" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Artes -->
            <input type="text" name="a6" placeholder="ARTES" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Matemática -->
            <input type="text" name="m6" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- História -->
            <input type="text" name="h6" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Geografia -->
            <input type="text" name="g6" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ciências -->
            <input type="text" name="c6" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Inglês -->
            <input type="text" name="i6" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ed. Física -->
            <input type="text" name="ef6" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" oninput="maskNota(this)">
            <!-- Religião -->
            <input type="text" name="r6" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
        </div>
    </div>

    <!-- 7º Ano -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
       
        <!-- Grid responsivo -->
       <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
              <div>
                <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-2 pb-1 border-b">7º Ano</h3>
            </div>
            <!-- Português -->
            <input type="text" name="lp7" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Artes -->
            <input type="text" name="a7" placeholder="ARTES" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Matemática -->
            <input type="text" name="m7" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- História -->
            <input type="text" name="h7" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Geografia -->
            <input type="text" name="g7" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ciências -->
            <input type="text" name="c7" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Inglês -->
            <input type="text" name="i7" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ed. Física -->
            <input type="text" name="ef7" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" oninput="maskNota(this)">
            <!-- Religião -->
            <input type="text" name="r7" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
        </div>
    </div>
    <!-- 8º Ano -->
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                <div>
                    <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-2 pb-1 border-b">8º Ano</h3>
                </div>
                <div>
                    <input type="text" name="lp8" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="a8" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="m8" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="h8" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="g8" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="c8" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="i8" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="ef8" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="r8" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)">
                </div>
            </div>
        </div>
    </div>
<div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="closeModalAndRedirect('InformaticaForm', 'inicio.php');" 
            class="px-6 py-2.5 border-2 border-[#4a90e2] rounded-md text-[#4a90e2] hover:bg-[#4a90e2]/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancelar
        </button>
      <button type="button" onclick="handleAvancar()" 
    class="px-6 py-2.5 bg-[#4a90e2] text-white rounded-md hover:bg-[#4a90e2]/90 text-base flex items-center font-medium">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    Avançar
</button>
</div>

<!-- Modal para Nono Ano -->

       <div id="bimestreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg rounded-xl w-[70%]" style = "margin-top: -50px">
         <div class="bg-[#4a90e2] p-3 rounded-t-xl">
        <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Notas 9º ano</h2>
    </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <!-- 1º Bimestre -->
                        <div class="mb-6">
                
     <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-4 pb-1 border-b">1º Bimestre</h3>
    </div>
    <div>
        <input type="text" id="lp9_1" name="lp9_1" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="m9_1" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="h9_1" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="g9_1" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="c9_1" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="i9_1" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="a9_1" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="ef9_1" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="r9_1" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
</div>

<!-- 2º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-4 pb-1 border-b">2º Bimestre</h3>
        </div>
        <div>
            <input type="text" name="lp9_2" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_2" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_2" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_2" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_2" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_2" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_2" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_2" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_2" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>


<!-- 3º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-4 pb-1 border-b">3º Bimestre</h3>
        </div>
        <div>
            <input type="text" name="lp9_3" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_3" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_3" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_3" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_3" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_3" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_3" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_3" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_3" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>

<!-- 4º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#4a90e2] mb-4 pb-1 border-b">Média Geral</h3>
        </div>
        <div>
            <input type="text" name="lp9_4" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_4" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_4" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_4" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_4" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_4" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_4" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_4" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_4" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a90e2] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>
     <div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="hideBimestreModal()" 
            class="px-6 py-2.5 border-2 border-[#4a90e2] rounded-md text-[#4a90e2] hover:bg-[#4a90e2]/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </button>
        <button type="submit" 
            class="px-6 py-2.5 bg-[#4a90e2] text-white rounded-md hover:bg-[#4a90e2]/90 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Cadastrar
        </button>
    </div>
</div>
        </div>
    </div>
</div>
       
    </div>
    
</div>
</form>

`;
}
// Função específica para o formulário de Administração
function createLogisticaForm(schoolType) {
    return `
<form id="LogísticaForm" action="../controllers/controller.php" method="POST" class="w-auto bg-[--ceara-white] rounded-xl shadow-md">
    <!-- Cabeçalho -->
    <div class="bg-[#FF0000] p-3 rounded-t-xl">
        <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Formulário de Logística</h2>
    </div>

    <!-- Informações Pessoais -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 p-4">
        <div class="flex flex-col md:col-span-6">
            <input type="text" name="nome" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#FF0000] w-full text-center"  oninput="removeAccents(this)"  placeholder="Nome Completo" required>
        </div>

         <div class="flex flex-col md:col-span-1">
    <input type="text" name="nasc" maxlength="10" placeholder="DD/MM/AAAA" 
           class="px-6 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#FF0000] w-full" 
           oninput="maskNascimento(this)" required>
</div>

        <div class="flex flex-col md:col-span-1">
            <input type="text" name="curso" value="Logística" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
            <input type="hidden" name="curso" value="Logística">
        </div>

        <div class="flex flex-col md:col-span-1">
            <input type="text" name="${schoolType}" value="${schoolType}" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
            <input type="hidden" name="publica" value="${schoolType}">
        </div>

        <div class="flex flex-col md:col-span-2">
            <select name="bairro" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#FF0000] w-full" required>
                <option value="">Selecione um bairro</option>
                <option value="Outra Banda">Outra Banda</option>
                <option value="Outros Bairros">Outros Bairros</option>
            </select>
        </div>

        <div class="flex items-center md:col-span-1">
            <label for="pcd" class="text-sm text-[--gray-600] mr-2">PCD</label>
            <input type="checkbox" id="pcd" name="pcd" value="1" class="w-4 h-4 text-[#FF0000] border border-[--gray-600] rounded">
        </div>
    </div>

     <!-- Notas -->
  <div class="space-y-3 px-4">
    <!-- 6º Ano -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
   
        <!-- Grid responsivo -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
              <div>
                <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-2 pb-1 border-b">6º Ano</h3>
            </div>
            <!-- Português -->
            <input type="text" name="lp6" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Artes -->
            <input type="text" name="a6" placeholder="ARTES" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Matemática -->
            <input type="text" name="m6" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- História -->
            <input type="text" name="h6" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Geografia -->
            <input type="text" name="g6" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ciências -->
            <input type="text" name="c6" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Inglês -->
            <input type="text" name="i6" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ed. Física -->
            <input type="text" name="ef6" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" oninput="maskNota(this)">
            <!-- Religião -->
            <input type="text" name="r6" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
        </div>
    </div>

    <!-- 7º Ano -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
      
        <!-- Grid responsivo -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
              <div>
                <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-2 pb-1 border-b">7º Ano</h3>
            </div>
            <!-- Português -->
            <input type="text" name="lp7" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Artes -->
            <input type="text" name="a7" placeholder="ARTES" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Matemática -->
            <input type="text" name="m7" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- História -->
            <input type="text" name="h7" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Geografia -->
            <input type="text" name="g7" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ciências -->
            <input type="text" name="c7" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Inglês -->
            <input type="text" name="i7" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ed. Física -->
            <input type="text" name="ef7" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" oninput="maskNota(this)">
            <!-- Religião -->
            <input type="text" name="r7" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
        </div>
    </div>

    <!-- 8º Ano -->
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                <div>
                    <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-2 pb-1 border-b">8º Ano</h3>
                </div>
                <div>
                    <input type="text" name="lp8" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="a8" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="m8" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="h8" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="g8" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="c8" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="i8" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="ef8" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="r8" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)">
                </div>
            </div>
        </div>
    </div>

 <div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="closeModalAndRedirect('LogísticaForm', 'inicio.php');" 
            class="px-6 py-2.5 border-2 border-[#FF0000] rounded-md text-[#FF0000] hover:bg-[#FF0000]/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancelar
        </button>
      <button type="button" onclick="handleAvancar()" 
    class="px-6 py-2.5 bg-[#FF0000] text-white rounded-md hover:bg-[#FF0000]/90 text-base flex items-center font-medium">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    Avançar
</button>
</div>
                

<!-- Modal para Nono Ano -->

      <div id="bimestreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg rounded-xl w-[70%]" style = "margin-top: -50px">
         <div class="bg-[#FF0000] p-3 rounded-t-xl">
        <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Notas 9º ano</h2>
    </div>
    
        <div class="bg-white p-4 rounded-lg shadow-sm">
        
            <!-- 1º Bimestre -->
                        <div class="mb-6">
                
     <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-4 pb-1 border-b">1º Bimestre</h3>
    </div>
    <div>
        <input type="text" id="lp9_1" name="lp9_1" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="m9_1" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="h9_1" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="g9_1" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="c9_1" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="i9_1" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="a9_1" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="ef9_1" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="r9_1" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
</div>

<!-- 2º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-4 pb-1 border-b">2º Bimestre</h3>
        </div>
        <div>
            <input type="text" name="lp9_2" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_2" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_2" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_2" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_2" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_2" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_2" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_2" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_2" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>


<!-- 3º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-4 pb-1 border-b">3º Bimestre</h3>
        </div>
        <div>
            <input type="text" name="lp9_3" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_3" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_3" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_3" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_3" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_3" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_3" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_3" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_3" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>

<!-- 4º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#FF0000] mb-4 pb-1 border-b">Média Geral</h3>
        </div>
        <div>
            <input type="text" name="lp9_4" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_4" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_4" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_4" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_4" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_4" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_4" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_4" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_4" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#FF0000] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>
     <div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="hideBimestreModal()" 
            class="px-6 py-2.5 border-2 border-[#FF0000] rounded-md text-[#FF0000] hover:bg-[#FF0000]/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </button>
        <button type="submit" 
            class="px-6 py-2.5 bg-[#FF0000] text-white rounded-md hover:bg-[#FF0000]/90 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Cadastrar
        </button>
    </div>
</div>
        </div>
    </div>
</div>
       
    </div>
    
</div>
<form>

`;
}

// Função específica para o formulário de Edificações
function createRedesdecomputadoresForm(schoolType) {
    return `
<form id="RedesdeComputadoresForm"  action="../controllers/controller.php" method="POST" class="w-auto bg-[--ceara-white] rounded-xl shadow-md">
    <!-- Cabeçalho -->
    <div class="bg-[#4a4a4a] p-3 rounded-t-xl">
        <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Formulário de Redes de Computadores</h2>
    </div>

    <!-- Informações Pessoais -->
    <div class="grid grid-cols-1 md:grid-cols-6 gap-4 p-4">
        <div class="flex flex-col md:col-span-6">
            <input type="text" name="nome" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#4a4a4a] w-full text-center"  oninput="removeAccents(this)"  placeholder="Nome Completo" required>
        </div>

    <div class="flex flex-col md:col-span-1">
    <input type="text" name="nasc" maxlength="10" placeholder="DD/MM/AAAA" 
           class="px-6 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#4a4a4a] w-full" 
           oninput="maskNascimento(this)" required>
</div>

        <div class="flex flex-col md:col-span-1">
            <input type="text" name="curso" value="Redes de Computadores" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
            <input type="hidden" name="curso" value="Redes de Computadores">
        </div>

        <div class="flex flex-col md:col-span-1">
            <input type="text" name="${schoolType}" value="${schoolType}" class="px-3 py-1.5 bg-gray-50 border border-[--gray-600] rounded-md w-full" disabled>
            <input type="hidden" name="publica" value="${schoolType}">
        </div>

        <div class="flex flex-col md:col-span-2">
            <select name="bairro" class="px-3 py-1.5 border border-[--gray-600] rounded-md focus:ring-1 focus:ring-[#4a4a4a] w-full" required>
                <option value="">Selecione um bairro</option>
                <option value="Outra Banda">Outra Banda</option>
                <option value="Outros Bairros">Outros Bairros</option>
            </select>
        </div>

        <div class="flex items-center md:col-span-1">
            <label for="pcd" class="text-sm text-[--gray-600] mr-2">PCD</label>
            <input type="checkbox" id="pcd" name="pcd" value="1" class="w-4 h-4 text-[#4a4a4a] border border-[--gray-600] rounded">
        </div>
    </div>

    <!-- Notas -->
  <div class="space-y-3 px-4">
    <!-- 6º Ano -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
    
        <!-- Grid responsivo -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
              <div>
                <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-2 pb-1 border-b">9º Ano</h3>
            </div>
            <!-- Português -->
            <input type="text" name="lp6" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Artes -->
            <input type="text" name="a6" placeholder="ARTES" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Matemática -->
            <input type="text" name="m6" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- História -->
            <input type="text" name="h6" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Geografia -->
            <input type="text" name="g6" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ciências -->
            <input type="text" name="c6" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Inglês -->
            <input type="text" name="i6" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ed. Física -->
            <input type="text" name="ef6" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" oninput="maskNota(this)">
            <!-- Religião -->
            <input type="text" name="r6" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
        </div>
    </div>

    <!-- 7º Ano -->
    <div class="bg-white p-4 rounded-lg shadow-sm">
      
        <!-- Grid responsivo -->
   <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
              <div>
                <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-2 pb-1 border-b">7º Ano</h3>
            </div>
            <!-- Português -->
            <input type="text" name="lp7" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Artes -->
            <input type="text" name="a7" placeholder="ARTES" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Matemática -->
            <input type="text" name="m7" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- História -->
            <input type="text" name="h7" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Geografia -->
            <input type="text" name="g7" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ciências -->
            <input type="text" name="c7" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Inglês -->
            <input type="text" name="i7" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
            <!-- Ed. Física -->
            <input type="text" name="ef7" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" oninput="maskNota(this)">
            <!-- Religião -->
            <input type="text" name="r7" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1 border border-gray-600 rounded-md text-center text-sm focus:ring-1 focus:ring-[#0000ff]" required oninput="maskNota(this)">
        </div>
    </div>

    <!-- 8º Ano -->
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
                <div>
                    <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-2 pb-1 border-b">8º Ano</h3>
                </div>
                <div>
                    <input type="text" name="lp8" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="a8" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="m8" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="h8" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="g8" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="c8" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="i8" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="ef8" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)">
                </div>
                <div>
                    <input type="text" name="r8" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)">
                </div>
            </div>
        </div>
    </div>
<div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="closeModalAndRedirect('RedesdeComputadoresForm', 'inicio.php');" 
            class="px-6 py-2.5 border-2 border-[#4a4a4a] rounded-md text-[#4a4a4a] hover:bg-[#4a4a4a]/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Cancelar
        </button>
      <button type="button" onclick="handleAvancar()" 
    class="px-6 py-2.5 bg-[#4a4a4a] text-white rounded-md hover:bg-[#4a4a4a]/90 text-base flex items-center font-medium">
    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
    </svg>
    Avançar
</button>
</div>

    </div>
<!-- Modal para Nono Ano -->
  <div id="bimestreModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg rounded-xl w-[70%]" style = "margin-top: -50px">
         <div class="bg-[#4a4a4a] p-3 rounded-t-xl">
        <h2 class="text-3xl font-bold text-[--ceara-white] text-center mb-2">Notas 9º ano</h2>
    </div>
        <div class="bg-white p-4 rounded-lg shadow-sm">
            <!-- 1º Bimestre -->
                        <div class="mb-6">
                
     <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
    <div>
        <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-4 pb-1 border-b">1º Bimestre</h3>
    </div>
    <div>
        <input type="text" id="lp9_1" name="lp9_1" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="m9_1" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="h9_1" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="g9_1" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="c9_1" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="i9_1" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="a9_1" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="ef9_1" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
    </div>
    <div>
        <input type="text" name="r9_1" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
    </div>
</div>

<!-- 2º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-4 pb-1 border-b">2º Bimestre</h3>
        </div>
        <div>
            <input type="text" name="lp9_2" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_2" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_2" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_2" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_2" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_2" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_2" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_2" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_2" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>


<!-- 3º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-4 pb-1 border-b">3º Bimestre</h3>
        </div>
        <div>
            <input type="text" name="lp9_3" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_3" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_3" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_3" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_3" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_3" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_3" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_3" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_3" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" required oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>

<!-- 4º Bimestre -->
<div class="mb-6">
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-10 gap-2 md:gap-3">
        <div>
            <h3 class="text-lg md:text-xl font-semibold text-[#4a4a4a] mb-4 pb-1 border-b">Média Geral</h3>
        </div>
        <div>
            <input type="text" name="lp9_4" placeholder="PORTUGUÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="m9_4" placeholder="MATEMÁTICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="h9_4" placeholder="HISTÓRIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="g9_4" placeholder="GEOGRAFIA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="c9_4" placeholder="CIÊNCIAS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="i9_4" placeholder="INGLÊS" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="a9_4" placeholder="ARTES" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="ef9_4" placeholder="ED. FÍSICA" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
        <div>
            <input type="text" name="r9_4" placeholder="RELIGIÃO" class="w-full mt-1 px-2 py-1.5 border border-[--gray-600] rounded-md text-center focus:ring-1 focus:ring-[#4a4a4a] text-sm" oninput="maskNota(this)" onkeypress="Event()">
        </div>
    </div>
</div>
    <div class="flex justify-center space-x-4 mt-4 pt-3 border-t px-4 pb-4">
        <button type="button" onclick="hideBimestreModal()" 
            class="px-6 py-2.5 border-2 border-[#4a4a4a] rounded-md text-[#4a4a4a] hover:bg-[#4a4a4a]/10 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Voltar
        </button>
        <button type="submit" 
            class="px-6 py-2.5 bg-[#4a4a4a] text-white rounded-md hover:bg-[#4a4a4a]/90 text-base flex items-center font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Cadastrar
        </button>
    </div>
</div>
        </div>
    </div>
</div>
       
    </div>
    
</div>

<form>
`;
}


function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.style.display = 'none'; // Esconde o modal
    }
}

// Função para fechar o modal e redirecionar
function closeModalAndRedirect(modalId, redirectUrl) {
    closeModal(modalId);
    window.location.href = redirectUrl; // Redireciona para a página inicial
}
function validateAndCollectData(courseName) {
    const form = document.getElementById(`gradeForm_${courseName}`);

    if (!form.checkValidity()) {
        showError('Por favor, preencha todos os campos corretamente');
        return false;
    }

    return collectFormData(courseName);
}

function collectFormData(courseName) {
    const formData = {
        courseName: courseName,
        name: document.getElementById(`name_${courseName}`).value,
        birthDate: document.getElementById(`birthDate_${courseName}`).value
    };

    const subjects = ['lp', 'ar', 'ef', 'li', 'ci', 'ge', 'hi', 're', 'ma'];

    [6, 7, 8, 9].forEach(year => {
        subjects.forEach(subject => {
            const inputId = `${subject}${year}_${courseName}`;
            const input = document.getElementById(inputId);
            if (input) {
                formData[inputId] = parseFloat(input.value) || 0;
            }
        });
    });

    console.log(formData); // Para verificar os dados coletados
    return formData;
}

// Funções de formatação e validação de notas
function formatGrade(input) {
    // Lógica para formatar a nota
}

function validateGrade(input) {
    // Lógica para validar a nota
}

function showError(message) {
    // Função para exibir mensagens de erro
}

// Exporta as funções necessárias
window.administracaoPub = administracaoPub;
window.administracaoPriv = administracaoPriv;
window.logisticaPub = enfermagemPub;
window.logisticaPriv = enfermagemPriv;
window.informaticaPub = informaticaPub;
window.informaticaPriv = informaticaPriv;
window.redesComputadoresPub = redesComputadoresPub;
window.redesComputadoresPriv = redesComputadoresPriv;



