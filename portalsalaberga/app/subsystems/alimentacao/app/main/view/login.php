<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EEEP Salaberga - Tela de Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="shortcut icon" href="../assets/img/salaberga-logo.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap');

        :root {
            --primary-color: #2e7d32; /* Verde principal */
            --dark-green: #0f2a1d; /* Verde bem escuro */
            --medium-dark-green: #1a3c2e; /* Verde escuro médio */
            --text-color: #333333;
            --bg-color: #F0F2F5;
            --input-bg: #FFFFFF;
            --shadow-color: rgba(0, 0, 0, 0.1);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--text-color);
            margin: 0;
            overflow-x: hidden;
        }

        .main-container {
            display: flex;
            width: 90%;
            max-width: 900px;
            height: 500px;
            background-color: var(--bg-color);
            border-radius: 1.5rem;
            overflow: hidden;
            box-shadow: 0 20px 40px var(--shadow-color);
        }

        .image-container {
            flex: 1;
            background: linear-gradient(40deg, var(--dark-green), var(--medium-dark-green));
            position: relative;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
            text-align: center;
            color: #FFFFFF;
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

        h2 {
            text-align: center;
            color: var(--primary-color);
            font-weight: 600;
            font-size: 65px;
            letter-spacing: 1px;
        }

        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .input-group input {
            width: 100%;
            padding: 12px 20px;
            border: 2px solid var(--primary-color);
            border-radius: 1.5rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background-color: var(--input-bg);
            color: var(--text-color);
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.3);
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

        .input-group input:focus + label,
        .input-group input:not(:placeholder-shown) + label {
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
            width: 200px;
    height:  45px ;
    margin-top: 15px;
            padding: 10px;
            background: linear-gradient(90deg, var(--dark-green), var(--medium-dark-green));
            color: #FFFFFF;
            border: none;
            border-radius: 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
           
            letter-spacing: 1px;
            box-shadow: 0 4px 6px var(--shadow-color);
           

        }

        .btn-confirmar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px var(--shadow-color);
            opacity: 0.9;
        }

        .btn-cadastro {
            width: 200px;
           padding: 8px;
         height:  45px ;
            background: transparent;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            border-radius: 1.5rem;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 4px 6px var(--shadow-color);
            margin: 1rem auto 0;
            justify-items: center;
            text-align: center;
   
        }

        .btn-cadastro:hover {
            background: linear-gradient(90deg, var(--dark-green), var(--medium-dark-green));
            color: #FFFFFF;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px var(--shadow-color);
            border-color: transparent; /* Mantém as bordas visíveis apenas no estado normal */
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

        @media (max-width: 640px) {
            .image-container {
                display: none;
            }

            .main-container {
                padding: 1rem;
            }
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
            <h2 class="text-4xl my-6 font-semibold">Login</h2>
            <form id="loginForm" action="../control/controlLogin.php" method="POST">
                <div class="input-group">
                    <input type="text" name="login" id="login" placeholder=" " required>
                    <label for="login">E-mail Institucional</label>
                    <i class="fas fa-user"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" id="password" placeholder=" " required>
                    <label for="password">Senha</label>
                    <i class="fas fa-eye-slash toggle-password"></i>
                </div>
                <div class="flex">

                
                <button type="submit" name="submit" class="btn-confirmar " >Entrar</button>
                <a href="cadastro.php" class="btn-cadastro">Criar uma Conta</a>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const togglePassword = document.querySelector('.toggle-password');
            const passwordInput = document.getElementById('password');

            // Definir como senha oculta por padrão (olhinho fechado)
            passwordInput.setAttribute('type', 'password');
            togglePassword.classList.add('fa-eye-slash');
            togglePassword.classList.remove('fa-eye');

            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye-slash');
                this.classList.toggle('fa-eye');
            });
        });
    </script>
</body>
</html>