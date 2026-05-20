<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturage CE - Accueil</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
<div class="container">
            <a class="navbar-brand fw-bold" href="/">🚗 Covoiturage CE</a>
            <div class="ms-auto">
                <?php if (isset($_SESSION['user'])): ?>
                    <span class="navbar-text text-white fw-bold me-3">
                        👋 Bonjour <?= htmlspecialchars($_SESSION['user']['prenom']) ?> !
                    </span>
                    <a href="/logout" class="btn btn-danger btn-sm fw-bold px-3">Déconnexion</a>
                <?php else: ?>
                    <a href="/login" class="btn btn-outline-light fw-bold px-4">Espace Employé</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row my-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-6 fw-bold text-secondary mb-0">Trajets disponibles</h1>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/trajet/creer" class="btn btn-success fw-bold px-4 shadow-sm">➕ Proposer un trajet</a>
                    <?php endif; ?>
                </div>
                
                <div class="table-responsive shadow-sm rounded">
                    ```

---

### Étape 2 : Ajouter la fonction de Déconnexion dans `AuthController`

Si l'employé veut se déconnecter, il faut pouvoir détruire la session. Ouvre ton fichier **`app/Controllers/AuthController.php`** et ajoute cette méthode à la fin de la classe :

```php
// 3. Déconnexion de l'utilisateur
public function logout()
{
    session_start(); // Au cas où
    unset($_SESSION['user']); // On supprime l'utilisateur de la session
    session_destroy(); // On détruit la session
    
    header('Location: /'); // Retour à l'accueil
    exit;
}

    <div class="container">
        <div class="row my-4">
            <div class="col">
                <h1 class="display-6 fw-bold text-secondary mb-4">Trajets disponibles</h1>
                
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Départ</th>
                                <th>Date / Heure de départ</th>
                                <th>Destination</th>
                                <th>Date / Heure d'arrivée</th>
                                <th class="text-center">Places disponibles</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($trajets)): ?>
                                <?php foreach ($trajets as $trajet): ?>
                                    <tr>
                                        <td class="fw-bold text-secondary"><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($trajet['gdh_depart'])) ?></td>
                                        <td class="fw-bold text-success"><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($trajet['gdh_arrivee'])) ?></td>
                                        <td class="text-center">
                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                <?= htmlspecialchars($trajet['places_disponibles']) ?> / <?= htmlspecialchars($trajet['places_totales']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">Aucun trajet disponible pour le moment.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>