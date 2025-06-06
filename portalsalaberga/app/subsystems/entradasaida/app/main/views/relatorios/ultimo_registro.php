<?php
require_once(__DIR__ . '/../../model/select_model.php');
$select = new select_model();

session_start();
function redirect_to_login()
{
    header('Location: ../../../../../../main/views/autenticacao/login.php');
}
if (!isset($_SESSION['Email'])) {
    session_destroy();
    redirect_to_login();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate, max-age=0">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <title>Relatório de Saídas</title>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'ceara-green': '#008C45',
                        'ceara-light-green': '#3CB371',
                        'ceara-olive': '#8CA03E',
                        'ceara-orange': '#FFA500',
                        primary: '#4CAF50',
                        secondary: '#FFB74D',
                        danger: '#dc3545',
                        admin: '#0dcaf0',
                        grey: '#6c757d',
                        info: '#4169E1'
                    },
                },
            },
        };

        // Força atualização da página e limpa cache
        if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
            window.location.reload(true);
        }
        
        // Limpa cache do navegador
        if ('caches' in window) {
            caches.keys().then(function(names) {
                for (let name of names) {
                    caches.delete(name);
                }
            });
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: #f8fafc;
            min-height: 100vh;
            position: relative;
            padding-bottom: 100px;
        }

        .main-container {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        /* Estilos para Cards (Mobile) */
        .class-card {
            background: white;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .class-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        }

        .student-card {
            background: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 8px 12px;
            margin-bottom: 6px;
            transition: all 0.2s ease;
        }

        .student-card:hover {
            background: #f3f4f6;
        }

        /* Estilos para Tabelas (Desktop) */
        .table-container {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            border: 1px solid #e5e7eb;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .table-header {
            background: linear-gradient(90deg, #008C45, #3CB371);
            color: white;
            padding: 12px 16px;
        }

        .table-content {
            flex: 1;
            overflow-y: auto;
            max-height: 600px;
        }

        .table-row {
            border-bottom: 1px solid #f3f4f6;
            transition: background-color 0.2s ease;
        }

        .table-row:hover {
            background-color: #f9fafb;
        }

        .table-row:last-child {
            border-bottom: none;
        }

        /* Classes específicas para cada turma */
        .turma-3a .table-header {
            background: linear-gradient(90deg, #dc3545, #c82333);
        }

        .turma-3b .table-header {
            background: linear-gradient(90deg, #4169E1, #3651d1);
        }

        .turma-3c .table-header {
            background: linear-gradient(90deg, #0dcaf0, #0bb5d6);
        }

        .turma-3d .table-header {
            background: linear-gradient(90deg, #6c757d, #5a6268);
        }

        .card-header-3a {
            background: linear-gradient(90deg, #dc3545, #c82333);
        }

        .card-header-3b {
            background: linear-gradient(90deg, #4169E1, #3651d1);
        }

        .card-header-3c {
            background: linear-gradient(90deg, #0dcaf0, #0bb5d6);
        }

        .card-header-3d {
            background: linear-gradient(90deg, #6c757d, #5a6268);
        }

        .gradient-text {
            background: linear-gradient(45deg, #008C45, #3CB371);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Responsividade */
        .desktop-view {
            display: none;
        }

        .mobile-view {
            display: block;
        }

        @media (min-width: 1024px) {
            .desktop-view {
                display: block;
            }

            .mobile-view {
                display: none;
            }
        }

        /* Scrollbar personalizada */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }

        /* Otimizações para muitos alunos */
        .compact-table td {
            padding-top: 6px;
            padding-bottom: 6px;
            font-size: 0.875rem;
        }

        .compact-table th {
            position: sticky;
            top: 0;
            z-index: 10;
            background-color: #f9fafb;
        }

        .compact-cards {
            max-height: 400px;
            overflow-y: auto;
        }

        .compact-card {
            padding: 8px 12px;
            margin-bottom: 4px;
        }

        /* Filtro de busca */
        .search-input {
            background-color: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: white;
            border-radius: 6px;
            padding: 4px 12px;
            width: 100%;
            max-width: 200px;
            font-size: 0.875rem;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-input:focus {
            outline: none;
            background-color: rgba(255, 255, 255, 0.3);
        }

        /* Paginação */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin-top: 8px;
            padding: 8px;
            border-top: 1px solid #f3f4f6;
        }

        .pagination-btn {
            padding: 4px 8px;
            border-radius: 4px;
            background: #f3f4f6;
            color: #374151;
            font-size: 0.75rem;
            cursor: pointer;
        }

        .pagination-btn.active {
            background: #008C45;
            color: white;
        }

        /* Footer geométrico */
        .geometric-footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100px;
            z-index: -1;
            overflow: hidden;
        }

        .geometric-shape {
            position: absolute;
            bottom: 0;
        }

        .shape-1 {
            left: 0;
            width: 0;
            height: 0;
            border-left: 200px solid #FFA500;
            border-top: 100px solid transparent;
        }

        .shape-2 {
            left: 150px;
            width: 0;
            height: 0;
            border-left: 250px solid #8CA03E;
            border-top: 80px solid transparent;
            opacity: 0.9;
        }

        .shape-3 {
            left: 350px;
            width: 0;
            height: 0;
            border-left: 300px solid #008C45;
            border-top: 60px solid transparent;
            opacity: 0.8;
        }

        .shape-4 {
            right: 0;
            width: 0;
            height: 0;
            border-right: 200px solid #FFA500;
            border-top: 100px solid transparent;
            opacity: 0.7;
        }

        .shape-5 {
            right: 150px;
            width: 0;
            height: 0;
            border-right: 250px solid #8CA03E;
            border-top: 80px solid transparent;
            opacity: 0.6;
        }

        .shape-6 {
            right: 350px;
            width: 0;
            height: 0;
            border-right: 300px solid #008C45;
            border-top: 60px solid transparent;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .shape-1 {
                border-left-width: 120px;
            }

            .shape-2 {
                border-left-width: 150px;
                left: 100px;
            }

            .shape-3 {
                border-left-width: 180px;
                left: 200px;
            }

            .shape-4 {
                border-right-width: 120px;
            }

            .shape-5 {
                border-right-width: 150px;
                right: 100px;
            }

            .shape-6 {
                border-right-width: 180px;
                right: 200px;
            }
        }
    </style>
</head>

<body class="min-h-screen p-4 lg:p-8">
    <!-- QR Code Reader -->
    <div id="reader" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>
    <input type="text" id="urlInput" placeholder="URL será inserida aqui automaticamente" style="position: fixed; top: -100px; opacity: 0;" />

    <div class="main-container max-w-7xl mx-auto p-6 lg:p-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <div class="flex flex-col lg:flex-row items-center justify-center gap-4">
                <h1 class="text-2xl lg:text-3xl font-semibold">
                    <span class="gradient-text">Relatório de Frequências em:</span>
                </h1>
                <div class="inline-flex items-center bg-white rounded-lg px-4 py-2 shadow-sm border">
                    <i class="fas fa-calendar-day text-ceara-green mr-2"></i>
                    <span class="text-base font-medium text-gray-700"><?php echo date('d/m/Y'); ?></span>
                </div>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                <i class="fas fa-info-circle mr-1"></i>
                Mostrando alunos que saíram para estágio hoje
            </div>
        </div>

        <!-- Vista Desktop (Tabelas) -->   




        
        <div class="desktop-view">
            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- 3º Ano A -->
                <div class="table-container turma-3a">
                    <div class="table-header">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano A
                            </h2>
                            <?php
                            $dados_3a = $select->saida_estagio_3A();
                            $count_3a = count($dados_3a);
                            ?>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                                <?= $count_3a ?> alunos
                            </span>
                        </div>
                        <input type="text" class="search-input search-3a" placeholder="Buscar aluno..." onkeyup="filterTable('3a')">
                    </div>
                    <div class="table-content custom-scrollbar">
                        <table class="w-full compact-table" id="table-3a">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i>Nome do Aluno
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-clock mr-1"></i>Horário
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($dados_3a as $dado) { ?>
                                    <tr class="table-row">
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-graduate mr-2 text-danger"></i>
                                                <?= htmlspecialchars($dado['nome']) ?>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (empty($dados_3a)) { ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-500 italic">
                                            Nenhum aluno registrado hoje
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3º Ano B -->
                <div class="table-container turma-3b">
                    <div class="table-header">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano B
                            </h2>
                            <?php
                            $dados_3b = $select->saida_estagio_3B();
                            $count_3b = count($dados_3b);
                            ?>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                                <?= $count_3b ?> alunos
                            </span>
                        </div>
                        <input type="text" class="search-input search-3b" placeholder="Buscar aluno..." onkeyup="filterTable('3b')">
                    </div>
                    <div class="table-content custom-scrollbar">
                        <table class="w-full compact-table" id="table-3b">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i>Nome do Aluno
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-clock mr-1"></i>Horário
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($dados_3b as $dado) { ?>
                                    <tr class="table-row">
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-graduate mr-2 text-info"></i>
                                                <?= htmlspecialchars($dado['nome']) ?>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (empty($dados_3b)) { ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-500 italic">
                                            Nenhum aluno registrado hoje
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3º Ano C -->
                <div class="table-container turma-3c">
                    <div class="table-header">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano C
                            </h2>
                            <?php
                            $dados_3c = $select->saida_estagio_3C();
                            $count_3c = count($dados_3c);
                            ?>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                                <?= $count_3c ?> alunos
                            </span>
                        </div>
                        <input type="text" class="search-input search-3c" placeholder="Buscar aluno..." onkeyup="filterTable('3c')">
                    </div>
                    <div class="table-content custom-scrollbar">
                        <table class="w-full compact-table" id="table-3c">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i>Nome do Aluno
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-clock mr-1"></i>Horário
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($dados_3c as $dado) { ?>
                                    <tr class="table-row">
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-graduate mr-2 text-admin"></i>
                                                <?= htmlspecialchars($dado['nome']) ?>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (empty($dados_3c)) { ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-500 italic">
                                            Nenhum aluno registrado hoje
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 3º Ano D -->
                <div class="table-container turma-3d">
                    <div class="table-header">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano D
                            </h2>
                            <?php
                            $dados_3d = $select->saida_estagio_3D();
                            $count_3d = count($dados_3d);
                            ?>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium">
                                <?= $count_3d ?> alunos
                            </span>
                        </div>
                        <input type="text" class="search-input search-3d" placeholder="Buscar aluno..." onkeyup="filterTable('3d')">
                    </div>
                    <div class="table-content custom-scrollbar">
                        <table class="w-full compact-table" id="table-3d">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-user mr-1"></i>Nome do Aluno
                                    </th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <i class="fas fa-clock mr-1"></i>Horário
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                <?php foreach ($dados_3d as $dado) { ?>
                                    <tr class="table-row">
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            <div class="flex items-center">
                                                <i class="fas fa-user-graduate mr-2 text-grey"></i>
                                                <?= htmlspecialchars($dado['nome']) ?>
                                            </div>
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-500">
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php if (empty($dados_3d)) { ?>
                                    <tr>
                                        <td colspan="2" class="px-4 py-8 text-center text-gray-500 italic">
                                            Nenhum aluno registrado hoje
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vista Mobile (Cards) -->
        <div class="mobile-view">
            <div class="space-y-6">
                <!-- 3º Ano A -->
                <div class="class-card">
                    <div class="card-header-3a p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center text-white">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano A
                            </h2>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium text-white">
                                <?= $count_3a ?>
                            </span>
                        </div>
                        <input type="text" class="search-input search-mobile-3a" placeholder="Buscar aluno..." onkeyup="filterCards('3a')">
                    </div>
                    <div class="p-4 compact-cards custom-scrollbar" id="cards-3a">
                        <?php if ($count_3a > 0) { ?>
                            <?php foreach ($dados_3a as $index => $dado) { ?>
                                <div class="student-card compact-card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-red-100 text-danger text-xs font-medium">
                                                <?= $index + 1 ?>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900"><?= htmlspecialchars($dado['nome']) ?></span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($count_3a > 10) { ?>
                                <div class="pagination" id="pagination-3a">
                                    <!-- Paginação será gerada via JavaScript -->
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-center py-8 text-gray-500 italic">
                                Nenhum aluno registrado hoje
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- 3º Ano B -->
                <div class="class-card">
                    <div class="card-header-3b p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center text-white">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano B
                            </h2>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium text-white">
                                <?= $count_3b ?>
                            </span>
                        </div>
                        <input type="text" class="search-input search-mobile-3b" placeholder="Buscar aluno..." onkeyup="filterCards('3b')">
                    </div>
                    <div class="p-4 compact-cards custom-scrollbar" id="cards-3b">
                        <?php if ($count_3b > 0) { ?>
                            <?php foreach ($dados_3b as $index => $dado) { ?>
                                <div class="student-card compact-card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-blue-100 text-info text-xs font-medium">
                                                <?= $index + 1 ?>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900"><?= htmlspecialchars($dado['nome']) ?></span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($count_3b > 10) { ?>
                                <div class="pagination" id="pagination-3b">
                                    <!-- Paginação será gerada via JavaScript -->
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-center py-8 text-gray-500 italic">
                                Nenhum aluno registrado hoje
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- 3º Ano C -->
                <div class="class-card">
                    <div class="card-header-3c p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center text-white">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano C
                            </h2>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium text-white">
                                <?= $count_3c ?>
                            </span>
                        </div>
                        <input type="text" class="search-input search-mobile-3c" placeholder="Buscar aluno..." onkeyup="filterCards('3c')">
                    </div>
                    <div class="p-4 compact-cards custom-scrollbar" id="cards-3c">
                        <?php if ($count_3c > 0) { ?>
                            <?php foreach ($dados_3c as $index => $dado) { ?>
                                <div class="student-card compact-card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-cyan-100 text-admin text-xs font-medium">
                                                <?= $index + 1 ?>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900"><?= htmlspecialchars($dado['nome']) ?></span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($count_3c > 10) { ?>
                                <div class="pagination" id="pagination-3c">
                                    <!-- Paginação será gerada via JavaScript -->
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-center py-8 text-gray-500 italic">
                                Nenhum aluno registrado hoje
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <!-- 3º Ano D -->
                <div class="class-card">
                    <div class="card-header-3d p-4">
                        <div class="flex items-center justify-between mb-2">
                            <h2 class="text-lg font-semibold flex items-center text-white">
                                <i class="fas fa-users mr-2"></i>
                                3º Ano D
                            </h2>
                            <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-medium text-white">
                                <?= $count_3d ?>
                            </span>
                        </div>
                        <input type="text" class="search-input search-mobile-3d" placeholder="Buscar aluno..." onkeyup="filterCards('3d')">
                    </div>
                    <div class="p-4 compact-cards custom-scrollbar" id="cards-3d">
                        <?php if ($count_3d > 0) { ?>
                            <?php foreach ($dados_3d as $index => $dado) { ?>
                                <div class="student-card compact-card">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center rounded-full bg-gray-100 text-grey text-xs font-medium">
                                                <?= $index + 1 ?>
                                            </div>
                                            <span class="ml-3 font-medium text-gray-900"><?= htmlspecialchars($dado['nome']) ?></span>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-clock mr-1"></i>
                                            <?= isset($dado['hora_saida']) ? date('H:i', strtotime($dado['hora_saida'])) : '--:--' ?>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($count_3d > 10) { ?>
                                <div class="pagination" id="pagination-3d">
                                    <!-- Paginação será gerada via JavaScript -->
                                </div>
                            <?php } ?>
                        <?php } else { ?>
                            <div class="text-center py-8 text-gray-500 italic">
                                Nenhum aluno registrado hoje
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer com botão de atualização manual -->
        <div class="text-center mt-8">
            <button onclick="window.location.reload()" class="inline-flex items-center text-gray-600 bg-white rounded-lg px-4 py-2 shadow-sm border hover:bg-gray-50 transition-colors">
                <i class="fas fa-sync-alt mr-2 text-ceara-green"></i>
                <span class="text-sm">Atualizar dados</span>
            </button>
        </div>
    </div>

    <!-- Footer geométrico -->
    <div class="geometric-footer">
        <div class="geometric-shape shape-1"></div>
        <div class="geometric-shape shape-2"></div>
        <div class="geometric-shape shape-3"></div>
        <div class="geometric-shape shape-4"></div>
        <div class="geometric-shape shape-5"></div>
        <div class="geometric-shape shape-6"></div>
    </div>

    <script>
        // Função para filtrar tabelas
        function filterTable(turma) {
            const input = document.querySelector(`.search-${turma}`);
            const filter = input.value.toUpperCase();
            const table = document.getElementById(`table-${turma}`);
            const rows = table.getElementsByTagName('tr');

            for (let i = 1; i < rows.length; i++) { // Começar do 1 para pular o cabeçalho
                const nameCell = rows[i].getElementsByTagName('td')[0];
                if (nameCell) {
                    const nameText = nameCell.textContent || nameCell.innerText;
                    if (nameText.toUpperCase().indexOf(filter) > -1) {
                        rows[i].style.display = '';
                    } else {
                        rows[i].style.display = 'none';
                    }
                }
            }
        }

        // Função para filtrar cards
        function filterCards(turma) {
            const input = document.querySelector(`.search-mobile-${turma}`);
            const filter = input.value.toUpperCase();
            const container = document.getElementById(`cards-${turma}`);
            const cards = container.getElementsByClassName('student-card');

            for (let i = 0; i < cards.length; i++) {
                const nameText = cards[i].querySelector('span').textContent || cards[i].querySelector('span').innerText;
                if (nameText.toUpperCase().indexOf(filter) > -1) {
                    cards[i].style.display = '';
                } else {
                    cards[i].style.display = 'none';
                }
            }
        }

        // Função para inicializar paginação
        function initPagination() {
            const turmas = ['3a', '3b', '3c', '3d'];
            const itemsPerPage = 10;

            turmas.forEach(turma => {
                const container = document.getElementById(`cards-${turma}`);
                if (!container) return;

                const cards = container.getElementsByClassName('student-card');
                const totalPages = Math.ceil(cards.length / itemsPerPage);

                if (totalPages <= 1) return;

                const paginationContainer = document.getElementById(`pagination-${turma}`);
                if (!paginationContainer) return;

                // Criar botões de paginação
                let paginationHTML = '';
                for (let i = 1; i <= totalPages; i++) {
                    paginationHTML += `<span class="pagination-btn ${i === 1 ? 'active' : ''}" data-page="${i}">${i}</span>`;
                }
                paginationContainer.innerHTML = paginationHTML;

                // Mostrar apenas a primeira página inicialmente
                showPage(turma, 1, itemsPerPage);

                // Adicionar event listeners aos botões
                const buttons = paginationContainer.getElementsByClassName('pagination-btn');
                for (let i = 0; i < buttons.length; i++) {
                    buttons[i].addEventListener('click', function() {
                        const page = parseInt(this.getAttribute('data-page'));
                        showPage(turma, page, itemsPerPage);

                        // Atualizar classe ativa
                        for (let j = 0; j < buttons.length; j++) {
                            buttons[j].classList.remove('active');
                        }
                        this.classList.add('active');
                    });
                }
            });
        }

        // Função para mostrar uma página específica
        function showPage(turma, page, itemsPerPage) {
            const container = document.getElementById(`cards-${turma}`);
            const cards = container.getElementsByClassName('student-card');

            const startIndex = (page - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;

            for (let i = 0; i < cards.length; i++) {
                if (i >= startIndex && i < endIndex) {
                    cards[i].style.display = '';
                } else {
                    cards[i].style.display = 'none';
                }
            }
        }

        // Inicializar paginação quando o documento estiver pronto
        document.addEventListener('DOMContentLoaded', function() {
            initPagination();
        });
    </script>
    <script>
        // QR Code Reader functionality
        const input = document.getElementById('urlInput');
        const readerDiv = document.getElementById('reader');
        let leituraAtiva = false;
        let ultimaUrlAberta = null;
        let html5QrCode;

        // Função para manter o input sempre focado
        function manterFoco() {
            input.focus();
            setTimeout(manterFoco, 100);
        }

        function abrirEmNovaAba(url) {
            if (!url || url === ultimaUrlAberta) return;
            if (!url.startsWith('http://') && !url.startsWith('https://')) {
                url = 'https://' + url;
            }
            ultimaUrlAberta = url;
            window.location.href = url;
        }

        function onQRCodeScanned(decodedText) {
            input.value = decodedText;
            abrirEmNovaAba(decodedText);
        }

        // Inicia o leitor QR automaticamente quando a página carrega
        window.addEventListener('load', () => {
            // Limpa o histórico de URLs abertas
            ultimaUrlAberta = null;
            
            input.focus();
            manterFoco();
            readerDiv.style.display = 'block';
            html5QrCode = new Html5Qrcode("reader");

            html5QrCode.start(
                { facingMode: "environment" },
                { fps: 10, qrbox: 250 },
                onQRCodeScanned
            );

            leituraAtiva = true;
        });

        // Adiciona evento para abrir URL quando o usuário digita
        let timeoutId;
        input.addEventListener('input', (e) => {
            const url = e.target.value.trim();
            if (url) {
                if (timeoutId) clearTimeout(timeoutId);
                timeoutId = setTimeout(() => {
                    abrirEmNovaAba(url);
                }, 100);
            }
        });

        // Previne que o usuário perca o foco
        document.addEventListener('click', (e) => {
            e.preventDefault();
            input.focus();
        });

        // Força recarregamento da página se vier do cache
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });

        // Limpa o cache quando a página carrega
        window.onload = function() {
            // Força recarregamento da página
            if (!window.performance || !window.performance.navigation || window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
                window.location.reload(true);
            }

            // Limpa timings e memória
            if (window.performance) {
                if (window.performance.clearResourceTimings) window.performance.clearResourceTimings();
                if (window.performance.clearMarks) window.performance.clearMarks();
                if (window.performance.clearMeasures) window.performance.clearMeasures();
                if (window.performance.memory) window.performance.memory.usedJSHeapSize = 0;
            }

            // Limpa localStorage
            localStorage.clear();
            sessionStorage.clear();
        };
    </script>
</body>

</html>