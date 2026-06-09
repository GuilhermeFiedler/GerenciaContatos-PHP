<?php
namespace Gfiedler\GerenciaContatos\Models;
use JsonSerializable;
class Contato implements JsonSerializable{
    public function __construct(
        private string $nome,
        private string $email,
        private string $telefone,
        private readonly ?int $id = null,
    ) {}

    public function jsonSerialize(): array{
        return ['id' => $this->id, 'nome' => $this->nome, 'email' => $this->email, 'telefone' => $this->telefone];
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getNome(): string
    {
        return $this->nome;
    }


    public function getEmail(): string
    {
        return $this->email;
    }


    public function getTelefone(): string
    {
        return $this->telefone;
    }

        }
