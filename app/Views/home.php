<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Covoiturage CE - Accueil</title>
</head>
<body>
    <h1>Trajets proposés</h1>
    
    <table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Départ</th>
                <th>Date / Heure</th>
                <th>Destination</th>
                <th>Date / Heure</th>
                <th>Places</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($trajets)): ?>
                <?php foreach ($trajets as $trajet): ?>
                    <tr>
                        <td><?= htmlspecialchars($trajet['agence_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['gdh_depart']) ?></td>
                        <td><?= htmlspecialchars($trajet['agence_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['gdh_arrivee']) ?></td>
                        <td><?= htmlspecialchars($trajet['places_disponibles']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Aucun trajet disponible pour le moment.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>