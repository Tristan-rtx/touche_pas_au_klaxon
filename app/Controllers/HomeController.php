<?php

namespace App\Controllers;

use App\Models\TrajetModel;

class HomeController
{
    public function index()
    {
        $trajetModel = new TrajetModel();
        $trajets = $trajetModel->getTrajetsDisponibles();

        require_once __DIR__ . '/../Views/home.php';
    }
}