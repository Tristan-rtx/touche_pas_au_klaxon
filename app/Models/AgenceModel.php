<?php

namespace App\Models;

class AgenceModel
{
    private $db;

    public function __construct()
    {
        $this->db = new \PDO('mysql:host=127.0.0.1;dbname=covoiturage_ce;charset=utf8', 'root', '');
    }

    // Récupérer toutes les agences pour le formulaire
    public function getAllAgences()
    {
        $stmt = $this->db->query("SELECT * FROM agence ORDER BY nom_agence ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}