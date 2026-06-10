# 📇 Gerência de Contatos – API REST em PHP
![Php](https://img.shields.io/badge/PHP-8+-blue)
![Architecture](https://img.shields.io/badge/architecture-layered-brightgreen)
![Pattern](https://img.shields.io/badge/pattern-MVC--like-blueviolet)
![PSR-4](https://img.shields.io/badge/PSR--4-autoload-success)

## 📄 Sobre o Projeto

API REST desenvolvida em PHP puro com arquitetura em camadas, seguindo boas práticas como separação de responsabilidades, uso de Repository, Service e Controllers.

O projeto tem como objetivo gerenciar contatos (CRUD) e servir como base de estudo para arquitetura backend em PHP.

---

## 🛠️ Tecnologias Utilizadas

- PHP 8+
- Composer (autoload PSR-4)
- PDO
- PostgreSQL
- vlucas/phpdotenv
- Servidor embutido do PHP

---

## 📁 Organização de pastas

```text
GerenciaContatos/
├── app/
│   ├── Config/
│   │   ├── create_tables.sql
│   │   ├── Database.php
│   │   └── Router.php
│   ├── Controllers/
│   │   └── ContatoController.php
│   ├── Models/
│   │   └── Contato.php
│   ├── Repositories/
│   │   └── ContatoRepository.php
│   ├── Services/
│   │   ├── ContatoService.php
│   │   └── ValidatorService.php
│   ├── Helpers/
│   │   └── PaginationHelper.php
│   └── routes/
│       └── api.php
├── public/
│   └── index.php
├── vendor/
├── .env.example
├── composer.json
└── README.md
```

---

## ⚙️ Como Rodar o Projeto

### 1️⃣ Clonar o repositório
```bash
git clone <url-do-repositorio>
cd GerenciaContatos
```
### 2️⃣ Clonar o repositório
```bash
composer install
```
### 2️⃣ Criar o arquivo .env

Configure o .env com os dados do seu banco;
Arquivo .env.example:
```bash
DB_HOST=localhost
DB_PORT=5432
DB_NAME= ...
DB_USER= ...
DB_PASS= ...
```
### 4️⃣ Rodar o servidor
```bash
php -S localhost:8000 -t public
```
## 📚 Endpoints

### 📇 Contatos

| Método | Endpoint             | Descrição                          |
| ------ | -------------------- | ---------------------------------- |
| POST   | `/api/contatos`      | Cria um novo contato               |
| GET    | `/api/contatos`      | Lista todos os contatos (paginado) |
| GET    | `/api/contatos/{id}` | Busca um contato pelo ID           |
| GET    | `/api/contatos?page=1&limit=10` | page: página atual/limit: qntd por página(min:10,max:100)          |
| PUT    | `/api/contatos/{id}` | Atualiza um contato existente      |
| DELETE | `/api/contatos/{id}` | Remove um contato                  |

#### Exemplo de Body (POST/PUT)
```text
{
  "nome": "João da Silva",
  "email": "joao@email.com",
  "telefone": "47999998888"
}
```

