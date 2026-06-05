<?php
declare(strict_types=1);

use config\Database;
use config\Router;

header('Content-Type: application/json; charset=utf-8');

$router = new Router();
$pdo = Database::getConnection();
$repo = new ContatoRepository($pdo);
$service = new ContatoService($repo);

$router->get('/api/contatos', function () use ($service): array{
    $page = max(
        1,
        (int)($_GET['page'] ?? 1)
    );
    $limit  = max(1, min(100, (int)($_GET['limit'] ?? 10)
    )
    );

    return $service->listar($page, $limit);
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

    $id = $repo->criarContato();
    http_response_code(201);
    return ['data' => $repo->buscarPorId($id)];
});

$router->put('/api/contatos/{id}', function(array $params) use($service): array {
   $dados = json_decode(
       file_get_contents('php://input'),
       true
   );

   $ok = $service->atualizar((int)$params['id'],
    $dados);

   if (!$ok) {
       http_response_code(404);
       return ['success' => false,
           'message' => 'Contato não encontrado'];
   }

   return ['success' => true
   ];
});

$router->delete('/api/contatos/{id}', function(array $params) use($service): array {
    $ok = $service->excluir((int)$params['id']);

    if(!$ok){
      http_response_code(404);

      return ['success' => false,
          'message' => 'Contato não encontrado'];
    }

    return ['success' => true,
            'message' => 'Contato removido'];
});
