<?php
session_start();
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: ./view/paginainicial.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Página de login do sistema EEEP Salaberga">
    <meta name="keywords" content="login, EEEP Salaberga, escola, educação">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTcomDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" href="/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="../img/Design sem nome.svg" type="image/x-icon">
    <link rel="icon" href="/img/favicon.png" type="image/png">
    <title>Login - EEEP Salaberga</title>
    <style>
        :root {
            --primary-color: #4CAF50;
            --secondary-color: #FFB74D;
            --bg-color: #F0F2F5;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: var(--bg-color);
        }
        .retangulo {
            position: relative;
            width: 900px;
            height: 550px;
            background-color: #fff;
            border-radius: 15px;
            display: flex;
            align-items: center;
            box-shadow: 0 20px 40px var(--shadow-color);
            overflow: hidden;
        }
        .img-gradient {
            width: 45%;
            height: 100%;
            background: linear-gradient(40deg, #005A24, #FFA500);
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: #fff;
            padding: 2rem;
            text-align: center;
        }
        h1 {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        p {
            font-size: 1rem;
            line-height: 1.5;
        }
        .form-container {
            width: 55%;
            padding: 2rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        h2 {
            font-size: 2.5rem;
            font-weight: 900;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            text-align: center;
        }
        .form-control {
            background-color: #f5f5f5;
            border-radius: 5px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            width: 100%;
        }
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .input-group i {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2rem;
            cursor: pointer;
        }
        .btn-primary {
            background: linear-gradient(135deg, #007A33, #FF8C00);
            color: #F0F2F5;
            border: none;
            font-weight: 600;
            font-size: 1.1rem;
            padding: 0.75rem 1rem;
            border-radius: 5px;
            width: 100%;
        }
        .btn-primary:hover,
        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:focus-visible {
            background: linear-gradient(135deg, #005A24, #FFA500);
            box-shadow: none;
            outline: none;
        }
        .error {
            color: red;
            font-size: 0.9rem;
            margin-top: 0.5rem;
            text-align: center;
        }
        @media (max-width: 768px) {
            .retangulo {
                flex-direction: column;
                width: 90%;
                height: auto;
            }
            .img-gradient {
                width: 100%;
                padding: 1rem;
            }
            .form-container {
                width: 100%;
                padding: 1.5rem;
            }
            h2 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="retangulo">
        <div class="img-gradient">
            <h1>EEEP Salaberga</h1>
            <p>Transformando o futuro através da educação e inovação</p>
        </div>
        <div class="form-container">
            <h2>Login</h2>
            <form id="login-form">
                <div class="input-group">
                    <input type="email" class="form-control" id="inputEmail3" name="email" placeholder="Digite seu email" required aria-required="true">
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input type="password" class="form-control" id="inputPassword3" name="password" placeholder="Digite sua senha" required aria-required="true">
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                <div class="d-grid">
                    <button class="btn btn-primary" type="submit">Entrar</button>
                </div>
                <div class="error" id="error-message"></div>
            </form>
        </div>
    </div>
    <script>
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.getElementById('inputPassword3');
        togglePassword.addEventListener('click', () => {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye');
            togglePassword.classList.toggle('fa-eye-slash');
        });

        const form = document.getElementById('login-form');
        const errorMessage = document.getElementById('error-message');
        const button = form.querySelector('button');

        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('inputEmail3').value.trim();
            const password = document.getElementById('inputPassword3').value.trim();

            if (!email || !password) {
                errorMessage.textContent = 'Por favor, preencha todos os campos.';
                return;
            }

            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                errorMessage.textContent = 'Por favor, insira um email válido.';
                return;
            }

            button.textContent = 'Entrando...';
            button.disabled = true;
            errorMessage.textContent = '';

            fetch('login.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = './view/paginainicial.php';
                } else {
                    errorMessage.textContent = data.message || 'Email ou senha incorretos.';
                }
                button.textContent = 'Entrar';
                button.disabled = false;
            })
            .catch(error => {
                errorMessage.textContent = 'Erro ao conectar com o servidor.';
                button.textContent = 'Entrar';
                button.disabled = false;
            });
        });
    </script>
</body>
</html>