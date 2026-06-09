<?php

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

require_once __DIR__ . '/../app/routes/api.php';


/*Construa uma API REST completa de gerenciamento de contatos: CRUD com PDO e prepared
statements, validação de e-mail e telefone, paginação na listagem, e respostas JSON padronizadas
com códigos HTTP apropriados. */