<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturage CE - Accueil</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <div class="container">
        <div class="row my-4">
            <div class="col">
                <h1 class="display-5 fw-bold text-primary mb-4">🚗 Covoiturage CE — Trajets disponibles</h1>
                
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