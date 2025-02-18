<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pré-Cadastro | EEEP Salaberga</title>
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
            margin-bottom: 1rem;
            font-weight: 700;
            font-size: 2rem;
            letter-spacing: 1px;
        }

        .form-container p {
            text-align: center;
            margin-bottom: 1.5rem;
            color: var(--text-color);
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
            margin-top: 1rem;
        }

        .btn-confirmar:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px var(--shadow-color);
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
            <h2>Pré-Cadastro</h2>
            <p>Preencha os dados abaixo para iniciar seu processo de pré-cadastro.</p>
            <form id="preCadastroForm" action="../../controllers/controller_cadastro/controller_pre_cadastro.php" method="POST">
                <div class="input-group">
                    <input name="preemail" type="email" id="email" placeholder=" " required>
                    <label for="preemail">E-mail Institucional</label>
                    <i class="fas fa-envelope"></i>
                </div>
                <div class="input-group">
                    <input name="precpf" type="text" id="cpf" placeholder=" " required maxlength="15">
                    <label for="cpf">CPF</label>
                    <i class="fas fa-id-card"></i>
                </div>

                <?php
                if (isset($_GET['erro'])) {
                ?>

                    <div class="texto">
                        Dados de login incorreto(s)
                    </div>
                    <style>
                        .texto {
                            color: red;
                        }
                    </style>

                <?php
                }
                ?>
                <button class="btn-confirmar" type="submit" name="pre_cadastro">Enviar Pré-Cadastro</button>

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
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('preCadastroForm');
            const whatsappInput = document.getElementById('whatsapp');

            // WhatsApp input formatting
            whatsappInput.addEventListener('input', function(e) {
                let x = e.target.value.replace(/\D/g, '').match(/(\d{0,2})(\d{0,5})(\d{0,4})/);
                e.target.value = !x[2] ? x[1] : '(' + x[1] + ') ' + x[2] + (x[3] ? '-' + x[3] : '');
            });

            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const nome = document.getElementById('nome').value;
                const email = document.getElementById('email').value;
                const whatsapp = whatsappInput.value;
                const curso = document.getElementById('curso').value;

                if (nome && email && whatsapp && curso) {
                    alert('Pré-cadastro realizado com sucesso! Entraremos em contato em breve.');
                    form.reset();
                } else {
                    alert('Por favor, preencha todos os campos.');
                }
            });
        });
    </script>
</body>

</html>
