<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un trajet - Covoiturage CE</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🚗 Covoiturage CE</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="mb-4 text-warning fw-bold">✏️ Modifier le trajet</h2>
                        
                        <form action="/trajet/modifier" method="POST">
                            <input type="hidden" name="id_trajet" value="<?= $trajet['id_trajet'] ?>">

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="id_agence_depart" class="form-label fw-bold text-secondary">Agence de départ</label>
                                    <select class="form-select" id="id_agence_depart" name="id_agence_depart" required>
                                        <?php foreach ($agences as $agence): ?>
                                            <option value="<?= $agence['id_agence'] ?>" <?= $agence['id_agence'] == $trajet['id_agence_depart'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($agence['nom_agence']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="id_agence_arrivee" class="form-label fw-bold text-secondary">Agence d'arrivée</label>
                                    <select class="form-select" id="id_agence_arrivee" name="id_agence_arrivee" required>
                                        <?php foreach ($agences as $agence): ?>
                                            <option value="<?= $agence['id_agence'] ?>" <?= $agence['id_agence'] == $trajet['id_agence_arrivee'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($agence['nom_agence']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="gdh_depart" class="form-label fw-bold text-secondary">Date et heure de départ</label>
                                    <input type="datetime-local" class="form-control" id="gdh_depart" name="gdh_depart" value="<?= date('Y-m-d\TH:i', strtotime($trajet['gdh_depart'])) ?>" min="2026-01-01T00:00" max="2030-12-31T23:59" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="gdh_arrivee" class="form-label fw-bold text-secondary">Date et heure d'arrivée</label>
                                    <input type="datetime-local" class="form-control" id="gdh_arrivee" name="gdh_arrivee" value="<?= date('Y-m-d\TH:i', strtotime($trajet['gdh_arrivee'])) ?>" min="2026-01-01T00:00" max="2030-12-31T23:59" required>
                                </div>
                            </div>

                            <div class="mb-4 col-md-4">
                                <label for="places_totales" class="form-label fw-bold text-secondary">Nombre de places</label>
                                <input type="number" class="form-control" id="places_totales" name="places_totales" min="1" max="8" value="<?= $trajet['places_totales'] ?>" required>
                            </div>

                            <div class="d-flex justify-content-end gap-2">
                                <a href="/" class="btn btn-light fw-bold px-4">Annuler</a>
                                <button type="submit" class="btn btn-warning fw-bold px-4">Enregistrer les modifications</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>