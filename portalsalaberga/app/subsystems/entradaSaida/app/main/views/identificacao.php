<!DOCTYPE html>
<html lang="pt-BR">
 <!--CÓDIGO PARA VERIFICAR SE O USUÁRIO TEM LOGIN POR MEIO DA SESSÃO-->
 <?php
  require_once('../control/controller_sessao/autenticar_sessao.php');
  require_once('../control/controller_sessao/verificar_sessao.php');
  verificarSessao(600);
  ?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso | Entrada e Saida</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/identificacao.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img id="logoSalaberga" src="imagens/salabergaLogo.png" alt="Logo Salaberga">
        </div>

        <h1 class="title">Sistema Entradas e Saídas</h1>
        <h2 class="welcome-text">Bem-vindo(a)!</h2>
        <p class="subtitle">Selecione seu tipo de acesso:</p>

        <div class="button-group">
            <button class="role-button" id="adminButton" onclick="selectRole('admin')">
                <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 1L3 5v6c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V5l-9-4zm0 2.18l7 3.12v4.7c0 4.54-2.77 8.62-7 10-4.23-1.38-7-5.46-7-10V6.3l7-3.12zm-2 12.32l6-6-1.41-1.41L10 12.67 7.41 10.09 6 11.5l4 4z" />
                </svg>
                Administrador
            </button>

            <button class="role-button" id="vigilanteButton" onclick="selectRole('vigilante')">
                <svg class="icon" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0-6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2zm0 7c-2.67 0-8 1.34-8 4v3h16v-3c0-2.66-5.33-4-8-4zm6 5H6v-.99c.2-.72 3.3-2.01 6-2.01s5.8 1.29 6 2v1z" />
                </svg>
                Vigilante
            </button>
        </div>

        <button class="btn-enter" id="enterButton" onclick="entrar()">
            <span>Continuar</span>
        </button>
    </div>

    <footer>
        © 2025 Salaberga - Todos os direitos reservados
    </footer>

    <script>
        let selectedRole = null;
        const adminButton = document.getElementById('adminButton');
        const vigilanteButton = document.getElementById('vigilanteButton');
        const enterButton = document.getElementById('enterButton');

        function selectRole(role) {
            selectedRole = role;

            adminButton.classList.remove('active');
            vigilanteButton.classList.remove('active');

            if (role === 'admin') {
                adminButton.classList.add('active');
            } else {
                vigilanteButton.classList.add('active');
            }

            enterButton.style.display = 'block';
            enterButton.style.opacity = '0';
            setTimeout(() => {
                enterButton.style.opacity = '1';
                enterButton.style.transform = 'translateY(0)';
            }, 50);
        }

        function entrar() {
            if (selectedRole === 'admin') {
                window.location.href = 'login.php';
            } else if (selectedRole === 'vigilante') {
                window.location.href = 'login_vigilante.php';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(20px)';

            setTimeout(() => {
                container.style.transition = 'all 0.6s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>

</html>