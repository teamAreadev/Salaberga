<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação Enviada com Sucesso!</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            color: #e5e7eb;
        }

        .success-container {
            background: #374151;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            border: 1px solid #4b5563;
        }

        .success-icon {
            color: #10b981; /* Verde de sucesso */
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .success-title {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .success-message {
            font-size: 1rem;
            color: #d1d5db;
            margin-bottom: 1.5rem;
        }

        .back-button {
            background: linear-gradient(135deg, #008C45 0%, #00A651 100%);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .back-button:hover {
            background: linear-gradient(135deg, #006B35 0%, #008C45 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 140, 69, 0.3);
        }
    </style>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="success-title">Avaliação Enviada com Sucesso!</div>
        <div class="success-message">Obrigado por enviar a avaliação. Os dados foram salvos.</div>
        <a href="subsytem/subsistema.php" class="back-button"><i class="fas fa-arrow-left mr-2"></i>Voltar ao Início</a>
    </div>
</body>
</html> 