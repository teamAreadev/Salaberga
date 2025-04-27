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
        $sql_nome_livro = $this->connect->query("SELECT titulo_livro, edicao, editora FROM catalogo");
        $nome = $sql_nome_livro->fetchAll(PDO::FETCH_ASSOC);

        return $nome;
    }
}
