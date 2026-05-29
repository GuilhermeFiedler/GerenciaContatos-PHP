<?php
declare(strict_types=1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403);
        die('Token inválido');
    }

    $nome = trim($_POST['nome'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'] ?? '', FILTER_SANITIZE_STRING);

    $erros = [];
    if (empty($nome) || mb_strlen($nome) > 100) {
        $erros[] = 'Nome é obrigatório';
    }
    if ($email === false) {
        $erros[] = 'E-mail inválido.';
    }
    if ($password === false) {
        $erros[] = 'Senha inválida.';
    }
    if (empty($erros)) {}
}

$_SESSION['csrf'] = bin2hex(random_bytes(32));