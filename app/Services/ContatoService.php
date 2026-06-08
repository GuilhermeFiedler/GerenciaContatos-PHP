<?php


namespace Gfiedler\GerenciaContatos\Services;

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

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('E-mail inválido');
        }

        if (!preg_match('/^\d{10,11}', $telefone)) {
            throw new InvalidArgumentException('Telefone inválido');
        }

        $id = $this->repository->criarContato(
            $nome,
            $email,
            $telefone
        );

        return $this->repository->buscarPorId($id);
    }

    public function atualizar(int $id, array $dados): bool
    {
        $nome = trim($dados['nome'] ?? '');
        $email = trim($dados['email'] ?? '');
        $telefone = preg_replace('/\D/', '', $dados['telefone'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('E-mail inválido');
        }

        if (!preg_match('/^\d{10,11}$/', $telefone)) {
            throw new InvalidArgumentException('Telefone inválido');
        }

        return $this->repository->atualizar(
            $id,
            $nome,
            $email,
            $telefone
        );
    }

    public function excluir(int $id): bool
    {
        return $this->repository->excluir($id);
    }

    public function buscar(int $id): ?array
    {
        return $this->repository->buscarPorId($id);
    }

    public function listar(int $page, int $limit): array
    {
        $dados = $this->repository->listar(
            $page,
            $limit
        );

        $total = $this->repository->total();

        return PaginationHelper::format($dados, $page, $limit, $total);
    }
}