<?php

/** Inclui o arquivo de configuração que contém a classe connect para conexão com o banco de dados */
require_once('../config/connect.php');

/** Define a classe main_model, que herda da classe connect para usar a conexão com o banco */
class main_model extends connect
{

    //atrivbutos
    /** Declara uma propriedade privada para armazenar o nome da tabela 'catalogo' */
    private $catalogo;

    /** Construtor da classe: inicializa a conexão do pai e define o nome da tabela catalogo */
    function __construct()
    {
        /** Chama o construtor da classe pai (connect) para configurar a conexão com o banco */
        parent::__construct();
        /** Atribui o valor "catalogo" à propriedade $catalogo */
        $this->catalogo = "catalogo";
    }

    /** Método público para cadastrar livros no banco, recebendo informações do livro e autores */
    public function cadastrar_livros($nome, $sobrenome, $titulo, $data, $editora, $edicao, $quantidade, $corredor, $estante, $prateleira, $subgenero, $literatura, $ficcao, $cativo)
    {
        /** Prepara uma query para verificar se o livro já existe com base em título, editora e edição */
        $sql_check = $this->connect->prepare("SELECT * FROM catalogo WHERE titulo_livro = :titulo AND edicao = :edicao AND editora = :editora");
        /** Associa o valor do parâmetro $titulo ao placeholder :titulo */
        $sql_check->bindValue(':titulo', $titulo);
        /** Associa o valor do parâmetro $edicao ao placeholder :edicao */
        $sql_check->bindValue(':edicao', $edicao);
         /** Associa o valor do parâmetro $edicao ao placeholder :editora */
         $sql_check->bindValue(':editora', $editora);
        /** Executa a query preparada */
        $sql_check->execute();
        /** Busca o resultado da query como um array associativo */
        $check = $sql_check->fetch(PDO::FETCH_ASSOC);

        /** Verifica se o livro não existe (resultado vazio) para prosseguir com o cadastro */
        if (empty($check)) {

            /** Executa uma query direta para buscar o id e id_genero do subgênero informado */
            $sql_id = $this->connect->query("SELECT id, id_genero FROM subgenero WHERE subgenero = '$subgenero'");
            /** Armazena o resultado da busca como um array associativo */
            $id = $sql_id->fetch(PDO::FETCH_ASSOC);

            /** Prepara uma query para inserir um novo livro na tabela catalogo */
            $cadastro_livro = $this->connect->prepare("INSERT INTO $this->catalogo VALUES (null, :titulo_livro, :ano_publicacao, :editora, :edicao, :quantidade, :corredor, :estante, :prateleira, :genero, :subgenero, :ficcao, :literatura, :cativo)");

            /** Associa os valores dos parâmetros aos placeholders da query de inserção */
            $cadastro_livro->bindValue(':titulo_livro', $titulo);
            $cadastro_livro->bindValue(':ano_publicacao', $data);
            $cadastro_livro->bindValue(':editora', $editora);
            $cadastro_livro->bindValue(':edicao', $edicao);
            $cadastro_livro->bindValue(':quantidade', $quantidade);
            $cadastro_livro->bindValue(':corredor', $corredor);
            $cadastro_livro->bindValue(':estante', $estante);
            $cadastro_livro->bindValue(':prateleira', $prateleira);
            $cadastro_livro->bindValue(':genero', $id['id_genero']);
            $cadastro_livro->bindValue(':subgenero', $id['id']);
            $cadastro_livro->bindValue(':ficcao', $ficcao);
            $cadastro_livro->bindValue(':literatura', $literatura);
            $cadastro_livro->bindValue(':cativo', $cativo);

            /** Executa a query para inserir o livro */
            $cadastro_livro->execute();

            /** Prepara uma query para buscar o id do livro recém-inserido */
            $sql_id_livro = $this->connect->prepare("SELECT id FROM catalogo WHERE titulo_livro = :titulo AND editora = :editora AND edicao = :edicao");
            $sql_id_livro->bindValue(':titulo', $titulo);
            $sql_id_livro->bindValue(':editora', $editora);
            $sql_id_livro->bindValue(':edicao', $edicao);
            $sql_id_livro->execute();
            /** Armazena o id do livro como um array associativo */
            $id_livro = $sql_id_livro->fetch(PDO::FETCH_ASSOC);

            /** Calcula o tamanho do array de nomes de autores menos 1 para o loop */
            $tamanho_array = count($nome) - 1;
            /** Inicia um loop para processar cada autor do livro */
            for ($x = 0; $x <= $tamanho_array; $x++) {

                /** Pega o nome e sobrenome do autor atual do array */
                $nome_array = $nome[$x];
                $sobrenome_array = $sobrenome[$x];

                /** Verifica se o autor já existe na tabela autores */
                $sql_check = $this->connect->prepare("SELECT nome_autor, sobrenome_autor FROM autores WHERE nome_autor = :nome_autor AND sobrenome_autor = :sobrenome_autor");
                $sql_check->bindValue(':nome_autor', $nome_array);
                $sql_check->bindValue(':sobrenome_autor', $sobrenome_array);
                $sql_check->execute();
                $autores = $sql_check->fetch(PDO::FETCH_ASSOC);

                /** Se o autor não existe, cadastra um novo */
                if (empty($autores)) {
                    /** Prepara a query para inserir um novo autor */
                    $sql_autor = $this->connect->prepare("INSERT INTO autores VALUES(NULL, :nome_autor, :sobrenome_autor)");
                    $sql_autor->bindValue(':nome_autor', $nome_array);
                    $sql_autor->bindValue(':sobrenome_autor', $sobrenome_array);
                    $sql_autor->execute();

                    /** Busca o id do autor recém-cadastrado */
                    $sql_check = $this->connect->prepare("SELECT id FROM autores WHERE nome_autor = :nome_autor AND sobrenome_autor = :sobrenome_autor");
                    $sql_check->bindValue(':nome_autor', $nome_array);
                    $sql_check->bindValue(':sobrenome_autor', $sobrenome_array);
                    $sql_check->execute();
                    $id_autor = $sql_check->fetch(PDO::FETCH_ASSOC);

                    /** Insere a relação entre o autor e o livro na tabela livros_autores */
                    $sql_id_autor_livro = $this->connect->prepare("INSERT INTO livros_autores VALUES(NULL, :id_autor, :id_livro)");
                    $sql_id_autor_livro->bindValue(':id_autor', $id_autor['id']);
                    $sql_id_autor_livro->bindValue(':id_livro', $id_livro['id']);
                    $sql_id_autor_livro->execute();
                    
                } else {
                    /** Se o autor já existe, apenas busca o id dele */
                    $sql_check = $this->connect->prepare("SELECT id FROM autores WHERE nome_autor = :nome_autor AND sobrenome_autor = :sobrenome_autor");
                    $sql_check->bindValue(':nome_autor', $nome_array);
                    $sql_check->bindValue(':sobrenome_autor', $sobrenome_array);
                    $sql_check->execute();
                    $id_autor = $sql_check->fetch(PDO::FETCH_ASSOC);

                    /** Insere a relação entre o autor existente e o livro na tabela livros_autores */
                    $sql_id_autor_livro = $this->connect->prepare("INSERT INTO livros_autores VALUES(NULL, :id_autor, :id_livro)");
                    $sql_id_autor_livro->bindValue(':id_autor', $id_autor['id']);
                    $sql_id_autor_livro->bindValue(':id_livro', $id_livro['id']);
                    $sql_id_autor_livro->execute();
                }
            }

            /** Verifica se as inserções do livro e da relação autor-livro foram bem-sucedidas */
            if ($cadastro_livro && $sql_id_autor_livro) {
                /** Retorna 1 se o cadastro foi concluído com sucesso */
                return 1;
            } else {
                /** Retorna 2 se houve algum erro no cadastro */
                return 2;
            }
        } else {
            /** Retorna 3 se o livro já existe no catálogo */
            return 3;
        }
    }

    /** Método público para cadastrar um subgênero no banco */
    public function cadastrar_subgenero($genero, $subgenero)
    {
        /** Busca o id do gênero com base no nome fornecido */
        $sql_idgenero = $this->connect->prepare("SELECT id FROM genero WHERE generos = :generos");
        $sql_idgenero->bindValue(':generos', $genero);
        $sql_idgenero->execute();
        $id_genero = $sql_idgenero->fetch(PDO::FETCH_ASSOC);

        /** Verifica se o subgênero já existe para o gênero especificado */
        $sql_check = $this->connect->prepare("SELECT * FROM subgenero WHERE subgenero = :subgenero AND id_genero = :id_genero");
        $sql_check->bindValue(':subgenero', $subgenero);
        $sql_check->bindValue(':id_genero', $id_genero['id']);
        $sql_check->execute();
        $subgeneros = $sql_check->fetch(PDO::FETCH_ASSOC);

        /** Se o subgênero não existe, prossegue com o cadastro */
        if (empty($subgeneros)) {
            /** Prepara e executa a inserção do novo subgênero */
            $sql_subgenero = $this->connect->prepare("INSERT INTO subgenero VALUES (NULL, :subgenero, :id_genero)");
            $sql_subgenero->bindValue(':subgenero', $subgenero);
            $sql_subgenero->bindValue(':id_genero', $id_genero['id']);
            $sql_subgenero->execute();

            /** Verifica se a inserção foi bem-sucedida */
            if ($sql_subgenero) {
                /** Retorna 1 se o subgênero foi cadastrado com sucesso */
                return 1;
            } else {
                /** Retorna 2 se houve erro ao cadastrar o subgênero */
                return 2;
            }
        } else {
            /** Retorna 3 se o subgênero já existe */
            return 3;
        }
    }

    /** Método público para cadastrar um novo gênero no banco */
    public function cadastrar_genero($nome_genero)
    {
        /** Verifica se o gênero já existe na tabela genero */
        $sql_check = $this->connect->prepare("SELECT * FROM genero WHERE  generos = :genero");
        $sql_check->bindValue(':genero', $nome_genero);
        $sql_check->execute();
        $generos = $sql_check->fetch(PDO::FETCH_ASSOC);

        /** Se o gênero não existe, prossegue com o cadastro */
        if (empty($generos)) {
            /** Insere o novo gênero na tabela genero */
            $sql_genero = $this->connect->prepare("INSERT INTO genero VALUES (NULL, :novo_genero)");
            $sql_genero->bindValue(':novo_genero', $nome_genero);
            $sql_genero->execute();

            /** Busca o id do gênero recém-cadastrado */
            $sql_id_genero = $this->connect->prepare("SELECT id FROM genero WHERE generos = :genero2");
            $sql_id_genero->bindValue(':genero2', $nome_genero);
            $sql_id_genero->execute();
            $id_genero = $sql_id_genero->fetch(PDO::FETCH_ASSOC);

            /** Insere o gênero como subgênero na tabela subgenero */
            $sql_insert_subgenero = $this->connect->prepare("INSERT INTO subgenero VALUES (NULL, :genero2, :id_genero)");
            $sql_insert_subgenero->bindValue(':genero2', $nome_genero);
            $sql_insert_subgenero->bindValue(':id_genero', $id_genero['id']);
            $sql_insert_subgenero->execute();

            /** Verifica se a inserção do subgênero foi bem-sucedida */
            if ($sql_insert_subgenero) {
                /** Retorna 1 se o gênero e subgênero foram cadastrados com sucesso */
                return 1;
            } else {
                /** Retorna 2 se houve erro ao cadastrar */
                return 2;
            }
        } else {
            /** Retorna 3 se o gênero já existe */
            return 3;
        }
    }
}