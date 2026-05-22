<?php

namespace App\Models;

use PDO;

class TrajetModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

        public function getTrajetsDisponibles()
            {
                $sql = "SELECT t.*,
                            ad.nom_agence AS agence_depart, 
                            aa.nom_agence AS agence_arrivee,
                            u.nom AS chauffeur_nom,
                            u.prenom AS chauffeur_prenom,
                            u.email AS chauffeur_email,
                            u.telephone AS chauffeur_telephone
                        FROM trajet t
                        JOIN agence ad ON t.id_agence_depart = ad.id_agence
                        JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                        JOIN utilisateur u ON t.id_utilisateur = u.id_utilisateur
                        WHERE t.places_disponibles > 0 
                        AND t.gdh_depart > NOW()
                        ORDER BY t.gdh_depart ASC";
                
                $stmt = $this->db->query($sql);
                return $stmt->fetchAll();
            }

            public function getTrajetsConducteur($id_utilisateur)
        {
            $sql = "SELECT t.*, 
                        ad.nom_agence AS agence_depart, 
                        aa.nom_agence AS agence_arrivee
                    FROM trajet t
                    JOIN agence ad ON t.id_agence_depart = ad.id_agence
                    JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                    WHERE t.id_utilisateur = :id_utilisateur
                    ORDER BY t.gdh_depart DESC";
                    
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id_utilisateur' => $id_utilisateur]);
            return $stmt->fetchAll();
        }
}