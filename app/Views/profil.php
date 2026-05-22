<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Espace - Covoiturage CE</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🚗 Covoiturage CE</a>
            <div class="ms-auto">
                <a href="/" class="btn btn-outline-light btn-sm fw-bold me-2">Accueil</a>
                <a href="/logout" class="btn btn-danger btn-sm fw-bold">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container text-secondary">
        <h1 class="display-5 fw-bold text-primary mb-4">Mon Espace Personnel</h1>
        <p class="lead mb-5">Retrouvez ici vos trajets proposés et vos réservations, <strong><?= htmlspecialchars($_SESSION['user']['prenom']) ?></strong>.</p>

        <div class="card shadow-sm border-0 mb-5 rounded-3">
            <div class="card-body p-4">
                <h3 class="fw-bold text-secondary mb-3">🚘 Les trajets que je propose (Conducteur)</h3>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Départ</th>
                                <th>Date / Heure</th>
                                <th>Destination</th>
                                <th>Places Restantes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mesConduites)): ?>
                                <?php foreach ($mesConduites as $t): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($t['agence_depart']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($t['gdh_depart'])) ?></td>
                                        <td class="fw-bold text-success"><?= htmlspecialchars($t['agence_arrivee']) ?></td>
                                        <td><span class="badge bg-primary rounded-pill"><?= $t['places_disponibles'] ?> / <?= $t['places_totales'] ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-muted py-3">Vous n'avez proposé aucun trajet pour le moment.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-4">
                <h3 class="fw-bold text-secondary mb-3">🎒 Mes réservations (Passager)</h3>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Départ</th>
                                <th>Date / Heure</th>
                                <th>Destination</th>
                                <th>Statut</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($mesVoyages)): ?>
                                <?php foreach ($mesVoyages as $t): ?>
                                    <tr>
                                        <td class="fw-bold"><?= htmlspecialchars($t['agence_depart']) ?></td>
                                        <td><?= date('d/m/Y H:i', strtotime($t['gdh_depart'])) ?></td>
                                        <td class="fw-bold text-success"><?= htmlspecialchars($t['agence_arrivee']) ?></td>
                                        <td><span class="badge bg-success">Place réservée</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="text-muted py-3">Vous n'avez réservé aucune place pour le moment.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>