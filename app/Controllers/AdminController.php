<?php

namespace App\Controllers;

use PDO;

class AdminController
{
    private $db;

    public function __construct()
    {
        // On s'assure que la session est active
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // INITIALISATION DE LA CONNEXION (Crucial pour éviter le bug "on null")
        $this->db = new PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
    }

    // 1. Page principale du Tableau de bord (Listes)
    public function dashboard()
    {
        // A. Lister les utilisateurs
        $stmtUser = $this->db->query("SELECT * FROM utilisateur ORDER BY nom ASC");
        $utilisateurs = $stmtUser->fetchAll(PDO::FETCH_ASSOC);

        // B. Lister les agences
        $stmtAgence = $this->db->query("SELECT * FROM agence ORDER BY nom_agence ASC");
        $agences = $stmtAgence->fetchAll(PDO::FETCH_ASSOC);

        // C. Lister les trajets
        $sqlTrajets = "SELECT t.*, u.nom, u.prenom, ad.nom_agence AS agence_depart, aa.nom_agence AS agence_arrivee 
                       FROM trajet t
                       JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
                       JOIN agence ad ON t.id_agence_depart = ad.id_agence
                       JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                       ORDER BY t.gdh_depart DESC";
        $stmtTrajet = $this->db->query($sqlTrajets);
        $trajets = $stmtTrajet->fetchAll(PDO::FETCH_ASSOC);

        require_once __DIR__ . '/../Views/admin/dashboard.php';
    }
    
    // ... (garde le reste des méthodes comme storeAgence, deleteAgence en dessous)

    // 2. Créer une agence
    public function storeAgence()
    {
        $nom_agence = $_POST['nom_agence'] ?? null;
        if (!empty($nom_agence)) {
            $stmt = $this->db->prepare("INSERT INTO agence (nom_agence) VALUES (:nom_agence)");
            $stmt->execute(['nom_agence' => $nom_agence]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => "Agence ajoutée avec succès !"];
        }
        header('Location: /admin');
        exit;
    }

    // 3. Modifier une agence (POST)
    public function updateAgence()
    {
        $id_agence = $_POST['id_agence'] ?? null;
        $nom_agence = $_POST['nom_agence'] ?? null;
        if ($id_agence && !empty($nom_agence)) {
            $stmt = $this->db->prepare("UPDATE agence SET nom_agence = :nom_agence WHERE id_agence = :id_agence");
            $stmt->execute(['nom_agence' => $nom_agence, 'id_agence' => $id_agence]);
            $_SESSION['flash'] = ['type' => 'success', 'message' => "Agence modifiée avec succès !"];
        }
        header('Location: /admin');
        exit;
    }

    // 4. Supprimer une agence
    public function deleteAgence()
    {
        $id_agence = $_GET['id'] ?? null;
        if ($id_agence) {
            try {
                $stmt = $this->db->prepare("DELETE FROM agence WHERE id_agence = :id_agence");
                $stmt->execute(['id_agence' => $id_agence]);
                $_SESSION['flash'] = ['type' => 'success', 'message' => "Agence supprimée avec succès !"];
            } catch (\PDOException $e) {
                $_SESSION['flash'] = ['type' => 'danger', 'message' => "Impossible de supprimer cette agence : elle est liée à des trajets existants."];
            }
        }
        header('Location: /admin');
        exit;
    }

    // 5. Supprimer n'importe quel trajet (Pouvoir Admin)
    public function deleteTrajet()
    {
        $id_trajet = $_GET['id'] ?? null;
        if ($id_trajet) {
            // Nettoyage des réservations d'abord
            $stmtRes = $this->db->prepare("DELETE FROM reservation WHERE id_trajet = :id_trajet");
            $stmtRes->execute(['id_trajet' => $id_trajet]);

            // Suppression du trajet
            $stmtTrajet = $this->db->prepare("DELETE FROM trajet WHERE id_trajet = :id_trajet");
            $stmtTrajet->execute(['id_trajet' => $id_trajet]);

            $_SESSION['flash'] = ['type' => 'success', 'message' => "Le trajet a été supprimé par l'administrateur."];
        }
        header('Location: /admin');
        exit;
    }
}