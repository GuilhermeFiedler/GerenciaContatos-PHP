<?php
declare(strict_types=1);

use Gfiedler\GerenciaContatos\Config\Database;
use Gfiedler\GerenciaContatos\Controller\ContatoController;
use Gfiedler\GerenciaContatos\Config\Router;
use Gfiedler\GerenciaContatos\Repositories\ContatoRepository;
use Gfiedler\GerenciaContatos\Services\ContatoService;


$router = new Router();
$pdo = Database::getConnection();
$repo = new ContatoRepository($pdo);
$service = new ContatoService($repo);
$controller = new ContatoController($service);

$router->get('/api/contatos', fn() => $controller->index());
$router->get('/api/contatos/{id}', fn($params) => $controller->show($params));
$router->post('/api/contatos', fn() => $controller->store());
$router->put('/api/contatos/{id}', fn($params) => $controller->update($params));
$router->delete('/api/contatos/{id}',  fn($params) => $controller->destroy($params));

$router->dispatch();