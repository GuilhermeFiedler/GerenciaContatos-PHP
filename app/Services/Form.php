<?php
declare(strict_types=1);

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar CSRF token
    if (!hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(403);
        die('Token inválido.');
    }

    //  Validar e sanitizar campos
    $nome = trim($_POST['nome'] ?? '');
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
    $idade = filter_var($_POST['idade'] ?? 0, FILTER_VALIDATE_INT, [
        'options' => ['min_range' => 1, 'max_range' => 150]
    ]);

    $erros = [];
    if (empty($nome) || mb_strlen($nome) > 100) {
        $erros[] = 'Nome é obrigatório (máx. 100 caracteres).';
    }
    if ($email === false) {
        $erros[] = 'E-mail inválido.';
    }
    if ($idade === false) {
        $erros[] = 'Idade inválida.';
    }

    if (empty($erros)) {
        // Processar dados validados
        // ...
    }
}

// Gerar token CSRF para o formulário
$_SESSION['csrf'] = bin2hex(random_bytes(32));