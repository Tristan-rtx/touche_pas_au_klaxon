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
    public function getTrajetsPassager($id_utilisateur)
    {
        // On se connecte à la BDD 
        $db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
        
        $sql = "SELECT t.*, 
                    ad.nom_agence AS agence_depart, 
                    aa.nom_agence AS agence_arrivee
                FROM reservation r
                JOIN trajet t ON r.id_trajet = t.id_trajet
                JOIN agence ad ON t.id_agence_depart = ad.id_agence
                JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                WHERE r.id_utilisateur = :id_utilisateur
                ORDER BY t.gdh_depart DESC";
                
        $stmt = $db->prepare($sql);
        $stmt->execute(['id_utilisateur' => $id_utilisateur]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}