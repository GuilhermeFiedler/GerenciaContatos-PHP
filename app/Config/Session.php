<?php
declare(strict_types=1);

ini_set('session.cookie_httponly', '1');
ini_set('session.cookie_secure', '1');
ini_set('session.use_strict_mode', '1');
ini_set('session.cookie_samesite', '1');

session_start();

//Autenticação function
function login(array $usuario): void {
    session_regenerate_id(true);
    $_SESSION['user_id'] = $usuario['id'];
    $_SESSION['user_name'] = $usuario['nome'];
    $_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['login_time'] = time();
}
function isLoggedIn(): bool {
    return isset($_SESSION['user_id'])
        && $_SESSION['ip'] === $_SERVER['REMOTE_ADDR']
        && (time() - $_SESSION['login_time']) < 1800;
}

function logout(): void {
    $_SESSION = [];
    session_destroy();
    setcookie(session_name(), '', time() - 3600, '/');
}