Touche pas au klaxon - Covoiturage CE

Bienvenue sur le dépôt du projet Touche pas au klaxon. Il s'agit d'un annuaire web Full-Stack développé pour répertorier et rechercher facilement des trajets de covoiturage entre collaborateurs au sein du Comité d'Entreprise.

📋 Description du projet

Ce projet a été réalisé dans le cadre d'une évaluation. L'objectif est de proposer une plateforme numérique centralisée où les utilisateurs peuvent :

- Découvrir les trajets disponibles en temps réel sur la plateforme.
- Rechercher un trajet par agence de départ, ville ou agence d'arrivée en temps réel.
- Réserver une place sur un trajet avec un décompte automatique des places disponibles.
- Consulter une fiche détaillée pour chaque trajet (conducteur, description, places restantes) et contacter le conducteur via une modale affichant ses coordonnées.
- Accéder à un espace d'administration (Dashboard) pour gérer les agences (CRUD), modérer les trajets et lister le personnel RH.

💻 Technologies utilisées

- Front-end : HTML5, Bootstrap 5, CSS personnalisé (intégré via l'architecture MVC)
- Back-end : PHP natif (Architecture MVC), izniburak/router (Gestion du routage)
- Base de données : MySQL (Interrogé via des requêtes préparées PDO)

📁 Structure du dépôt

Le projet est structuré selon l'architecture MVC classique adaptée à PHP :

- sql/ : Scripts SQL pour la création de l'architecture de la base de données (creation.sql) et l'insertion des données de test (alimentation.sql).
- app/ : Code source de l'application contenant la logique métier (Modèles et Contrôleurs comme `AuthController.php`, `AdminController.php`) ainsi que l'interface utilisateur graphique (Vues HTML/Bootstrap).
- public/ : Point d'entrée unique de l'application contenant le fichier d'aiguillage principal `index.php` (le routeur global) et les feuilles de style CSS.

🚀 Installation et exécution en local

Pour faire tourner ce projet sur votre machine, suivez ces étapes dans l'ordre :

1. Base de données

Importez et exécutez le script sql/creation.sql dans votre SGBD (ex: phpMyAdmin, MySQL Workbench) pour créer la structure de la base `covoiturage_ce`.

Exécutez ensuite sql/alimentation.sql pour y insérer le jeu de données initial (employés, agences et trajets).

2. Back-end (Dépendances)

Ouvrez un terminal à la racine du projet.

Installez le gestionnaire de routage et les dépendances avec la commande :

composer install


Configurez vos accès de base de données directement dans vos contrôleurs PHP (`mysql:host=127.0.0.1;dbname=covoiturage_ce`, utilisateur: `root`, mot de passe: ` `).

3. Front-end / Serveur (Application Web)

Ouvrez votre terminal à la racine du projet.

Lancez le serveur embarqué de PHP avec la commande :

php -S localhost:8000 -t public


Ouvrez l'URL locale fournie dans votre navigateur web : `http://localhost:8000` (ou directement sur la page de connexion : `http://localhost:8000/login`).

🧪 Identifiants de test pour l'évaluation

- Profil Employé Standard :
  - Email : `alexandre.martin@email.fr`
  - Mot de passe : `password`

- Profil Administrateur :
  - Email : `admin` (ou `admin@entreprise.fr`)
  - Mot de passe : `adminpass`