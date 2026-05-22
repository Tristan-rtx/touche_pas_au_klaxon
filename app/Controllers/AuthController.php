<?php

namespace App\Controllers;

use App\Models\UtilisateurModel;

class AuthController
{
    // 1. Afficher le formulaire
    public function showLogin()
    {
        if (isset($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
        require_once __DIR__ . '/../Views/login.php';
    }

    // 2. Traiter la soumission du formulaire
    public function login()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['mot_de_passe'] ?? '';

        $model = new UtilisateurModel();
        $user = $model->findByEmail($email);

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            unset($user['mot_de_passe']);
            $_SESSION['user'] = $user;
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = "Email ou mot de passe incorrect.";
            header('Location: /login');
            exit;
        }
    }

    // 3. Déconnexion de l'utilisateur
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['user']);
        session_destroy();
        
        header('Location: /');
        exit;
    }

    // 4. Afficher l'espace personnel de l'employé
    public function profil()
    {
        // Sécurité
        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $id_utilisateur = $_SESSION['user']['id_utilisateur'];

        // 1. Récupérer les trajets en tant que conducteur
        $trajetModel = new \App\Models\TrajetModel();
        $mesConduites = $trajetModel->getTrajetsConducteur($id_utilisateur);

        // 2. Récupérer les trajets en tant que passager
        $userModel = new \App\Models\UtilisateurModel();
        $mesVoyages = $userModel->getTrajetsPassager($id_utilisateur);

        require_once __DIR__ . '/../Views/profil.php';
    }
}