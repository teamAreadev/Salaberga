<?php
function verificarSessaoSenha($tempo_limite = 10) {
    // Verifica se existe timestamp da última atividade
    if (isset($_SESSION['ultimo_acesso'])) {
        // Verifica se já passou do tempo limite
        if (time() - $_SESSION['ultimo_acesso'] > $tempo_limite) {
            session_unset();
            session_destroy();
            header("Location: ../../views/autenticação/login.php");
            exit();
        }
    }
    
    // Atualiza o timestamp
    $_SESSION['ultimo_acesso'] = time();
}

function verificarSessao($tempo_limite = 60) {
    // Verifica se existe timestamp da última atividade
    if (isset($_SESSION['ultimo_acesso'])) {
        // Verifica se já passou do tempo limite
        if (time() - $_SESSION['ultimo_acesso'] > $tempo_limite) {
            session_unset();
            session_destroy();
            header("Location: ../../views/autenticação/login.php");
            exit();
        }
    }
    
    // Atualiza o timestamp
    $_SESSION['ultimo_acesso'] = time();
}


?>