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
        
        // L'ID du conducteur est celui de l'employé connecté en session
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
            'places_disponibles'=> $places_totales, // Toutes les places sont initialement libres
            'id_agence_depart'  => $id_agence_depart,
            'id_agence_arrivee' => $id_agence_arrivee,
            'id_utilisateur'    => $id_utilisateur
        ]);

        // Message Flash de succès
        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Le trajet a été publié avec succès sur l'intranet."
        ];

        header('Location: /');
        exit;
    }

    // 3. Supprimer un trajet (Réservé à l'auteur)
    public function delete()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $id_trajet = $_GET['id'] ?? null;
        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        if ($id_trajet) {
            $db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
            
            // Étape 1 : Vérifier s'il y avait des réservations actives
            $stmtCheck = $db->prepare("SELECT COUNT(*) FROM reservation WHERE id_trajet = :id_trajet");
            $stmtCheck->execute(['id_trajet' => $id_trajet]);
            $nbPassagers = $stmtCheck->fetchColumn();

            // Étape 2 : Supprimer d'abord les réservations pour éviter l'erreur de contrainte d'intégrité (FK)
            $stmtRes = $db->prepare("DELETE FROM reservation WHERE id_trajet = :id_trajet");
            $stmtRes->execute(['id_trajet' => $id_trajet]);

            // Étape 3 : Supprimer le trajet en vérifiant que l'utilisateur est bien l'auteur
            $stmtTrajet = $db->prepare("DELETE FROM trajet WHERE id_trajet = :id_trajet AND id_utilisateur = :id_utilisateur");
            $stmtTrajet->execute([
                'id_trajet' => $id_trajet,
                'id_utilisateur' => $id_utilisateur
            ]);

            // Étape 4 : Notification par Message Flash
            if ($nbPassagers > 0) {
                $_SESSION['flash'] = [
                    'type' => 'warning',
                    'message' => "Le trajet a bien été supprimé. Un message automatique a été envoyé aux $nbPassagers passager(s) inscrit(s)."
                ];
            } else {
                $_SESSION['flash'] = [
                    'type' => 'success',
                    'message' => "Votre trajet a été supprimé avec succès."
                ];
            }
        }

        header('Location: /');
        exit;
    }

    // 4. Afficher le formulaire de modification
    public function edit()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $id_trajet = $_GET['id'] ?? null;
        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        $db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
        
        $stmt = $db->prepare("SELECT * FROM trajet WHERE id_trajet = :id_trajet AND id_utilisateur = :id_utilisateur");
        $stmt->execute(['id_trajet' => $id_trajet, 'id_utilisateur' => $id_utilisateur]);
        $trajet = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$trajet) {
            header('Location: /');
            exit;
        }

        $agenceModel = new \App\Models\AgenceModel();
        $agences = $agenceModel->getAllAgences();

        require_once __DIR__ . '/../Views/trajet/modifier.php';
    }

    // 5. Traiter la mise à jour en BDD
    public function update()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $id_trajet         = $_POST['id_trajet'] ?? null;
        $id_utilisateur    = $_SESSION['user']['id_utilisateur'];
        $id_agence_depart  = $_POST['id_agence_depart'] ?? null;
        $id_agence_arrivee = $_POST['id_agence_arrivee'] ?? null;
        $gdh_depart        = $_POST['gdh_depart'] ?? null;
        $gdh_arrivee       = $_POST['gdh_arrivee'] ?? null;
        $places_totales    = $_POST['places_totales'] ?? null;

        $db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
        
        $sql = "UPDATE trajet 
                SET id_agence_depart = :id_agence_depart, 
                    id_agence_arrivee = :id_agence_arrivee, 
                    gdh_depart = :gdh_depart, 
                    gdh_arrivee = :gdh_arrivee, 
                    places_totales = :places_totales,
                    places_disponibles = :places_totales
                WHERE id_trajet = :id_trajet AND id_utilisateur = :id_utilisateur";
                
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'id_agence_depart'  => $id_agence_depart,
            'id_agence_arrivee' => $id_agence_arrivee,
            'gdh_depart'        => $gdh_depart,
            'gdh_arrivee'       => $gdh_arrivee,
            'places_totales'    => $places_totales,
            'id_trajet'         => $id_trajet,
            'id_utilisateur'    => $id_utilisateur
        ]);

        $_SESSION['flash'] = [
            'type' => 'success',
            'message' => "Le trajet a été mis à jour avec succès."
        ];

        header('Location: /');
        exit;
    }

    // 6. Réserver une place sur un trajet (Depuis la modale)
    public function reserve()
    {
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $id_trajet = $_GET['id'] ?? null;
        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        if ($id_trajet) {
            $db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');

            // Vérifier les places restantes
            $stmt = $db->prepare("SELECT places_disponibles FROM trajet WHERE id_trajet = :id_trajet");
            $stmt->execute(['id_trajet' => $id_trajet]);
            $trajet = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($trajet && $trajet['places_disponibles'] > 0) {
                try {
                    // Insérer dans la table associative reservation
                    $stmtRes = $db->prepare("INSERT INTO reservation (id_utilisateur, id_trajet) VALUES (:id_utilisateur, :id_trajet)");
                    $stmtRes->execute([
                        'id_utilisateur' => $id_utilisateur,
                        'id_trajet'      => $id_trajet
                    ]);

                    // Décrémentation du compteur
                    $stmtUpdate = $db->prepare("UPDATE trajet SET places_disponibles = places_disponibles - 1 WHERE id_trajet = :id_trajet");
                    $stmtUpdate->execute(['id_trajet' => $id_trajet]);

                    $_SESSION['flash'] = [
                        'type' => 'success',
                        'message' => "Votre place a été réservée avec succès ! Consultez l'onglet Mon Espace."
                    ];

                } catch (\PDOException $e) {
                    $_SESSION['flash'] = [
                        'type' => 'danger',
                        'message' => "Vous avez déjà une réservation enregistrée pour ce trajet !"
                    ];
                }
            }
        }

        header('Location: /');
        exit;
    }
}