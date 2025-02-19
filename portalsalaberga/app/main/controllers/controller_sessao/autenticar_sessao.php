<?php
// Inicia a sessão
session_start();

if (isset($_GET['sair'])){
// Destroi todas as variáveis de sessão
$_SESSION = array();

/*
// Se deseja destruir a sessão completamente, apague também o cookie de sessão.
// Nota: Isso destruirá a sessão, e não apenas os dados da sessão!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}
*/
// Finalmente, destrói a sessão
session_destroy();

// Redireciona para a página de login ou inicial
header('Location: ../../views/autenticacao/login.php'); // Substitua 'login.php' pela página desejada
exit();
    }

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
        header('Location: ../../views/autenticacao/cadastro.php');
        exit();
    }
} else {
    if (!isCurrentPage('precadastro.php')) {
        header('Location: ../../views/autenticacao/precadastro.php');
        exit();
    }
}
?>