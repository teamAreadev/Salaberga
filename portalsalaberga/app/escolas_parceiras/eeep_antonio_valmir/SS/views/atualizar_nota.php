<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualização de Notas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-orange': '#FFA500',
                        'ceara-white': '#FFFFFF',
                        primary: '#4CAF50',
                        secondary: '#FFB74D',
                    }
                }
            }
        };

        let isEditing = false;

        function showSubjects() {
            const grade = document.getElementById('grade').value;
            const subjectsContainer = document.getElementById('subjectsContainer');
            const bimestreSection = document.getElementById('bimestreSection');

            subjectsContainer.innerHTML = '';

            let subjects = [];
            if (grade === '6' || grade === '7' || grade === '8' || grade === '9') {
                subjects = ['PORTUGUÊS', 'MATEMÁTICA', 'HISTÓRIA', 'GEOGRAFIA', 'CIÊNCIAS', 'INGLÊS', 'ARTES', 'ED. FÍSICA', 'RELIGIÃO'];
            }

            subjects.forEach(subject => {
                subjectsContainer.innerHTML += `
                    <div class="relative">
                        <label class="block text-gray-700 text-sm font-bold mb-2">${subject}</label>
                        <input type="text" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg text-center 
                            focus:ring-2 focus:ring-ceara-green focus:border-ceara-green"
                            placeholder="0.0"
                            disabled
                            oninput="maskNota(this)">
                    </div>
                `;
            });

            // Exibir ou ocultar a seção de bimestres
            bimestreSection.style.display = grade === '9' ? 'block' : 'none';
        }

        function maskNota(input) {
            let value = input.value.replace(/[^0-9.]/g, '');
            if (value.length > 0) {
                value = parseFloat(value);
                if (value > 10) value = 10;
                if (value < 0) value = 0;
                input.value = value.toFixed(1);
            }
        }

        function toggleEdit() {
            isEditing = !isEditing;
            const inputs = document.querySelectorAll('#subjectsContainer input');
            inputs.forEach(input => {
                input.disabled = !isEditing;
            });
        }

        function selectBimestre(bimestre) {
            const bimestreButtons = document.querySelectorAll('.bimestre-button');
            bimestreButtons.forEach(button => {
                button.classList.remove('bg-ceara-green', 'text-white');
                button.classList.add('bg-gray-200', 'text-gray-700');
            });
            const selectedButton = document.getElementById(bimestre);
            selectedButton.classList.add('bg-ceara-green', 'text-white');
            selectedButton.classList.remove('bg-gray-200', 'text-gray-700');
        }

        function saveNotes() {
            // Aqui você pode adicionar a lógica para salvar as notas
            alert('Notas salvas com sucesso!');
        }
    </script>
    <style>
        :root {
            --ceara-green: #008C45;
            --ceara-green-dark: #004d00;
            --ceara-orange: #FFA500;
            --ceara-white: #ffffff;
            --gray-600: #666666;
            --gray-dark: #333333;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <header class="bg-ceara-green rounded-lg shadow-lg p-6 mb-8">
            <h1 class="text-ceara-white text-3xl font-bold text-center">Sistema de Atualização de Notas</h1>
        </header>

        <!-- Main Content -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Student Info -->
            <div class="mb-8">
                <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                    <div class="flex-1 mb-4 md:mb-0">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="studentName">
                            Nome do Aluno
                        </label>
                        <input type="text" id="studentName" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ceara-green focus:border-ceara-green">
                    </div>
                    <div class="w-full md:w-1/4">
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="grade">
                            Série
                        </label>
                        <select id="grade" onchange="showSubjects()" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ceara-green focus:border-ceara-green">
                            <option value="6">6º Ano</option>
                            <option value="7">7º Ano</option>
                            <option value="8">8º Ano</option>
                            <option value="9">9º Ano</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Grades Section -->
            <div class="space-y-6">
                <!-- Bimestre Section -->
                <div id="bimestreSection" style="display: none;">
                    <div class="flex space-x-2 mb-6">
                        <button id="bimestre1" class="bimestre-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" onclick="selectBimestre('bimestre1')">1º Bimestre</button>
                        <button id="bimestre2" class="bimestre-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" onclick="selectBimestre('bimestre2')">2º Bimestre</button>
                        <button id="bimestre3" class="bimestre-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" onclick="selectBimestre('bimestre3')">3º Bimestre</button>
                        <button id="bimestre4" class="bimestre-button px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors" onclick="selectBimestre('bimestre4')">4º Bimestre</button>
                    </div>
                </div>

                <!-- Grades Grid -->
                <div id="subjectsContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <!-- As matérias serão exibidas aqui -->
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mt-8">
                <button class="px-6 py-2 bg-ceara-green text-white rounded-lg hover:bg-ceara-green-dark transition-colors" onclick="toggleEdit()">
                    Editar Notas
                </button>
                <button class="px-6 py-2 bg-primary text-white rounded-lg hover:bg-secondary transition-colors" onclick="saveNotes()">
                    Salvar
                </button>
            </div>
        </div>
    </div>
</body>
</html>