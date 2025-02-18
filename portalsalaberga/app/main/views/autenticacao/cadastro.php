<?php
    require_once('../../controllers/controller_sessao/autenticar_sessao.php');
    require_once('../../controllers/controller_sessao/verificar_sessao.php');
    verificarSessao(60);
    
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro | EEEP Salaberga</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../../assets/img/Design sem nome.svg" type="image/x-icon">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #4CAF50;
            --secondary-color: #FFB74D;
            --text-color: #333333;
            --bg-color: #F0F2F5;
            --input-bg: #FFFFFF;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
        }

        .main-container {
            display: flex;
            width: 100%;
            max-width: 900px;
            height: 600px;
            background-color: var(--bg-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px var(--shadow-color);
        }

        .image-container {
            flex: 1;
            background: linear-gradient(40deg, #007A33, #FF8C00);
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.366), rgba(0, 0, 0, 0.355));
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
            color: #FFFFFF;
        }

        .error-message {
            color: #ff0000;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            margin-bottom: 0.5rem;
        }

        .image-overlay h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }

        .image-overlay p {
            font-size: 1rem;
            max-width: 80%;
        }

        .form-container {
            flex: 1;
            padding: 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background-color: #FFFFFF;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        h2 {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--input-bg);
            color: var(--text-color);
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(76, 175, 80, 0.1);
        }

        .input-group label {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 1rem;
            transition: all 0.3s ease;
            pointer-events: none;
            padding: 0 5px;
            background-color: var(--input-bg);
        }

        .input-group input:focus+label,
        .input-group input:not(:placeholder-shown)+label {
            top: 0;
            font-size: 0.8rem;
            color: var(--primary-color);
        }

        .input-group i {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary-color);
            font-size: 1.2rem;
            cursor: pointer;
        }

        .btn-confirmar {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px var(--shadow-color);
       margin-top:-40px;
        }

        .btn-confirmar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px var(--shadow-color);
        }

        .progress-bar {
            width: 100%;
            height: 4px;
            background-color: #e0e0e0;
            margin-top: 1rem;
            border-radius: 5px;
            overflow: hidden;
        }

        .progress {
            width: 0;
            height: 100%;
            background-color: var(--primary-color);
            transition: width 0.3s ease;
        }

        .strength-meter {
            display: flex;
            justify-content: space-between;
            margin-top: 0.5rem;
            font-size: 0.7rem;
            color: #999;
        }

        @media (max-width: 768px) {
            .main-container {
                flex-direction: column;
                height: auto;
                max-width: 100%;
            }

            .image-container {
                height: 200px;
            }

            .form-container {
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {

            .image-container,
            .logo-container {
                display: none;
            }
        }
        
          .forgot-password {
            text-align: left;
            margin-top: -1rem;
            margin-bottom: 1rem;
            margin-top: 5px;
            position:relative;
        }

        .forgot-password a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password a:hover {
            color: var(--secondary-color);
        }
        
    </style>
</head>

<body>
    <div class="main-container">
        <div class="image-container">
            <div class="image-overlay">
                <h1>EEEP Salaberga</h1>
                <p>Transformando o futuro através da educação e inovação</p>
            </div>
        </div>
        <div class="form-container">
            <div class="logo-container">
                <img src="https://i.postimg.cc/ryxHRNkj/lavosier-nas-2.png" alt="Logo EEEP Salaberga" class="logo">
            </div>
            <h2>Cadastro</h2>
            <form id="cadastroForm" action="../../controllers/controller_cadastro/controller_cadastro.php"
                method="POST">
                <div class="input-group">
                    <input type="text" name="UserName" id="username" placeholder=" " required>
                    <label for="username">Nome de usuário</label>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input type="text" name="Cpf" id="cpf" placeholder=" " required maxlength="14">
                    <label for="matricula"> CPF</label>
                    <i class="fas fa-id-card"></i>
                </div>
                <div class="input-group">
                    <input type="email" name="Email" id="email" placeholder=" " required>
                    <label for="email">E-mail Institucional</label>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="Password" id="password" placeholder=" " required>
                    <label for="password">Senha</label>
                    <i class="fas fa-eye toggle-password"></i>
                </div>
                <div id="passwordError" class="error-message"></div>
                <div id="passwordError" class="error-message"></div>
                <div class="progress-bar">
                    <div class="progress" id="passwordStrength"></div>
                </div>
                <div class="strength-meter">
                    <span>Fraca</span>
                    <span>Média</span>
                    <span>Forte</span>
                </div>
                <div class="forgot-password"> 
   <a href="login.php">Ja tem cadastro?</a>
                </div>
                <?php
                if (isset($_GET['login']) && $_GET['login'] == 'erro1') {
                    echo '<br>';
                    ?>
                    <div class="texto">
                        Email ou Cpf incorreto(s)
                    </div>
                    <style>
                        .texto {
                            color: red;
                        }
                    </style>
                    <?php
                    echo '<br>';
                }
                ?>

                <?php
                if (isset($_GET['login']) && $_GET['login'] == 'erro2') {
                    echo '<br>';
                    ?>
                    <div class="texto">
                        Email ou Cpf já cadastrados(s)
                    </div>
                    <style>
                        .texto {
                            color: red;
                        }
                    </style>
                    <?php
                    echo '<br>';
                }
                ?>
                <button type="submit" class="btn-confirmar" name="cadastrar">Criar Conta</button>
            </form>
        </div>
    </div>

    <script>
    
    
       
document.addEventListener('DOMContentLoaded', function() {
    const cpfInput = document.getElementById('cpf');

    cpfInput.addEventListener('input', function(e) {
        let value = e.target.value;

        // Remove tudo que não é número
        value = value.replace(/\D/g, '');

        // Coloca a pontuação enquanto digita
        if (value.length > 0) value = value.replace(/^(\d{3})/, '$1.');
        if (value.length > 3) value = value.replace(/^(\d{3})\.(\d{3})/, '$1.$2.');
        if (value.length > 6) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})/, '$1.$2.$3-');
        if (value.length > 9) value = value.replace(/^(\d{3})\.(\d{3})\.(\d{3})-(\d{2})/, '$1.$2.$3-$4');

        // Limita em 11 números
        if (value.length > 14) {
            value = value.substr(0, 14);
        }

        e.target.value = value;
    });
});


        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('cadastroForm');
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');
            const passwordStrength = document.getElementById('passwordStrength');
            const passwordError = document.getElementById('passwordError');
            const whatsappInput = document.getElementById('whatsapp');

            togglePassword.addEventListener('click', function () {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            passwordInput.addEventListener('input', function () {
                const strength = calculatePasswordStrength(this.value);
                passwordStrength.style.width = `${strength}%`;
                // Remove a atualização do erro aqui
            });

            // WhatsApp input formatting
            whatsappInput.addEventListener('input', function (e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            });

            form.addEventListener('submit', function (e) {
                e.preventDefault();
                const username = document.getElementById('username').value;
                const matricula = document.getElementById('matricula').value;
                const whatsapp = whatsappInput.value;
                const password = passwordInput.value;

                // Limpa a mensagem de erro anterior
                passwordError.textContent = '';

                if (username && matricula && whatsapp && password) {
                    if (isPasswordValid(password)) {
                        alert('Cadastro realizado com sucesso!');
                        form.reset();
                        passwordStrength.style.width = '0%';
                    } else {
                        passwordError.textContent = 'A senha deve ter no mínimo 8 caracteres, 1 caractere especial e 1 caractere maiúsculo.';
                        passwordInput.focus(); // Foca no campo de senha
                    }
                } else {
                    alert('Por favor, preencha todos os campos.');
                }
            });

            function calculatePasswordStrength(password) {
                let strength = 0;
                if (password.length >= 8) strength += 25;
                if (password.match(/[A-Z]/)) strength += 25;
                if (password.match(/[a-z]/)) strength += 25;
                if (password.match(/[0-9]/)) strength += 12.5;
                if (password.match(/[^A-Za-z0-9]/)) strength += 12.5;
                return strength;
            }

            function isPasswordValid(password) {
                const minLength = 8;
                const hasUpperCase = /[A-Z]/.test(password);
                const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]+/.test(password);

                return password.length >= minLength && hasUpperCase && hasSpecialChar;
            }
        });


    </script>
</body>

</html>
