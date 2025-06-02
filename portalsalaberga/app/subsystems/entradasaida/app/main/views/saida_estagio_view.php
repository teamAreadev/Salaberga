
 <?php
        
        session_start();
        if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
            echo '<div class="error">Você precisa estar logado para visualizar esta página.</div>';
            exit;
        }
        ?>

<!DOCTYPE html>

<html lang="pt-br">

<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaberga - Visualizar Saídas de Estágio</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: green;
            color: white;
            text-align: center;
            padding: 1em;
        }

        nav {
            background-color: #444;
            padding: 1em;
        }

        nav a {
            color: white;
            margin: 0 1em;
            text-decoration: none;
        }

        main {
            max-width: 1000px;
            margin: 2em auto;
            padding: 1em;
            background: white;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            padding: 1em;
            margin-bottom: 1em;
            border-radius: 4px;
        }

        footer {
            text-align: center;
            padding: 1em;
            background-color: #333;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
    <script>
        function fetchRegistros() {
            console.log("Buscando registros em saida_estagio_fetch.php...");
            fetch('saida_estagio_fetch.php')
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log("Resposta bruta:", text);
                    let data;
                    try {
                        data = JSON.parse(text);
                    } catch (e) {
                        throw new Error("Resposta não é JSON válido: " + text);
                    }
                    console.log("Dados JSON:", data);
                    const tbody = document.querySelector('#registros tbody');
                    tbody.innerHTML = ''; // Limpa a tabela
                    if (data.error) {
                        console.error("Erro retornado:", data.error);
                        tbody.innerHTML = `<tr><td colspan="4">Erro: ${data.error}</td></tr>`;
                        return;
                    }
                    if (data.length === 0) {
                        tbody.innerHTML = '<tr><td colspan="4">Nenhum registro encontrado.</td></tr>';
                        return;
                    }
                    data.forEach(registro => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${registro.id_saida}</td>
                            <td>${registro.nome_aluno}</td>
                            <td>${registro.curso}</td>
                            <td>${registro.dae}</td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error('Erro ao buscar registros:', error);
                    const tbody = document.querySelector('#registros tbody');
                    tbody.innerHTML = `<tr><td colspan="4">Erro ao carregar registros: ${error.message}</td></tr>`;
                });
        }

        // Chama a função ao carregar a página
        window.onload = fetchRegistros;
        // Atualiza automaticamente a cada 5 segundos
        setInterval(fetchRegistros, 5000);
    </script>
</head>

<body>
    <header>
        <h1>Salaberga</h1>
    </header>
    <nav>
        <a href="/inicio.php">Menu</a>
        <a href="saida_estagio.php">Registrar Saída de Estágio</a>
    </nav>
    <main>
        <h2>Registros de Saída de Estágio</h2>
       
        <table id="registros">
            <thead>
                <tr>
                    <th>ID Saída</th>
                    <th>Nome do Aluno</th>
                    <th>Curso</th>
                    <th>Data e Hora</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="4">Carregando registros...</td>
                </tr>
            </tbody>
        </table>
    </main>
    <footer>
        © 2025 Salaberga - Todos os direitos reservados
    </footer>
</body>

</html>