<?php
session_start();

// Pega o nome do arquivo atual
$current_page = basename($_SERVER['PHP_SELF']);

// Função para verificar se já está na página correta
function isCurrentPage($page)
{
    global $current_page;
    return $current_page === $page;
}

// Só redireciona se NÃO estiver na página correta
if (isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['aluno']) && $_SESSION['aluno']) {
    if (!isCurrentPage('subsistema_aluno.php')) {
        header('Location: ../aluno/subsistema_aluno.php');
        exit();
    }
} else if (isset($_SESSION['login']) && $_SESSION['login'] && isset($_SESSION['professor']) && $_SESSION['professor']) {
    if (!isCurrentPage('subsistema_professor.php')) {
        header('Location: ../professor/subsistema_professor.php');
        exit();
    }
} else if (isset($_SESSION['precadastro']) && $_SESSION['precadastro']) {
    if (!isCurrentPage('cadastro.php')) {
        header('Location: ../autenticação/cadastro.php');
        exit();
    }
} else {
    if (!isCurrentPage('precadastro.php')) {
        header('Location: ../autenticação/precadastro.php');
        exit();
    }
}
?>