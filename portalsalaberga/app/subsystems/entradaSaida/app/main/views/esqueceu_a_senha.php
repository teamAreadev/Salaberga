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
    <title>Recuperação de Senha - Salaberga</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/recuper.css">
</head>

<body>
    <div class="container">
        <div class="logo-container">
            <img id="logoSalaberga" src="imagens/salabergaLogo.png" alt="Logo Salaberga">
        </div>

        <h1 class="title">
            Recuperação de Senha
        </h1>

        <p class="subtitle">
            Enviaremos um código de verificação para o e-mail informado abaixo.
            <small>
                <i class="fas fa-envelope"></i>
                Verifique sua caixa de entrada!
            </small>
        </p>

        <form action="codigo_de_verificacao.html" method="post">
            <div class="form-group">
                <input type="email" class="input-field" name="email" placeholder="Digite seu e-mail" required>
                <i class="fas fa-at"></i>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fas fa-paper-plane"></i>
                <span>Enviar Código</span>
            </button>
        </form>

        <a href="index.html" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Voltar para o login
        </a>
    </div>

    <footer>
        © 2025 Salaberga - Todos os direitos reservados
    </footer>
</body>

</html>