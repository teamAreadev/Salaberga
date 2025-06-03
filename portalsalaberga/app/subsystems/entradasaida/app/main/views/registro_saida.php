
<?php
require_once('../model/select_model.php');
$select = new select_model;
?>


<!DOCTYPE html>
<html>
<!--CÓDIGO PARA VERIFICAR SE O USUÁRIO TEM LOGIN POR MEIO DA SESSÃO-->
<?php
require_once('../control/controller_sessao/autenticar_sessao.php');
require_once('../control/controller_sessao/verificar_sessao.php');
verificarSessao(600);
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar</title>
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
    width: 200%;
    max-width: 700px;
    background: white;
    padding: 5rem;
    border-radius: 16px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    text-align: center;
    margin-bottom: -15rem;
    border: 1px solid rgba(0, 0, 0, 0.1);

  }



  .logo-container {
    margin-bottom: 2rem;
    display: flex;
    justify-content: center;
    align-items: center;
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
    margin-bottom: 1.5rem;
    text-align: left;
    position: relative;
  }

  .input-field {
    width: 100%;
    padding: 12px 15px;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: white;
    margin-bottom: 15px;
  }

  .input-field:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
  }

  .input-field::placeholder {
    color: #999;
  }

  select.input-field {
    appearance: none;
    background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3e%3cpolyline points='6 9 12 15 18 9'%3e%3c/polyline%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 15px center;
    background-size: 15px;
    cursor: pointer;
  }

  .btn-submit {
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
    margin-top: 1rem;
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

  .btn-submit span {
    position: relative;
    z-index: 1;
  }

  .back-link {
    display: inline-block;
    margin-top: 1.5rem;
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s ease;
  }

  .back-link:hover {
    color: var(--primary-hover);
  }

  .back-link i {
    margin-right: 5px;
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
  }
</style>

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
    <h1>Registrar Saída</h1>
    <form id="registro-s" action="../control/control_index.php" method="POST">

      <select id="id_aluno" name="id_aluno" class="input-field" required>
        <option id="id_aluno" name="id_aluno" disabled selected>Selecione o Nome do Aluno</option>

        <?php
    $dados = $select->select_alunos();
    foreach ($dados as $dado) {
    ?>
        <option value="<?=$dado['id_aluno']?>"><?=$dado['nome']?></option>
    <?php
    }
    ?>
      </select>
      <div class="box">

        <input type="text" id="nome_responsavel" name="nome_responsavel" placeholder="Nome do Responsável" class="input-field" required>

        <select id="id_tipo_responsavel" name="id_tipo_responsavel" class="input-field" required>
          <option value="" disabled selected>Selecione o Tipo de Responsável</option>
          <option value="1">Mãe</option>
          <option value="2">Pai</option>
          <option value="3">Responsável</option>
          <option value="4">Parentes de 1° grau</option>
        </select>

        <input type="text" id="nome_conducente" name="nome_conducente" placeholder="Nome do Conducente" class="input-field">


        <select id="id_tipo_conducente" name="id_tipo_conducente" class="input-field">
          <option value="" disabled selected>Selecione o Tipo de Conducente</option>
          <option value="1">Uber</option>
          <option value="2">Responsável</option>
          <option value="3">Amigo(a)</option>
        </select>

        <select id="id_motivo" name="id_motivo" class="input-field" required>
          <option value="" disabled selected>Selecione o Motivo</option>
          <option value="1">Saúde</option>
          <option value="2">Imprevisto</option>
          <option value="3">Compromisso Pessoal</option>
          <option value="4">Outros</option>

        </select>


        <select id="id_usuario" name="id_usuario" class="input-field" required>
          <option value="" disabled selected>Selecione o Administrador</option>
          <option value="1">Rosana</option>
          <option value="2">Adriana</option>
          <option value="3">Carlos Henrique</option>
          <option value="4">Reginaldo</option>
          <option value="5">Cícero</option>


        </select>

        <input type="date" name="data" class="input-field" required>

        <input type="time" name="hora" class="input-field" required>

        <input id="btn" type="submit" value="Registrar" name="saida" class=" btn-submit" method="GET">
    </form>
  </div>
  </div>
  </div>
  <footer>
    © 2025 Salaberga - Todos os direitos reservados
  </footer>

</html>