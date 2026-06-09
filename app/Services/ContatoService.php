<?php


namespace Gfiedler\GerenciaContatos\Services;

use Gfiedler\GerenciaContatos\Models\Contato;
use Gfiedler\GerenciaContatos\Repositories\ContatoRepository;
use InvalidArgumentException;
use Gfiedler\GerenciaContatos\Helpers\PaginationHelper;

class ContatoService
{
    public function __construct(
        private readonly ContatoRepository $repository
    )
    {
    }

    public function criar(array $dados): array
    {
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = preg_replace('/\D/', '', $dados['telefone'] ?? '');

        if ($nome === '') {
            throw new InvalidArgumentException('Nome é obrigatório');
        }

        if (!ValidatorService::email($email)) {
            throw new InvalidArgumentException('E-mail inválido');
        }

        if (!ValidatorService::telefone($telefone)) {
            throw new InvalidArgumentException('Telefone inválido');
        }

        $contato = new Contato(
            nome : $nome,
            email: $email,
            telefone: $telefone,
        );
        $id = $this->repository->criarContato($contato);

        $contato = $this->repository->buscarPorId($id);
        
        return $this->toArray($contato);
    }

    public function atualizar(int $id, array $dados): bool
    {
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = preg_replace('/\D/', '', $dados['telefone'] ?? '');

        if (!ValidatorService::email($email)) {
            throw new InvalidArgumentException('E-mail inválido');
        }

        if (!ValidatorService::telefone($telefone)) {
            throw new InvalidArgumentException('Telefone inválido');
        }

        $contato = new Contato(
            nome : $nome,
            email: $email,
            telefone: $telefone,
            id: $id
        );

        return $this->repository->atualizar($contato);
    }

    public function excluir(int $id): bool
    {
        return $this->repository->excluir($id);
    }

    public function buscar(int $id): ?array
    {
        $contato = $this->repository->buscarPorId($id);

        if (!$contato) {
            return null;
        }
        return $this->toArray($contato);
    }

    public function listar(int $page, int $limit): array
    {
        $dados = $this->repository->listar(
            $page,
            $limit
        );

        $total = $this->repository->total();

        $dadosFormatados = array_map(fn (Contato $c) => $this->toArray($c), $dados);

        return PaginationHelper::format($dadosFormatados, $page, $limit, $total);
    }

    private function toArray(Contato $contato): array
    {
        return [
            'id' => $contato->getId(),
            'nome' => $contato->getNome(),
            'email' => $contato->getEmail(),
            'telefone' => $contato->getTelefone(),
        ];
    }
}