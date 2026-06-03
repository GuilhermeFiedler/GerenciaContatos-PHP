<?php

class UsuarioRepository{
    public function __construct(private readonly PDO $pdo){}

    public function criar(string $nome, string $email, string $senha) : int {
        $stmt = $this->pdo->prepare(
            'INSERT INTO usuarios(nome, email, senha_hash, criado_em)
                   VALUES (:nome, :email, :senha_hash, NOW())'
        );
        $stmt->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':senha_hash' => password_hash($senha, PASSWORD_ARGON2I)
        ]);
        return (int) $this->pdo->lastInsertId();
    }

    public function buscarPorId(int $id): ?array {
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, email, criado_em FROM usuarios WHERE id = :id'
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch() ?: null;
    }

    public function listar(int $pagina = 1, int $porPagina = 20) : array {
        $offset = ($pagina - 1) * $porPagina;
        $stmt = $this->pdo->prepare(
            'SELECT id, nome, email, criado_em FROM usuarios
                   ORDER BY criado_em DESC LIMIT :pagina OFFSET :offset'
        );
        $stmt->bindValue(':limite', $porPagina, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function atualizar(int $id, string $nome, string $email, string $senha): bool {
        $stmt = $this->pdo->prepare(
            'UPDATE usuarios SET nome = :nome, email = :email, senha = :senha, where id = :id'
        );
        $stmt->execute([':id' => $id, ':nome' => $nome, ':email' => $email]);
        return $stmt->rowCount() === 1;
    }

    public function excluir(int $id): bool {
        $stmt = $this->pdo->prepare('DELETE FROM usuarios WHERE id = :id');
        $stmt->execute([':id'=> $id]);
        return $stmt->rowCount() > 0;
    }
}