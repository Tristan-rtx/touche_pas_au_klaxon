<?php

// On charge l'autoloader de Composer pour avoir accès au routeur
require_once __DIR__ . '/../vendor/autoload.php';

use Buki\Router\Router;

// Initialisation du routeur
$router = new Router([
    'paths' => [
        'controllers' => 'app/Controllers',
    ],
    'namespaces' => [
        'controllers' => 'App\Controllers',
    ]
]);

// --- DÉFINITION DES ROUTES ---

// Route pour la page d'accueil (URL : / )
$router->get('/', function() {
    return "<h1>Bienvenue sur l'application de covoiturage ! 🚗</h1><p>Le routeur fonctionne parfaitement.</p>";
});

// --- EXÉCUTION DU ROUTEUR ---
$router->run();