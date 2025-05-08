<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relatório de Saída</title>
  <!-- <link rel="stylesheet" href="registrar.css"> -->
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

    .form-group .box {
      border: 2px solid #45a049;
      border-radius: 5px;
      padding: 20px;
      margin-bottom: 100px;
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
      margin-bottom: -5rem;
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
      <h1>Relatório de Saída</h1>

      <h2>Por Aluno</h2>

      <form id="saida-estagio" action="../control/control_index.php" method="POST">
        <div class="aluno-section">


          <select id="id_aluno" name="id_aluno" class="input-field" required>
            <option id="id_aluno" name="id_aluno" disabled selected>Selecione o Nome do Aluno</option>

            <option value="">3A:</option>
            <option value="48">Alice Sousa Costa 3 A</option>
            <option value="49">Ana Beatriz Braz da Silva</option>
            <option value="50">Ana Beatriz Ferreira Nunes da Veiga</option>
            <option value="51">Ana Flavia Pereira Santiago</option>
            <option value="52">Ana Heloisa Honorio de Abreu</option>
            <option value="53">Ana Luiza Barbosa dos Santos</option>
            <option value="54">Anna Gabrielly Rodrigues Souza</option>
            <option value="55">Antonia Cibelle da Paixao Ferreira</option>
            <option value="56">Antonia Regiane Rodrigues da Silva</option>
            <option value="57">Arnytallelen Riane Pereira Alves</option>
            <option value="58">Caio da Silva Vieira</option>
            <option value="59">Emanoela Militao Azevedo</option>
            <option value="60">Fatima Caylanny Dias de Souza</option>
            <option value="61">Francisco Arthur Santos da Silva</option>
            <option value="62">Francisco Marley Martins Conserva</option>
            <option value="63">Francisco Otavio Alves Oliveira</option>
            <option value="64">Ingrid Oliveira de Souza</option>
            <option value="65">Italo Sousa da Silva</option>
            <option value="66">Jayllanna Guimaraes Gomes</option>
            <option value="67">Juliana Gomes de Sousa</option>
            <option value="68">Kariny Maria do Nascimento Mourao</option>
            <option value="69">Klarrion Dias do Nascimento</option>
            <option value="70">Lanna Regia de Lima Monteiro</option>
            <option value="71">Lara Kathellyn Felipe Costa</option>
            <option value="72">Leanderson Costa Sousa</option>
            <option value="73">Leia Horrara da Silva Costa</option>
            <option value="74">Lia Rocha de Nojosa Oliveira</option>
            <option value="75">Luana Vasconcelos Batista</option>
            <option value="76">Lucas dos Reis Feitosa</option>
            <option value="77">Luiz Henrique Martins Lima</option>
            <option value="78">Luma Thayse Castro Cavalcante</option>
            <option value="79">Maria Carynne Monteiro Lopes</option>
            <option value="80">Maria Clara Farias Gomes da Cunha</option>
            <option value="81">Maria Eduarda da Silva Sousa</option>
            <option value="82">Marjorie Evelyn Mendes Cruz</option>
            <option value="83">Matheus Bryan Dias Almeida</option>
            <option value="84">Myrela Pires Soares</option>
            <option value="85">Nara Livia Ferreira Nunes</option>
            <option value="86">Nicole Correia da Silva</option>
            <option value="87">Nycole Rodrigues Gomes</option>
            <option value="88">Nycolle Stefanelle Meneses Costa</option>
            <option value="89">Raianny Sampaio de Oliveira</option>
            <option value="90">Sarah Dias Oliveira</option>
            <option value="91">Sophia Amelia Lopes Dias Tomaz</option>
            <option value="92">Tiffany Christine Leite de Paiva</option>
            <option value="93">Thyago Lenilson Mariano dos Santos</option>
            <option value="94">Vyrna Glicya de Abreu Rocha</option>

            <option value="">3B:</option>
            <option value="193">Alexandre Neto Dantas da Silva</option>
            <option value="194">Ana Clara Cavalcante Lima</option>
            <option value="195">Angela Michele dos Santos Lima</option>
            <option value="196">Antonio Felipe Gomes Moreira</option>
            <option value="197">Athila Silveira da Silva</option>
            <option value="198">Bianca Vieira Gomes</option>
            <option value="199">Carlos Eduardo Cardoso Holanda</option>
            <option value="200">Carlos Eduardo da Costa Lima</option>
            <option value="201">Carlos Fred Abreu Pires</option>
            <option value="202">Christian Uniás dos Santos Siqueira</option>
            <option value="203">Clarice Rocha de Nojosa Oliveira</option>
            <option value="204">Elpidio Thomas de Freitas Bezerra</option>
            <option value="205">Francisco Denilson Andrade Costa</option>
            <option value="206">Francisco Erick Alves de Pinho</option>
            <option value="207">Francisco Erick Honorio de Oliveira</option>
            <option value="208">Francisco Kauã Muniz da Silva</option>
            <option value="209">Francisco Lavosier Silva Nascimento</option>
            <option value="210">Francisco Lucas Diamante Souza</option>
            <option value="211">Francisco Weverton Cirilo Marques</option>
            <option value="212">Giovanna Thayla Cardoso Viana</option>
            <option value="213">Ian Lucas Freitas da Silva de Araujo</option>
            <option value="214">Jefferson Castro da Silva</option>
            <option value="215">Jennyfer Nicoly Sousa Marques</option>
            <option value="216">João Gabriel Costa Correia</option>
            <option value="217">João Paulo Araujo da Silva</option>
            <option value="218">José Arimateia Maciel de Sousa</option>
            <option value="219">Júlia Frota de Oliveira</option>
            <option value="220">Julio Cezar Targino da Silva Filho</option>
            <option value="221">Larissa Moura da Silva</option>
            <option value="222">Leticia Barbosa Oliveira</option>
            <option value="223">Letycia Santos de Sousa</option>
            <option value="224">Marcela dos Santos Costa</option>
            <option value="225">Marcos Luan Vieira da Silva</option>
            <option value="226">Maria Joisseanne da Silva Nascimento</option>
            <option value="227">Maria Maysa da Silva Rocha</option>
            <option value="228">Matheus Felix Lopes</option>
            <option value="229">Matheus Machado Fernandes</option>
            <option value="230">Millena da Silva Andrade Freires</option>
            <option value="231">Natyellen França de Sousa</option>
            <option value="232">Nicole Kelly de Oliveira Lopes</option>
            <option value="233">Paulo Vitor Lima Duarte</option>
            <option value="234">Pedro Uchoa de Abreu</option>
            <option value="235">Rafael Martins dos Santos</option>
            <option value="236">Ramon Nunes Mendonça</option>
            <option value="237">Rayssa Bezerra Vaz</option>
            <option value="238">Rodrigo Franco Campos</option>
            <option value="239">Roger Silva Cavalcante</option>
            <option value="240">Sarah Hellen Tome de Oliveira</option>
            <option value="241">Yudi Bezerra Barbosa</option>

            <option value="">3C:</option>
            <option value="95">Adryelli Silva Guedes</option>
            <option value="96">Alessandro de Almeida Nunes</option>
            <option value="97">Ana Geysa da Silva Oliveira</option>
            <option value="98">Ana Jaisla Souza Vaz</option>
            <option value="99">Ana Kessia Cardoso Coelho</option>
            <option value="100">Ana Leticia Silva Barbosa</option>
            <option value="101">Ana Livia Nascimento de Lima</option>
            <option value="102">Ana Luiza Gama Rocha</option>
            <option value="103">Ana Munique Marques da Silva</option>
            <option value="104">Ana Vitoria Santos da Silva</option>
            <option value="105">Antonia Gleyciane Abreu de Sousa</option>
            <option value="106">Arthur Andrade Araujo</option>
            <option value="107">Byanca da Silva Sousa</option>
            <option value="108">Carolina Ketelye dos Santos Henrique</option>
            <option value="109">Cinthya Menezes Pereira</option>
            <option value="110">Daniel de Oliveira Rodrigues</option>
            <option value="111">Elloa Oliveira dos Santos</option>
            <option value="112">Francisca Larisse Santos Pereira</option>
            <option value="113">Francisco Adrian Lima da Costa</option>
            <option value="114">Francisco Kassio Muniz da Silva</option>
            <option value="115">Hiago Sousa da Silva</option>
            <option value="116">Ingrid Mikaelly Cavalcante Silva de Sousa</option>
            <option value="117">Joao Victor Costa Sousa</option>
            <option value="118">Julia Evelin Augusto de Sousa</option>
            <option value="119">Jullya dos Santos Leonardo Cavalcante</option>
            <option value="120">Kaigue Araujo de Andrade Sales</option>
            <option value="121">Ketley Kaianny Sousa de Oliveira</option>
            <option value="122">Lara Gabriela Oliveira Mota</option>
            <option value="123">Larissa de Oliveira Mendes Sousa</option>
            <option value="124">Larissa Vieira Brito</option>
            <option value="125">Leticia Carvalho Cordeiro</option>
            <option value="126">Lohany Barbosa Rodrigues</option>
            <option value="127">Luciany Silva de Sousa</option>
            <option value="128">Maria Eduarda Carvalho Cunha</option>
            <option value="129">Mariane Barbosa de Sousa</option>
            <option value="130">Maria Vitoria Ribeiro de Sousa</option>
            <option value="131">Matheus Lima de Araujo</option>
            <option value="132">Mayara Vitoria de Moura Capistrano</option>
            <option value="133">Miguel Angelo Ximenes Nogueira</option>
            <option value="134">Mikael Sousa de Araujo</option>
            <option value="135">Pedro Igson Alves Silva</option>
            <option value="136">Pedro Ivo Fernandes Viudez</option>
            <option value="137">Raniely Monteiro da Silva</option>
            <option value="138">Rayele Gama Veras</option>
            <option value="139">Rian Jhones Brito da Silva Barros</option>
            <option value="140">Rosana Paz da Costa</option>
            <option value="141">Sofia Moura Alves</option>
            <option value="142">Stefany Alves dos Santos</option>

            <option value="">3D:</option>
            <option value="143">Alice da Silva Sousa</option>
            <option value="144">Ana Hivyna da Silva Ramos</option>
            <option value="145">Ana Lara Alves da Silva</option>
            <option value="146">Ana Leticia Cardoso Martins</option>
            <option value="147">Ana Livia Sousa da Silva</option>
            <option value="148">Anna Julia Lopes Lemos</option>
            <option value="149">Antonelly Almeida de Abreu</option>
            <option value="150">Beatriz Vieira Sena</option>
            <option value="151">Davi Silva de Lima</option>
            <option value="152">Davydson Soares de Araujo</option>
            <option value="153">Dayana Ferreiras dos Santos</option>
            <option value="154">Derick da Silva Pereira</option>
            <option value="155">Elias Gabriel Brito das Chagas</option>
            <option value="156">Evilin Vitoria Macedo Oliveira</option>
            <option value="157">Felipe Lima Gomes</option>
            <option value="158">Francisco Abner de Sousa Chagas</option>
            <option value="159">Francisco Ariel Andrade de Souza</option>
            <option value="160">Francisco Christyan Teofilo da Silva</option>
            <option value="161">Francisco Edson Sousa Lima Filho</option>
            <option value="162">Francisco Vinicio Cavalcante Brasileiro</option>
            <option value="163">Giselly Sousa Sampaio</option>
            <option value="164">Jamilly Germano Santos</option>
            <option value="165">Jamysson Araujo Bezerra</option>
            <option value="166">Joao Batista Capistrano Filho</option>
            <option value="167">Joao Pedro Abreu da Silva</option>
            <option value="168">Joao Pedro Soares Sousa</option>
            <option value="169">Joao Vitor Cirqueira de Sousa</option>
            <option value="170">Jose Maycon da Silva Abreu</option>
            <option value="171">Levita da Silva Macieira</option>
            <option value="173">Luis Guilherme da Silva Lima</option>
            <option value="174">Luis Otavio do Nascimento Oliveira</option>
            <option value="175">Luiz Fernando Abreu de Mesquita</option>
            <option value="176">Lydson de Sousa Martins</option>
            <option value="177">Marcus Lucas de Araujo</option>
            <option value="178">Maria Alessandra de Souza Morais</option>
            <option value="179">Maria Denise Ferreira de Sousa</option>
            <option value="180">Maria Eduarda Sousa Lima</option>
            <option value="181">Maria Evyla Ribeiro de Oliveira</option>
            <option value="182">Maria Gabriele de Oliveira Lima</option>
            <option value="183">Maria Gabryele de Abreu Mendonca</option>
            <option value="184">Marilia Dayenne Silva de Oliveira Morais</option>
            <option value="185">Milena Andrade do Vale</option>
            <option value="186">Pedro Kaue Cavalcante Lima</option>
            <option value="187">Pedro Lucas Rodrigues Franca</option>
            <option value="188">Rafaely Vitoria Viana Cavalcante</option>
            <option value="189">Rita Silva dos Santos</option>
            <option value="190">Rizle Valentina Nogueira Rodrigues</option>
            <option value="191">Yahshim Maria Rocha do Nascimento</option>
            <option value="192">Yarley Deryk da Costa Holanda</option>
          </select>

          <br>

          <select id="Curso" name="Curso" class="input-field">
            <option value="" disabled selected>Curso</option>
            <option value="1">Enfermagem</option>
            <option value="2">Informática</option>
            <option value="3">Administração</option>
            <option value="4">Edificações</option>
            <option value="5">Meio Ambiente</option>
          </select>

          <select id="Ano" name="Ano" class="input-field">
            <option value="" disabled selected>Ano</option>
            <option value="">1° Ano</option>
            <option value="">2° Ano</option>
            <option value="">3° Ano</option>
          </select></br>

          <br>

          <input type="date" name="data" class="input-field">

          <input type="time" name="hora" class="input-field">

          <input id="btn" type="submit" value="Gerar Relatório" name="btn" class=" btn-submit" method="POST">
          </br></br></br>
        </div>

        <div class="form-group">
          <div class="box">

            <Label>Por Ano:</Label>
            <select id="Ano" class="input-field">
              <option value="" disabled-selected>Selecione o ano</option>
              <option value="">1° Anos</option>
              <option value="">2° Anos</option>
              <option value="">3° Anos</option>
            </select>

            <input id="btn" type="submit" value="Gerar Relatório" name="btn" class=" btn-submit" method="POST">
            <br></br>


            <Label>Por Curso:</Label>
            <select id="Curso" class="input-field">
              <option value="" disabled-selected>Selecione o curso</option>
              <option value="1">Enfermagem</option>
              <option value="2">Informática</option>
              <option value="3">Administração</option>
              <option value="4">Edificações</option>
              <option value="5">Meio Ambiente</option>
            </select>

            <input id="btn" type="submit" value="Gerar Relatório" name="btn" class=" btn-submit" method="POST">
            <br></br>



            <Label>Por Turma:</Label>

            <select id="Turma" class="input-field">
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


            <input id="btn" type="submit" value="Gerar Relatório" name="btn" class=" btn-submit" method="POST">
            <br></br>


          </div>
        </div>

        <footer>
          © 2025 Salaberga - Todos os direitos reservados
        </footer>
      </form>
    </div>
    </div>
  </center>

</body>

</html>