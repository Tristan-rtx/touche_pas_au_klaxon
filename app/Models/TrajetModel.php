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
        $sql = "SELECT t.id_trajet, t.gdh_depart, t.gdh_arrivee, t.places_disponibles, t.places_totales,
                       ad.nom_agence AS agence_depart, 
                       aa.nom_agence AS agence_arrivee
                FROM trajet t
                JOIN agence ad ON t.id_agence_depart = ad.id_agence
                JOIN agence aa ON t.id_agence_arrivee = aa.id_agence
                WHERE t.places_disponibles > 0 
                  AND t.gdh_depart > NOW()
                ORDER BY t.gdh_depart ASC";
        
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
}