<?php

class ContatoRepository{
    public function __construct(
        private readonly PDO $pdo
) {}

    public function criarContato(string $nome, string $telefone): int {
        $stmt = $this->pdo->prepare("INSERT INTO contatos (nome, email, telefone) VALUES (:nome, :telefone)");
        $stmt->execute([':nome' => $nome, ':telefone' => $telefone]);
        return (int) $this->pdo->lastInsertId();
    }

    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT id, nome, email, telefone FROM contatos WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch() ?: null;
    }

    public function atualizar(int $id, string $nome, string $telefone): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE contatos  SET nome = :nome, telefone = :telefone, email = :email WHERE id = :id'
        );
        $stmt->execute([':id' => $id, ':nome' => $nome, ':telefone' => $telefone]);
        return $stmt->rowCount() > 0;
    }

    public function excluir(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM contatos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
