<?php
namespace Gfiedler\GerenciaContatos\Controller;

use Gfiedler\GerenciaContatos\Services\ContatoService;

class ContatoController
{
    public function __construct(
        private readonly ContatoService $service
    ){}

    public function index(): array {
        $page = max(
            1,
            (int)($_GET['page'] ?? 1)
        );
        $limit  = max(1, min(100, (int)($_GET['limit'] ?? 10)
            )
        );

        return $this->service->listar($page, $limit);
    }
    public function show(array $params): array {
        $contato = $this->service->buscar((int) $params['id']);
        if (!$contato) {
            http_response_code(404);
            return ['error' => 'Contato não encontrado'];
        }

        return $contato;
    }

    public function store(): array {
        $raw = file_get_contents('php://input');
        $dados = json_decode($raw, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            http_response_code(400);
            return ['error' => 'JSON inválido'];
        }

    try{$contato = $this->service->criar($dados);

        http_response_code(201);
        return ['success' => true, 'data' => $contato];}catch(\InvalidArgumentException $e){http_response_code(400);

        return ['success' => false, 'message' => $e->getMessage()];}

    }

    public function update(array $params): array {
        $dados = json_decode(
            file_get_contents('php://input'),
            true
        );

        try{        $ok = $this->service->atualizar((int)$params['id'],
            $dados);

            if (!$ok) {
                http_response_code(404);
                return ['success' => false,
                    'message' => 'Contato não encontrado'];
            }

            return ['success' => true
            ];} catch (\InvalidArgumentException $e) {http_response_code(400);
        return ['success' => false, 'message' => $e->getMessage()];}

    }

    public function destroy(array $params): array {
        $ok = $this->service->excluir((int)$params['id']);

        if(!$ok){
            http_response_code(404);

            return ['success' => false,
                'message' => 'Contato não encontrado'];
        }

        return ['success' => true,
            'message' => 'Contato removido'];
    }
}