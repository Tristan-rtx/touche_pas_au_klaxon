<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covoiturage CE - Accueil</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">🚗 Covoiturage CE</a>
            <div class="ms-auto">
                <?php if (isset($_SESSION['user'])): ?>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="/admin" class="btn btn-dark btn-sm fw-bold me-2 border-warning text-warning">⚙️ Tableau de bord Admin</a>
                    <?php else: ?>
                        <a href="/mon-espace" class="btn btn-outline-light btn-sm fw-bold me-2">📁 Mon Espace</a>
                    <?php endif; ?>
                    
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
        <?php if (isset($_SESSION['flash'])): ?>
            <div class="alert alert-<?= $_SESSION['flash']['type'] ?> alert-dismissible fade show shadow-sm border-0 fw-bold animate-fade-in" role="alert">
                <?= $_SESSION['flash']['type'] === 'success' ? '✅' : '⚠️' ?> <?= htmlspecialchars($_SESSION['flash']['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash']); ?>
        <?php endif; ?>

        <div class="row my-4">
            <div class="col">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-6 fw-bold text-secondary mb-0">Trajets disponibles</h1>
                    
                    <?php if (isset($_SESSION['user'])): ?>
                        <a href="/trajet/creer" class="btn btn-success fw-bold px-4 shadow-sm">➕ Proposer un trajet</a>
                    <?php endif; ?>
                </div>
                
                <div class="table-responsive shadow-sm rounded">
                    <table class="table table-striped table-hover align-middle mb-0 bg-white">
                        <thead class="table-primary">
                            <tr>
                                <th>Départ</th>
                                <th>Date / Heure de départ</th>
                                <th>Destination</th>
                                <th>Date / Heure d'arrivée</th>
                                <th class="text-center">Places disponibles</th>
                                <?php if (isset($_SESSION['user'])): ?>
                                    <th class="text-center">Actions</th>
                                <?php endif; ?>
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
                                        
                                        <?php if (isset($_SESSION['user'])): ?>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-1">
                                                    <button type="button" class="btn btn-info btn-sm text-white fw-bold" data-bs-toggle="modal" data-bs-target="#modalTrajet<?= $trajet['id_trajet'] ?>">
                                                        🔍 Détails
                                                    </button>

                                                    <?php if ($trajet['id_utilisateur'] == $_SESSION['user']['id_utilisateur']): ?>
                                                        <a href="/trajet/modifier?id=<?= $trajet['id_trajet'] ?>" class="btn btn-warning btn-sm fw-bold" title="Modifier">✏️</a>
                                                        <a href="/trajet/supprimer?id=<?= $trajet['id_trajet'] ?>" class="btn btn-danger btn-sm fw-bold" title="Supprimer" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce trajet ?')">🗑️</a>
                                                    <?php endif; ?>
                                                </div>

                                                <div class="modal fade" id="modalTrajet<?= $trajet['id_trajet'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $trajet['id_trajet'] ?>" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content text-start">
                                                            <div class="modal-header bg-primary text-white">
                                                                <h5 class="modal-title fw-bold" id="modalLabel<?= $trajet['id_trajet'] ?>">📞 Détails & Réservation</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
                                                            </div>
                                                            <div class="modal-body text-secondary">
                                                                <p class="mb-2"><strong>Conducteur :</strong> <?= htmlspecialchars($trajet['chauffeur_prenom']) ?> <?= htmlspecialchars($trajet['chauffeur_nom']) ?></p>
                                                                <p class="mb-2"><strong>Téléphone :</strong> <?= htmlspecialchars($trajet['chauffeur_telephone'] ?? 'Non renseigné') ?></p>
                                                                <p class="mb-2"><strong>Email :</strong> <a href="mailto:<?= $trajet['chauffeur_email'] ?>"><?= htmlspecialchars($trajet['chauffeur_email']) ?></a></p>
                                                                <hr>
                                                                <p class="mb-3 text-muted small">Nombre total de places initialement proposées : <?= $trajet['places_totales'] ?></p>

                                                                <div class="d-grid mt-3">
                                                                    <?php if ($trajet['id_utilisateur'] == $_SESSION['user']['id_utilisateur']): ?>
                                                                        <button class="btn btn-secondary fw-bold" disabled>🚘 Vous êtes le conducteur</button>
                                                                    <?php elseif ($trajet['places_disponibles'] <= 0): ?>
                                                                        <button class="btn btn-danger fw-bold" disabled>❌ Trajet complet</button>
                                                                    <?php else: ?>
                                                                        <a href="/trajet/reserver?id=<?= $trajet['id_trajet'] ?>" class="btn btn-success fw-bold py-2 shadow-sm">
                                                                            🎟️ Réserver une place sur ce trajet
                                                                        </a>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light fw-bold" data-bs-dismiss="modal">Fermer</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="<?= isset($_SESSION['user']) ? 6 : 5 ?>" class="text-center py-4 text-muted">Aucun trajet disponible pour le moment.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>