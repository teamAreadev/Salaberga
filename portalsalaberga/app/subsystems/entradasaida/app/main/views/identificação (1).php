<DOCTYPE html>
  <html lang="pt-br">
  <!--CÓDIGO PARA VERIFICAR SE O USUÁRIO TEM LOGIN POR MEIO DA SESSÃO-->
  <?php
  require_once('../control/controller_sessao/autenticar_sessao.php');
  require_once('../control/controller_sessao/verificar_sessao.php');
  verificarSessao(600);
  ?>

  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> •Login Conta E.S•</title>
    <link rel="icon" type="image/x-icon" href="logo.jpg">
    <link rel="stylesheet" href="identificação.css">

  </head>

  <body>

    <div class="login-container">
      <h1>Sistema Entradas e Saídas</h1>
      <br><br>
      <h2><b>Bem vindo(a)!</b></h2>
      <form onsubmit="return false;" id="loginForm">
        <p>Você é um?</p><br>

        <button class="Administrador" id="Admin" onclick="Mostrarbotaoentrar()">Administrador</button>

        <button class="Vigilante" id="Vigia" onclick="/// ()">Vigilante</button>


        <button type="button" id="Entrar" onclick="entrar()">Entrar</button>

        <script>
          function Mostrarbotaoentrar() {
            document.getElementById("Entrar").style.display = "block";
          }

          function entrar() {
            window.location.href = "login.php";
          }
        </script>

      </form>
    </div>

  </body>

  </html>