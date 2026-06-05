<?php

class ContatoRepository{
    public function __construct(
        private readonly PDO $pdo
) {}

    public function criarContato(string $nome, string $email, string $telefone): int {
        $stmt = $this->pdo->prepare("INSERT INTO contatos (nome, email, telefone) VALUES (:nome, :email, :telefone)");
        $stmt->execute([':nome' => $nome, ':email' => $email, ':telefone' => $telefone]);
        return (int) $this->pdo->lastInsertId();
    }

    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare('SELECT id, nome, email, telefone FROM contatos WHERE id = :id');
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch() ?: null;
    }

    public function listar(
        int $page = 1,
        int $limit = 10
    ): array {
        $offset = ($page -1) * $limit;

        $stmt = $this->pdo->prepare('SELECT * FROM contatos ORDER BY id DESC LIMIT :limit OFFSET :offset');

    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);

    $stmt->execute();

    return $stmt->fetchAll();
    }

    public function total(): int {
        return (int)$this->pdo
            ->query('SELECT COUNT(*) FROM contatos')
            ->fetchColumn();
    }

    public function atualizar(int $id, string $nome, string $email, string $telefone): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE contatos  SET nome = :nome, telefone = :telefone, email = :email WHERE id = :id'
        );
        $stmt->execute([':id' => $id, ':nome' => $nome,':email' => $email ,':telefone' => $telefone]);
        return $stmt->rowCount() > 0;
    }

    public function excluir(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM contatos WHERE id = :id');
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
