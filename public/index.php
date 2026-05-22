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

$router->get('/login', 'AuthController@showLoginForm');

$router->post('/login', 'AuthController@login');

$router->get('/logout', 'AuthController@logout');

$router->get('/trajet/creer', 'TrajetController@create');

$router->post('/trajet/creer', 'TrajetController@store');

$router->get('/trajet/reserver', 'TrajetController@reserve');

$router->get('/mon-espace', 'AuthController@profil');

$router->get('/trajet/supprimer', 'TrajetController@delete');

$router->get('/trajet/modifier', 'TrajetController@edit');
$router->post('/trajet/modifier', 'TrajetController@update');

$router->get('/admin', 'AdminController@dashboard');

$router->post('/admin/agence/creer', 'AdminController@storeAgence');
$router->post('/admin/agence/modifier', 'AdminController@updateAgence');
$router->get('/admin/agence/supprimer', 'AdminController@deleteAgence');

$router->get('/admin/trajet/supprimer', 'AdminController@deleteTrajet');

$router->run();