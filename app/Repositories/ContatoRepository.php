<?php

namespace Gfiedler\GerenciaContatos\Repositories;
use PDO;
use Gfiedler\GerenciaContatos\Models\Contato;

class ContatoRepository
{
    public function __construct(
        private readonly PDO $pdo
    )
    {
    }

    public function criarContato(Contato $contato): int
    {
        $stmt = $this->pdo->prepare("INSERT INTO contatos (nome, email, telefone) VALUES (:nome, :email, :telefone)");
        $stmt->execute([':nome' => $contato->getNome(), ':email' => $contato->getEmail(), ':telefone' => $contato->getTelefone()]);
        return (int)$this->pdo->lastInsertId();
    }

    public function buscarPorId(int $id): ?Contato
    {
        $stmt = $this->pdo->prepare('SELECT id, nome, email, telefone FROM contatos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$dados) {
            return null;
        }

        return new Contato(
            nome: $dados['nome'],
            email: $dados['email'],
            telefone: $dados['telefone'],
            id: (int) $dados['id']
        );
    }
    public function listar(
        int $page = 1,
        int $limit = 10
    ): array
    {
        $offset = ($page - 1) * $limit;

        $stmt = $this->pdo->prepare('SELECT * FROM contatos ORDER BY id DESC LIMIT :limit OFFSET :offset');

        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();

        $contatos = [];

        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $dados) {
            $contatos[] = new Contato(
                nome: $dados['nome'],
                email: $dados['email'],
                telefone: $dados['telefone'],
                id: (int) $dados['id']
            );
        }

        return $contatos;
    }

    public function total(): int
    {
        return (int)$this->pdo
            ->query('SELECT COUNT(*) FROM contatos')
            ->fetchColumn();
    }

    public function atualizar(Contato $contato): bool
    {
        $stmt = $this->pdo->prepare(
            'UPDATE contatos  SET nome = :nome, telefone = :telefone, email = :email WHERE id = :id'
        );
        $stmt->execute([':id' => $contato->getId(), ':nome' => $contato->getNome(), ':email' => $contato->getEmail(), ':telefone' => $contato->getTelefone()]);
        return $stmt->rowCount() > 0;
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->pdo->prepare('DELETE FROM contatos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
