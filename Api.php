<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

$router = new Router();
$pdo = Database::getConnection();
$repo = new ContatoRepository($pdo);

$router->get('/api/contatos', function () use ($repo): array{
    return ['data' => $repo->listar()];
});
//buscar por id
$router->get('/api/contatos/{id}', function (array $params) use ($repo): array {
    $contato = $repo->buscarPorId((int) $params['id']);
    if (!$contato) {
        http_response_code(404);
        return ['erro' => 'Contato não encontrado'];
    }
    return ['data' => $contato];
});

$router->post('/api/contatos', function () use ($repo): array{
    $input = json_decode(file_get_contents('php://input'), true);

    //validar com json_validate
    $raw = file_get_contents('php://input');
    if (!json_validate($raw)) {
        http_response_code(400);
        return ['erro' => 'JSON inválido'];
    }

    $nome = trim($input['nome'] ?? '');
    if (empty($nome)){
        http_response_code(422);
        return ['erro' => 'Nome é obrigatório'];
    }

    $id = $repo->criar($nome, $input['numero'] ?? '');
    http_response_code(201);
    return ['data' => $repo->buscarPorId($id)];
});