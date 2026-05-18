-- Création de la base de données
CREATE DATABASE IF NOT EXISTS covoiturage_ce CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE covoiturage_ce;

-- Création de la table AGENCE
CREATE TABLE IF NOT EXISTS agence (
    id_agence INT AUTO_INCREMENT PRIMARY KEY,
    nom_agence VARCHAR(255) NOT NULL
);

-- Création de la table UTILISATEUR
CREATE TABLE IF NOT EXISTS utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    prenom VARCHAR(255) NOT NULL,
    telephone VARCHAR(20) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    role ENUM('ROLE_USER', 'ROLE_ADMIN') DEFAULT 'ROLE_USER'
);

-- Création de la table TRAJET
CREATE TABLE IF NOT EXISTS trajet (
    id_trajet INT AUTO_INCREMENT PRIMARY KEY,
    gdh_depart DATETIME NOT NULL,
    gdh_arrivee DATETIME NOT NULL,
    places_totales INT NOT NULL,
    places_disponibles INT NOT NULL,
    id_utilisateur INT NOT NULL,
    id_agence_depart INT NOT NULL,
    id_agence_arrivee INT NOT NULL,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    FOREIGN KEY (id_agence_depart) REFERENCES agence(id_agence) ON DELETE CASCADE,
    FOREIGN KEY (id_agence_arrivee) REFERENCES agence(id_agence) ON DELETE CASCADE
);