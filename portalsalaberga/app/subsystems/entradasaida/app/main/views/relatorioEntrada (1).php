<?php
require_once('../model/select_model.php');
$select = new select_model;
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relatório de Entrada</title>
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

    .input-field,
    .btn-submit {
      margin: 5px;
    }

    label {
      display: block;
      margin-bottom: -6px;
      margin-top: 3rem;
    }

    .container {
      margin: 0 auto;
      padding: 20px;
      width: 100%;
      max-width: 700px;
      background: white;
      padding: 8rem;
      border-radius: 16px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
      text-align: center;
      margin-bottom: -60rem;
      margin-top: -60;
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
      margin-top: -2rem;
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

    h2 {
      font-size: 1.5rem;
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 1.5rem;
      margin-top: 1rem;
      position: relative;
      padding-bottom: -10rem;
    }

    .form-group {
      font-size: 1rem;
      font-weight: 600;
      color: var(--text-color);
      margin-bottom: 1.5rem;
      position: relative;
      padding-bottom: 5px;
      margin-bottom: 1rem;
      margin-top: 2rem;
      text-align: center;
    }

    .input-field {
      width: 80%;
      padding: 12px 15px;
      border: 1px solid var(--border-color);
      border-radius: 8px;
      font-size: 0.95rem;
      transition: all 0.3s ease;
      background: white;
      margin-bottom: 15px;
      position: center;
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
      width: 40%;
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
      text-align: center;
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
  <center>
    <div class="container">
      <h1>Relatório de Entrada</h1>
      <h2>Por Aluno</h2>
      <form id="entrada" action="../control/control_index.php" method="POST">
        <div class="aluno-section">
          <select id="id_aluno" name="id_aluno" class="input-field" required>
            <option id="id_aluno" name="id_aluno" disabled selected>Selecione o Nome do Aluno</option>
            <?php
            $dados = $select->select_alunos();
            foreach ($dados as $dado) {
            ?>
              <option value="<?= $dado['id_aluno'] ?>"><?= $dado['nome'] ?></option>
            <?php
            }
            ?>
          </select>
          <br>
          <label>Selecione o tipo de relatório:</label><br>
          <input type="radio" name="tipo_relatorio" value="dia_atual" required> Dia Atual<br>
          <input type="radio" name="tipo_relatorio" value="ultimos_30_dias"> Últimos 30 Dias<br>
          <input type="radio" name="tipo_relatorio" value="ultimos_12_meses"> Últimos 12 Meses<br>
          <br>
          <input type="hidden" name="GerarRelatorio" value="por_alunoEntrada">
          <input type="hidden" name="form_id" value="entrada">
          <input id="btn" type="submit" value="Gerar" name="btn" class="btn-submit">
          </br></br></br>
        </div>
      </form>
      <form id="entradaA" action="../control/control_index.php" method="POST">
        <div class="form-group">
          <div class="box">
            <label>Por Ano:</label>
            <select id="ano" name="Ano" class="input-field">
              <option value="" disabled selected>Selecione o ano</option>

              <option value="1">1° Anos </option>
              <option value="2">2° Anos</option>
              <option value="3">3° Anos </option>

            </select>

            <label>Selecione o tipo de relatório:</label><br>
            <input type="radio" name="tipo_relatorio" value="dia_atual" required> Dia Atual<br>
            <input type="radio" name="tipo_relatorio" value="ultimos_30_dias"> Últimos 30 Dias<br>
            <input type="radio" name="tipo_relatorio" value="ultimos_12_meses"> Últimos 12 Meses<br>
            <br>
            <input type="hidden" name="GerarRelatorio" value="ano_geralEntrada">
            <input type="hidden" name="form_id" value="entradaA">
            <input id="btn" type="submit" value="Gerar" name="btn" class="btn-submit">
            <br>
          </div>
        </div>
      </form>
      <form id="entradaT" action="../control/control_index.php" method="POST">
        <label>Por Turma:</label>
        <select id="Turma" name="Turma" class="input-field">
          <option value="" disabled selected>Selecione a turma</option>
           <option value="1">1° Ano A</option>
          <option value="2">1° Ano B</option>
          <option value="3">1° Ano C</option>
          <option value="4">1° Ano D</option>
           <option value="5">2° Ano A</option>
          <option value="6">2° Ano B</option>
          <option value="7">2° Ano C</option>
          <option value="8">2° Ano D</option>
          <option value="9">3° Ano A</option>
          <option value="10">3° Ano B</option>
          <option value="11">3° Ano C</option>
          <option value="12">3° Ano D</option>
        </select>
        <label>Selecione o tipo de relatório:</label><br>
        <input type="radio" name="tipo_relatorio" value="dia_atual" required> Dia Atual<br>
        <input type="radio" name="tipo_relatorio" value="ultimos_30_dias"> Últimos 30 Dias<br>
        <input type="radio" name="tipo_relatorio" value="ultimos_12_meses"> Últimos 12 Meses<br>
        <br>
        <input type="hidden" name="GerarRelatorio" value="por_turmaEntrada">
        <input type="hidden" name="form_id" value="entradaT">
        <input id="btn" type="submit" value="Gerar" name="btn" class="btn-submit">
        <br></br>
      </form>
    </div>
    <footer>
      © 2025 Salaberga - Todos os direitos reservados
    </footer>
  </center>
</body>

</html>