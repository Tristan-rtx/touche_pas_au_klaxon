<?php

namespace App\Models;

use Buki\Router\Router; 

class UtilisateurModel
{
    private $db;

    public function __construct()
    {
        // On récupère la connexion PDO (on utilise la même logique que TrajetModel)
        
        $this->db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
    }

    // Trouver un utilisateur par son email
    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM utilisateur WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}