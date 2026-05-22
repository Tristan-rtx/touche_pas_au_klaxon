<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Touche Pas Au Klaxon</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="/admin">⚙️ Tableau de Bord Admin</a>
            <div class="ms-auto">
                <a href="/" class="btn btn-outline-light btn-sm me-2">Voir le site public</a>
                <a href="/logout" class="btn btn-danger btn-sm fw-bold">Déconnexion</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show fw-bold" role="alert">
                <?= $_SESSION['flash']['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-3 mb-4">
                    <div class="card-body">
                        <h4 class="fw-bold text-secondary mb-3">➕ Ajouter une agence</h4>
                        <form action="/admin/agence/creer" method="POST">
                            <div class="mb-3">
                                <label for="nom_agence" class="form-label small fw-bold">Nom de la ville / agence</label>
                                <input type="text" class="form-control" id="nom_agence" name="nom_agence" required placeholder="Ex: Lyon">
                            </div>
                            <button type="submit" class="btn btn-dark w-100 fw-bold">Enregistrer l'agence</button>
                        </form>
                    </div>
                </div>

                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body">
                        <h4 class="fw-bold text-secondary mb-3">🏢 Liste des Agences</h4>
                        <ul class="list-group list-group-flush">
                            <?php foreach ($agences as $agence): ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="fw-bold text-secondary"><?= htmlspecialchars($agence['nom_agence']) ?></span>
                                    <div>
                                        <button class="btn btn-sm btn-outline-warning py-0 px-2" data-bs-toggle="modal" data-bs-target="#editAg<?= $agence['id_agence'] ?>">✏️</button>
                                        <a href="/admin/agence/supprimer?id=<?= $agence['id_agence'] ?>" class="btn btn-sm btn-outline-danger py-0 px-2" onclick="return confirm('Supprimer cette agence ?')">🗑️</a>
                                    </div>
                                </li>

                                <div class="modal fade" id="editAg<?= $agence['id_agence'] ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-sm">
                                        <form action="/admin/agence/modifier" method="POST" class="modal-content">
                                            <div class="modal-header bg-warning text-dark"><h6 class="modal-title fw-bold">Modifier l'agence</h6></div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id_agence" value="<?= $agence['id_agence'] ?>">
                                                <input type="text" class="form-control" name="nom_agence" value="<?= htmlspecialchars($agence['nom_agence']) ?>" required>
                                            </div>
                                            <div class="modal-content-footer p-2 text-end">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-sm btn-warning">Sauver</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <ul class="nav nav-pills mb-3 shadow-sm bg-white p-2 rounded-3" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active fw-bold" id="pills-trajets-tab" data-bs-toggle="pill" data-bs-target="#pills-trajets" type="button" role="tab">🚗 Tous les Trajets (<?= count($trajets) ?>)</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link fw-bold" id="pills-users-tab" data-bs-toggle="pill" data-bs-target="#pills-users" type="button" role="tab">👥 Liste des Employés (<?= count($utilisateurs) ?>)</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-trajets" role="tabpanel">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body p-0">
                                <table class="table table-striped align-middle mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Chauffeur</th>
                                            <th>Route</th>
                                            <th>Date départ</th>
                                            <th class="text-center">Places</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($trajets as $t): ?>
                                            <tr>
                                                <td class="small fw-bold"><?= htmlspecialchars($t['prenom']) ?> <?= htmlspecialchars($t['nom']) ?></td>
                                                <td class="small"><?= htmlspecialchars($t['agence_depart']) ?> ➔ <?= htmlspecialchars($t['agence_arrivee']) ?></td>
                                                <td class="small"><?= date('d/m H:i', strtotime($t['gdh_depart'])) ?></td>
                                                <td class="text-center small"><span class="badge bg-secondary"><?= $t['places_disponibles'] ?>/<?= $t['places_totales'] ?></span></td>
                                                <td class="text-center">
                                                    <a href="/admin/trajet/supprimer?id=<?= $t['id_trajet'] ?>" class="btn btn-sm btn-danger fw-bold" onclick="return confirm('L\'administrateur va supprimer définitivement ce trajet. Continuer ?')">🗑️ Retirer</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-users" role="tabpanel">
                        <div class="card shadow-sm border-0 rounded-3">
                            <div class="card-body p-0">
                                <table class="table table-striped align-middle mb-0">
                                    <thead class="table-secondary">
                                        <tr>
                                            <th>Nom / Prénom</th>
                                            <th>Email</th>
                                            <th>Téléphone</th>
                                            <th>Rôle</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($utilisateurs as $u): ?>
                                            <tr>
                                                <td class="fw-bold text-secondary"><?= htmlspecialchars($u['nom']) ?> <?= htmlspecialchars($u['prenom']) ?></td>
                                                <td><code><?= htmlspecialchars($u['email']) ?></code></td>
                                                <td><?= htmlspecialchars($u['telephone'] ?? 'N/A') ?></td>
                                                <td><span class="badge <?= $u['role'] === 'admin' ? 'bg-danger' : 'bg-primary' ?>"><?= strtoupper($u['role']) ?></span></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>