<!DOCTYPE html>
<html lang="pt-BR">
<!--CÓDIGO PARA VERIFICAR SE O USUÁRIO TEM LOGIN POR MEIO DA SESSÃO-->!
<?php
require_once('../control/controller_sessao/autenticar_sessao.php');
require_once('../control/controller_sessao/verificar_sessao.php');
verificarSessao(600);
?>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verificação de Código - Salaberga</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/verificacao.css">
</head>
<body>
  <div class="container">
    <div class="logo-container">
      <img id="logoSalaberga" src="imagens/salabergaLogo.png" alt="Logo Salaberga">
    </div>

    <h1 class="title">Verificação de Código</h1>
    <p class="subtitle">Digite o código de confirmação enviado para seu e-mail</p>

    <div class="code-inputs">
      <input type="text" maxlength="1" class="code-input" required>
      <input type="text" maxlength="1" class="code-input" required>
      <input type="text" maxlength="1" class="code-input" required>
      <input type="text" maxlength="1" class="code-input" required>
      <input type="text" maxlength="1" class="code-input" required>
    </div>

    <button class="btn-verify" onclick="VerificarCodigo()">
      <span>Confirmar Código</span>
    </button>

    <p id="mensagem" class="message"></p>

    <p class="timer" id="timer">Reenviar em: <span id="countdown">60</span>s</p>
    <a href="#" class="resend-link" id="resendLink">
      <i class="fas fa-redo"></i>
      Reenviar código
    </a>
  </div>

  <footer>
    © 2025 Salaberga - Todos os direitos reservados  </footer>

  <script>
    //PEGA A VISÃO AE TROPA
    // Vamos pegar todos os campos de input do código
    const inputs = document.querySelectorAll('.code-input');
    
    // Para cada campo de input, vamos adicionar algumas funcionalidades
    inputs.forEach((input, index) => {
      // Quando o usuário digitar algo no campo
      input.addEventListener('input', function() {
        // Se o usuário digitou um número
        if (this.value.length === 1) {
          // E se não for o último campo
          if (index < inputs.length - 1) {
            // Vamos pular automaticamente para o próximo campo
            inputs[index + 1].focus();
          }
        }
      });

      // Quando o usuário apertar uma tecla
      input.addEventListener('keydown', function(e) {
        // Se ele apertar a tecla de apagar (backspace)
        if (e.key === 'Backspace' && !this.value && index > 0) {
          // E o campo estiver vazio, vamos voltar para o campo anterior
          inputs[index - 1].focus();
        }
      });
    });

    // Vamos criar um timer para controlar quando o usuário pode reenviar o código
    let timeLeft = 60; // Começa com 60 segundos
    const timerElement = document.getElementById('countdown'); // Onde vamos mostrar o tempo
    const resendLink = document.getElementById('resendLink'); // O botão de reenviar
    
    // Função que atualiza o timer a cada segundo
    function updateTimer() {
      // Mostra o tempo que falta na tela
      timerElement.textContent = timeLeft;
      // Se ainda tiver tempo
      if (timeLeft > 0) {
        // Diminui 1 segundo
        timeLeft--;
        // Espera 1 segundo e chama a função de novo
        setTimeout(updateTimer, 1000);
      } else {
        // Se o tempo acabou, ativa o botão de reenviar
        resendLink.style.pointerEvents = 'auto';
        resendLink.style.opacity = '1';
        document.querySelector('.timer').style.display = 'none';
      }
    }

    // Começa o timer
    updateTimer();

    // Quando o usuário clicar no botão de reenviar
    resendLink.addEventListener('click', function(e) {
      e.preventDefault(); // Impede que a página recarregue
      // Se o tempo já acabou
      if (timeLeft <= 0) {
        timeLeft = 60; // Reseta o timer para 60 segundos
        updateTimer(); // Começa o timer de novo
        // Desativa o botão de reenviar
        this.style.pointerEvents = 'none';
        this.style.opacity = '0.5';
        document.querySelector('.timer').style.display = 'block';
      }
    });

    // Função que verifica se o código está correto
    function VerificarCodigo() {
      // Junta todos os números digitados em um só código
      const code = Array.from(inputs).map(input => input.value).join('');
      const messageElement = document.getElementById('mensagem');
      
      // Se o usuário preencheu todos os campos
      if (code.length === 5) {
        // Se o código for 12345 (código de exemplo)
        if (code === '12345') {
          // Mostra mensagem de sucesso em verde
          messageElement.style.color = 'var(--primary-color)';
          messageElement.textContent = 'Código verificado com sucesso!';
          messageElement.style.display = 'block';
          // Espera 1.5 segundos e vai para a página principal
          setTimeout(() => {
            window.location.href = 'index.html';
          }, 1500);
        } else {
          // Se o código estiver errado, mostra mensagem de erro em vermelho
          messageElement.style.color = 'var(--error-color)';
          messageElement.textContent = 'Código inválido! Tente novamente.';
          messageElement.style.display = 'block';
        }
      } else {
        // Se o usuário não preencheu todos os campos
        messageElement.style.color = 'var(--error-color)';
        messageElement.textContent = 'Por favor, preencha todos os campos.';
        messageElement.style.display = 'block';
      }
    }
  </script>
</body>
</html>