<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Sala Berga - Seleção de Turma</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }

        .container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
        }

        h1 {
            color: #2c3e50;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.8rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        select {
            padding: 0.8rem;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 1rem;
            color: #2c3e50;
            background-color: white;
            cursor: pointer;
            transition: border-color 0.3s ease;
        }

        select:hover {
            border-color: #3498db;
        }

        select:focus {
            outline: none;
            border-color: #2980b9;
        }

        button {
            padding: 0.8rem;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #2980b9;
        }

        button:active {
            transform: scale(0.98);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Selecione a Turma</h1>
        <form action="qrcode.php" method="post">
            <select name="turma" id="turmajs">
                <option value="9">3°A</option>
                <option value="10">3°B</option>
                <option value="11">3°C</option>
                <option value="12">3°D</option>
            </select>
            <button type="submit">Gerar QR Code</button>
        </form>
    </div>
</body>
</html>