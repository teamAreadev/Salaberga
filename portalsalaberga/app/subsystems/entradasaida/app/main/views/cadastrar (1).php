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
  <title>Cadastro de Aluno - Salaberga</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <link rel="stylesheet" href="../assets/css/cadastrar.css">
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
    padding-top: 70px;
  }

  .header {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: var(--gradient-primary);
    height: 60px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    z-index: 1000;
  }

  .header-title {
    color: white;
    font-size: 1.2rem;
    font-weight: 600;
  }

  .header-nav {
    display: flex;
    align-items: center;
  }

  .header-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 8px 16px;
    background-color: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 8px;
    color: white;
    font-size: 0.9rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
  }

  .header-btn:hover,
  .header-btn:focus {
    background-color: rgba(255, 255, 255, 0.25);
    transform: translateY(-2px);
  }

  .header-btn i {
    font-size: 1rem;
  }

  .container {
    width: 100%;
    max-width: 500px;
    background: white;
    padding: 5rem;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    text-align: center;
    margin-bottom: -10rem;
    border: 1px solid rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
  }

  .container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--gradient-accent);
  }

  .logo-container {
    margin-bottom: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #logoSalaberga {
    max-width: 160px;
    height: auto;
    transition: all 0.3s ease;
    filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
  }

  #logoSalaberga:hover {
    transform: scale(1.05);
  }

  h1 {
    font-size: 1.6rem;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 1.5rem;
    position: relative;
    padding-bottom: 8px;
  }

  h1::after {
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

  .form-group {
    margin-bottom: 1.2rem;
    text-align: left;
    position: relative;
  }

  .input-field {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
  }

  .input-field:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
  }

  .input-field::placeholder {
    color: #999;
  }

  .select-field {
    width: 100%;
    padding: 14px 16px;
    border: 1px solid var(--border-color);
    border-radius: 10px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 15px;
    cursor: pointer;
  }

  .select-field:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
  }

  .btn-submit {
    width: 100%;
    padding: 14px;
    background: var(--gradient-primary);
    color: white;
    border: none;
    border-radius: 10px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    margin-top: 1.5rem;
    box-shadow: 0 4px 10px rgba(69, 160, 73, 0.2);
  }

  .btn-submit::before {
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

  .btn-submit:hover::before {
    opacity: 1;
  }

  .btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(69, 160, 73, 0.3);
  }

  .btn-submit span {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
  }

  .back-link {
    display: inline-flex;
    align-items: center;
    margin-top: 1.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    transition: all 0.3s ease;
    padding: 8px 12px;
    border-radius: 8px;
  }

  .back-link:hover {
    color: var(--primary-hover);
    background-color: rgba(76, 175, 80, 0.05);
    transform: translateY(-2px);
  }

  .back-link i {
    margin-right: 8px;
  }

  .error-message {
    color: var(--error-color);
    font-size: 0.85rem;
    margin-top: 5px;
    display: none;
    text-align: left;
    padding-left: 5px;
  }

  .input-field.error {
    border-color: var(--error-color);
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

  @media (max-width: 480px) {
    .container {
      padding: 2rem;
    }

    footer {
      padding: 0.8rem;
      font-size: 0.8rem;
    }

    .header {
      padding: 0 15px;
      height: 56px;
    }

    .header-title {
      font-size: 1rem;
    }

    .header-btn {
      padding: 6px 12px;
      font-size: 0.85rem;
    }

    h1 {
      font-size: 1.4rem;
    }

    .input-field,
    .select-field {
      padding: 12px 14px;
    }

    .btn-submit {
      padding: 12px;
    }
  }
</style>












<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Salaberga - Cadastro de Aluno</title>
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
      padding-top: 70px;
    }

    .header {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      background: var(--gradient-primary);
      height: 60px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0 20px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000;
    }

    .header-title {
      color: white;
      font-size: 1.2rem;
      font-weight: 600;
    }

    .header-nav {
      display: flex;
      align-items: center;
    }

    .header-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      padding: 8px 16px;
      background-color: rgba(255, 255, 255, 0.15);
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 8px;
      color: white;
      font-size: 0.9rem;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .header-btn:hover,
    .header-btn:focus {
      background-color: rgba(255, 255, 255, 0.25);
      transform: translateY(-2px);
    }

    .header-btn i {
      font-size: 1rem;
    }

    .container {
      width: 100%;
      max-width: 500px;
      background: white;
      padding: 5rem;
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
      text-align: center;
      margin-bottom: -10rem;
      border: 1px solid rgba(0, 0, 0, 0.1);
      position: relative;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 4px;
      background: var(--gradient-accent);
    }

    .logo-container {
      margin-bottom: 2rem;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    #logoSalaberga {
      max-width: 160px;
      height: auto;
      transition: all 0.3s ease;
      filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
    }

    #logoSalaberga:hover {
      transform: scale(1.05);
    }

    h1 {
      font-size: 1.6rem;
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 1.5rem;
      position: relative;
      padding-bottom: 8px;
    }

    h1::after {
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

    .form-group {
      margin-bottom: -1rem;
      text-align: left;
      position: relative;
    }

    .input-field {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: white;
    }

    .input-field:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .input-field::placeholder {
      color: #999;
    }

    .select-field {
      width: 100%;
      padding: 14px 16px;
      border: 1px solid var(--border-color);
      border-radius: 10px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: white;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
      background-repeat: no-repeat;
      background-position: right 15px center;
      background-size: 15px;
      cursor: pointer;
    }

    .select-field:focus {
      outline: none;
      border-color: var(--primary-color);
      box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
    }

    .btn-submit {
      width: 100%;
      padding: 14px;
      background: var(--gradient-primary);
      color: white;
      border: none;
      border-radius: 10px;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: all 0.3s ease;
      position: relative;
      overflow: hidden;
      margin-top: 1.5rem;
      box-shadow: 0 4px 10px rgba(69, 160, 73, 0.2);
    }

    .btn-submit::before {
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

    .btn-submit:hover::before {
      opacity: 1;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 15px rgba(69, 160, 73, 0.3);
    }

    .btn-submit span {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
    }

    .back-link {
      display: inline-flex;
      align-items: center;
      margin-top: 1.5rem;
      color: var(--primary-color);
      text-decoration: none;
      font-size: 0.95rem;
      font-weight: 500;
      transition: all 0.3s ease;
      padding: 8px 12px;
      border-radius: 8px;
    }

    .back-link:hover {
      color: var(--primary-hover);
      background-color: rgba(76, 175, 80, 0.05);
      transform: translateY(-2px);
    }

    .back-link i {
      margin-right: 8px;
    }

    .error-message {
      color: var(--error-color);
      font-size: 0.85rem;
      margin-top: 5px;
      display: none;
      text-align: left;
      padding-left: 5px;
    }

    .input-field.error {
      border-color: var(--error-color);
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

    @media (max-width: 480px) {
      .container {
        padding: 2rem;
      }

      footer {
        padding: 0.8rem;
        font-size: 0.8rem;
      }

      .header {
        padding: 0 15px;
        height: 56px;
      }

      .header-title {
        font-size: 1rem;
      }

      .header-btn {
        padding: 6px 12px;
        font-size: 0.85rem;
      }

      h1 {
        font-size: 1.4rem;
      }

      .input-field,
      .select-field {
        padding: 12px 14px;
      }

      .btn-submit {
        padding: 12px;
      }
    }
  </style>
  <script>
    function validarFormulario() {
      let nome = document.getElementById("nome").value;
      let matricula = document.getElementById("matricula").value;
      let turma = document.getElementById("id_turma").value;
      let curso = document.getElementById("id_curso").value;

      if (!nome || !/^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/.test(nome)) {
        alert("Por favor, insira um nome válido.");
        return false;
      }
      if (!matricula || !/^\d{7}$/.test(matricula)) {
        alert("A matrícula deve conter 7 dígitos.");
        return false;
      }
      if (!turma || turma === "Selecione uma turma") {
        alert("Selecione uma turma.");
        return false;
      }
      if (!curso || curso === "Selecione um curso") {
        alert("Selecione um curso.");
        return false;
      }
      return true;
    }
  </script>
</head>

<body>
  <header class="header">
    <div class="header-title">Salaberga</div>
    <nav class="header-nav">
      <a href="index.php" class="header-btn">
        <i class="fas fa-home"></i>
        <span>Menu</span>
      </a>
    </nav>
  </header>

  <div class="container">
     <div class="logo-container">
      <img id="logoSalaberga" src="imagens/salabergaLogo.png" alt="Logo Salaberga">
    </div>

  <main>
    <h1>Cadastro de Aluno</h1>

    <?php
    if (isset($_GET['error'])) {
      if ($_GET['error'] === 'cadastro_concluido') {
        header: '/cadastrar.php';
      } elseif ($_GET['error'] === 'cadastro_falhou') {
        echo '<div class="error">Falha ao cadastrar o aluno. Verifique os dados e tente novamente.</div>';
      }
    }
    ?>

    <form action="../control/control_index.php" method="post" onsubmit="return validarFormulario()">
      <div class="form-group">
        <input class="input-field" id="nome" type="text" name="nome" placeholder="Nome completo" required>
        <div class="error-message" id="nome-error">Por favor, insira um nome válido</div>
      </div>
      <input type="hidden" name="cadastrar" value="1"><br>


       <div class="form-group">
        <input class="input-field" id="matricula" type="text" maxlength="7" name="matricula" pattern="\d{7}" placeholder="Matrícula (7 dígitos)" required>
        <div class="error-message" id="matricula-error">A matrícula deve conter 7 dígitos</div>
      </div><br>


      <div class="form-group">
        <label for="id_turma">Turma:</label>
        <select class="select-field" id="id_turma" name="id_turma" required>
          <option value="">Selecione uma turma</option>
          <option value="1° ano a">1° ano a</option>
          <option value="1° ano b">1° ano b</option>
          <option value="1° ano c">1° ano c</option>
          <option value="1° ano d">1° ano d</option>
          <option value="2° ano a">2° ano a</option>
          <option value="2° ano b">2° ano b</option>
          <option value="2° ano c">2° ano c</option>
          <option value="2° ano d">2° ano d</option>
          <option value="3° ano a">3° ano a</option>
          <option value="3° ano b">3° ano b</option>
          <option value="3° ano c">3° ano c</option>
          <option value="3° ano d">3° ano d</option>
        </select>
      </div><br>


      <div class="form-group">
        <label for="id_curso">Curso:</label>
        <select class="select-field" id="id_curso" name="id_curso" required>
          <option value="">Selecione um curso</option>
          <option value="enfermagem">Enfermagem</option>
          <option value="informática">Informática</option>
          <option value="administração">Administração</option>
          <option value="edificações">Edificações</option>
          <option value="meio ambiente">Meio Ambiente</option>
        </select>
      </div>
      <input class="btn-submit" type="submit" name="cadastrar" method= "POST">
    </form>
  </div>
  </main>
  <footer>
    © 2025 Salaberga - Todos os direitos reservados
  </footer>
</body>

</html>