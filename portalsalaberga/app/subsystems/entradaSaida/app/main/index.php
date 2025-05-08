<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login | Entrada e Saida</title>
  <link rel="icon" type="image/x-icon" href="logo.jpg">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="./assets/css/login.css">
</head>
<style>
  :root {
    --primary-color: #4CAF50;
    --primary-hover: #45a049;
    --text-color: #333;
    --border-color: #ddd;
    --error-color: #ff4444;
    --background-color: #f8f9fa;
    --gradient-primary: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
    --gradient-accent: linear-gradient(135deg, #4CAF50 0%, #FFA500 100%);
  }

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  html,
  body {
    height: 100%;
  }

  body {
    font-family: 'Poppins', sans-serif;
    background: var(--background-color);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    position: relative;
    padding-bottom: 60px;
  }

  .login-container {
    width: 100%;
    max-width: 400px;
    background: white;
    padding: 2.5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    text-align: center;
    margin-bottom: 2rem;
    border: 1px solid rgba(0, 0, 0, 0.1);
  }

  .logo-text {
    font-family: 'Poppins', sans-serif;
    font-size: 1.6rem;
    font-weight: 600;
    color: #333;
    letter-spacing: 0.5px;
    position: relative;
    padding-bottom: 8px;
    margin-bottom: 1.5rem;
  }

  .logo-text::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: var(--gradient-accent);
    border-radius: 3px;
  }

  .subtitle {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 2rem;
    font-weight: 400;
  }

  .form-group {
    margin-bottom: 1.5rem;
    text-align: left;
    position: relative;
  }

  .input-login {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
  }

  .input-login:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
  }

  .input-login::placeholder {
    color: #999;
  }

  .password-toggle {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 5px;
    transition: color 0.3s ease;
  }

  .password-toggle:hover {
    color: var(--primary-color);
  }

  .checkbox-group {
    display: flex;
    align-items: center;
    margin: 1.5rem 0;
    font-size: 0.85rem;
    color: #666;
  }

  .checkbox-group input[type="checkbox"] {
    margin-right: 8px;
    accent-color: var(--primary-color);
  }

  .btn-login {
    width: 100%;
    padding: 12px;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
  }

  .btn-login::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: var(--gradient-accent);
    opacity: 0;
    transition: opacity 0.3s ease;
  }

  .btn-login:hover::before {
    opacity: 1;
  }

  .btn-login span {
    position: relative;
    z-index: 1;
  }

  .links-container {
    margin-top: 1.5rem;
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
  }

  .link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .link:hover {
    color: var(--primary-hover);
  }

  .mensagem-de-erro {
    color: var(--error-color);
    font-size: 0.85rem;
    margin-top: 1rem;
    display: none;
  }

  footer {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    text-align: center;
    padding: 1rem;
    color: var(--text-color);
    font-size: 0.9rem;
    background: white;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }

  footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100px;
    height: 2px;
    background: var(--gradient-accent);
  }

  .alert-modal {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 2rem;
    border-radius: 16px;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    z-index: 1001;
    max-width: 90%;
    width: 400px;
    animation: modalFadeIn 0.3s ease;
  }

  .alert-modal.active {
    display: block;
  }

  .alert-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.5rem;
  }

  .alert-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: var(--primary-color);
    margin-bottom: 1rem;
  }

  .alert-message {
    color: var(--text-color);
    margin-bottom: 1.5rem;
    line-height: 1.5;
  }

  .alert-button {
    background: var(--primary-color);
    color: white;
    border: none;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
  }

  .alert-button:hover {
    background: var(--primary-hover);
    transform: translateY(-2px);
  }

  @keyframes modalFadeIn {
    from {
      opacity: 0;
      transform: translate(-50%, -48%);
    }

    to {
      opacity: 1;
      transform: translate(-50%, -50%);
    }
  }

  .modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
  }

  .modal-overlay.active {
    display: block;
  }

  .alert-modal.error .alert-icon {
    color: var(--error-color);
  }

  .alert-modal.error .alert-title {
    color: var(--error-color);
  }

  .alert-modal.error .alert-button {
    background: var(--error-color);
  }

  .alert-modal.error .alert-button:hover {
    background: #e63c3c;
  }

  @media (max-width: 480px) {
    .login-container {
      padding: 2rem;
    }

    footer {
      padding: 0.8rem;
      font-size: 0.8rem;
    }
  }
</style>

<body>
  <div class="login-container">
    <h1 class="logo-text">Entrada e Saida</h1>
    <p class="subtitle">Preencha os campos abaixo para acessar sua conta administrativa</p>

    <form id="loginForm" action="control/control_index.php" method="POST">
      <div class="form-group">
        <input type="email" class="input-login" placeholder="E-mail" name="email" id="email" required>
      </div>

      <div class="form-group">
        <input type="password" class="input-login" placeholder="Senha" name="password" id="password" required>
        <button type="button" class="password-toggle" id="togglePassword">
          <i class="fas fa-eye"></i>
        </button>
      </div>

      <div class="checkbox-group">
        <input type="checkbox" id="terms" required>
        <label for="terms">Aceito os termos de política de privacidade</label>
      </div>

      <?php if (isset($_GET['login']) && $_GET['login'] == '1'){ ?>
        <script>
          showAlert(
            "Erro no Login",
            "Dados de login incorretos! Por favor, tente novamente.",
            true
          );
        </script>
      <?php } ?>

      <button type="submit" class="btn-login" value ='on' name="btn">
        <span>Entrar</span>
      </button>

      <div class="links-container">
        <a href="esqueceu_a_senha.php" class="link">Esqueceu a senha?</a>
      </div>
    </form>
  </div>

  <div class="modal-overlay" id="modalOverlay"></div>
  <div class="alert-modal" id="alertModal">
    <svg class="alert-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
      <polyline points="22 4 12 14.01 9 11.01"></polyline>
    </svg>
    <h3 class="alert-title" id="alertTitle">Sucesso!</h3>
    <p class="alert-message" id="alertMessage"></p>
    <button class="alert-button" onclick="closeAlert()">OK</button>
  </div>

  <footer>
    © 2025 Salaberga - Todos os direitos reservados
  </footer>

  <script>
    function showAlert(title, message, isError = false) {
      const modal = document.getElementById('alertModal');
      const overlay = document.getElementById('modalOverlay');
      const alertTitle = document.getElementById('alertTitle');
      const alertMessage = document.getElementById('alertMessage');
      const alertIcon = modal.querySelector('.alert-icon');

      alertTitle.textContent = title;
      alertMessage.textContent = message;

      if (isError) {
        modal.classList.add('error');
        alertIcon.innerHTML = `
      <path d="M12 8v4M12 16h.01M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12 6.477 2 12 2s10 4.477 10 10z"/>
    `;
      } else {
        modal.classList.remove('error');
        alertIcon.innerHTML = `
      <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
      <polyline points="22 4 12 14.01 9 11.01"></polyline>
    `;
      }

      modal.classList.add('active');
      overlay.classList.add('active');
    }

    function closeAlert() {
      const modal = document.getElementById('alertModal');
      const overlay = document.getElementById('modalOverlay');

      modal.classList.remove('active');
      overlay.classList.remove('active');
    }

    const togglePassword = document.getElementById("togglePassword");
    const password = document.getElementById("password");

    togglePassword.addEventListener("click", function () {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);

      this.querySelector("i").classList.toggle("fa-eye");
      this.querySelector("i").classList.toggle("fa-eye-slash");
    });
  </script>
</body>

</html>