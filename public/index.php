<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

$router = new Router([
    'paths' => [
        // On remonte d'un dossier (..) pour trouver "app"
        'controllers' => __DIR__ . '/../app/Controllers',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
    ],
    'debug' => true
]);

// Route pour la page d'accueil
$router->get('/', 'HomeController@index');

$router->get('/login', 'AuthController@showLogin');

$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

$router->run();