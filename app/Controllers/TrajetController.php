<?php

namespace App\Controllers;

use App\Models\AgenceModel;

class TrajetController
{
    // 1. Afficher le formulaire de création
    public function create()
    {
        // Sécurité : Si l'utilisateur n'est pas connecté, on le chasse vers le login
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // On récupère les agences pour alimenter les <select> du formulaire
        $agenceModel = new AgenceModel();
        $agences = $agenceModel->getAllAgences();

        require_once __DIR__ . '/../Views/trajet/creer.php';
    }

    // 2. Traiter la soumission du formulaire et insérer en BDD
    public function store()
    {
        // Sécurité
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        // Récupération des données du formulaire
        $id_agence_depart  = $_POST['id_agence_depart'] ?? null;
        $id_agence_arrivee = $_POST['id_agence_arrivee'] ?? null;
        $gdh_depart        = $_POST['gdh_depart'] ?? null;
        $gdh_arrivee       = $_POST['gdh_arrivee'] ?? null;
        $places_totales    = $_POST['places_totales'] ?? null;
        
        // L'ID du conducteur est celui de l'employé connecté en session !
        $id_utilisateur    = $_SESSION['user']['id_utilisateur']; 

        // Connexion rapide à la BDD pour l'insertion
        $db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
        
        $sql = "INSERT INTO trajet (gdh_depart, gdh_arrivee, places_totales, places_disponibles, id_agence_depart, id_agence_arrivee, id_utilisateur) 
                VALUES (:gdh_depart, :gdh_arrivee, :places_totales, :places_disponibles, :id_agence_depart, :id_agence_arrivee, :id_utilisateur)";
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'gdh_depart'        => $gdh_depart,
            'gdh_arrivee'       => $gdh_arrivee,
            'places_totales'    => $places_totales,
            'places_disponibles'=> $places_totales, // Au départ, toutes les places sont libres !
            'id_agence_depart'  => $id_agence_depart,
            'id_agence_arrivee' => $id_agence_arrivee,
            'id_utilisateur'    => $id_utilisateur
        ]);

        // Une fois inséré, on redirige vers l'accueil
        header('Location: /');
        exit;
    }
} // <--- ELLE EST ICI MAINTENANT, BIEN À SA PLACE POUR TOUT FERMER !