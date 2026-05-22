<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Covoiturage CE</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-5">
        <div class="container">
            <a class="navbar-brand" href="/">🚗 Covoiturage CE</a>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-4">
                        <h2 class="text-center mb-4 text-primary fw-bold">Espace Employé</h2>
                        
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger fw-bold border-0 shadow-sm small mb-3" role="alert">
                                ⚠️ <?= htmlspecialchars($_SESSION['error']) ?>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>
                        
                        <form action="/login" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label text-secondary fw-bold">Adresse Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="employe@entreprise.com" required>
                            </div>
                            <div class="mb-4">
                                <label for="mot_de_passe" class="form-label text-secondary fw-bold">Mot de passe</label>
                                <input type="password" class="form-control" id="mot_de_passe" name="password" placeholder="••••••••" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Se connecter</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>