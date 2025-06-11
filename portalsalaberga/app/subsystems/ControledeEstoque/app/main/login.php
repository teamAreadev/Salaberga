<?php
session_start();

// Define as credenciais válidas
$validEmail = "estoque2025S@gmail.com";
$validPassword = "Est8690@#$";

// Recebe os dados do formulário
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

header('Content-Type: application/json');

if (empty($email) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Por favor, insira um email válido.']);
    exit;
}

if ($email === $validEmail && $password === $validPassword) {
    $_SESSION['logged_in'] = true;
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Email ou senha incorretos.']);
}
exit;
?>