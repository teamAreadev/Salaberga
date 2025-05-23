<?php
$caminho = "../config/connect.php";
if (file_exists($caminho)) {
    require_once('../config/connect.php');
} else {
    require_once('../../config/connect.php');
}


class select_model extends connect
{

    private $catalogo;

    function __construct()
    {
        parent::__construct();
        $this->catalogo = "catalogo";
    }

    public function select_subgenero($genero)
    {

        $sql_idgenero = $this->connect->query("SELECT id FROM genero WHERE generos = '$genero'");
        $id_generos = $sql_idgenero->fetch(PDO::FETCH_ASSOC);
        $id_genero = $id_generos['id'];
        $select_subgenero = $this->connect->query("SELECT subgenero FROM subgenero WHERE id_genero = '$id_genero'");
        $nome_subgenero = $select_subgenero->fetchAll(PDO::FETCH_ASSOC);

        return $nome_subgenero;
    }
    public function select_genero()
    {
        $sql_genero = $this->connect->query("SELECT generos FROM genero");
        $generos = $sql_genero->fetchAll(PDO::FETCH_ASSOC);

        return $generos;
    }
    public function select_qrcode($prateleira, $estante)
    {

        $sql_acervo = $this->connect->query("SELECT * FROM catalogo WHERE pratileira = '$prateleira' AND estante = '$estante'");
        $acervo = $sql_acervo->fetchAll(PDO::FETCH_ASSOC);

        return $acervo;
    }
    public function select_nome_livro()
    {
        $sql_nome_livro = $this->connect->query("SELECT * FROM catalogo");
        $nome = $sql_nome_livro->fetchAll(PDO::FETCH_ASSOC);

        return $nome;
    }
    public function select_nome_livro_especifico()
    {
        $sql_nome_livro = $this->connect->query("SELECT DISTINCT titulo_livro FROM catalogo");
        $nome = $sql_nome_livro->fetchAll(PDO::FETCH_ASSOC);

        return $nome;
    }

    public function select_livro_especifico($titulos){
        $array_dados = []; // Inicializar o array antes do loop

        foreach ($titulos as $titulo) {
            // Usar prepared statement para evitar SQL Injection
            $select_dados_livro = $this->connect->prepare("SELECT * FROM catalogo WHERE titulo_livro = ?");
            $select_dados_livro->execute([$titulo]);

            $dados_livros = $select_dados_livro->fetchAll(PDO::FETCH_ASSOC);
            
            array_push($array_dados, $dados_livros);
        }
        
        return $array_dados;
    }
}
