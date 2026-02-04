<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - FastCar Location</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .auth-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            padding: 40px;
            width: 100%;
            max-width: 450px;
        }
        .auth-logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .btn-primary-custom {
            background: #1e3c72;
            border: none;
            padding: 12px;
            width: 100%;
        }
        .btn-primary-custom:hover {
            background: #2a5298;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-logo">
                <h3 class="text-primary">
                    <i class="bx bx-car"></i> FastCar Location
                </h3>
                <p class="text-muted">Créez votre compte</p>
            </div>

            <?php if ($success ?? false): ?>
                <div class="alert alert-success">
                    <strong>Inscription réussie !</strong><br>
                    Vous pouvez maintenant vous <a href="index.php?action=connexion">connecter</a>.
                </div>
            <?php else: ?>
                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger">
                        <?php foreach ($errors as $error): ?>
                            <div><?= htmlspecialchars($error) ?></div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nom</label>
                                <input type="text" name="nom" class="form-control" 
                                       value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Prénom</label>
                                <input type="text" name="prenom" class="form-control" 
                                       value="<?= htmlspecialchars($_POST['prenom'] ?? '') ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                        <small class="text-muted">Minimum 6 caractères</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Confirmer le mot de passe</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary-custom btn-lg">
                        <i class="bx bx-user-plus"></i> S'inscrire
                    </button>
                </form>
            <?php endif; ?>

            <div class="text-center mt-3">
                <p class="mb-0">
                    Déjà un compte ? 
                    <a href="index.php?action=connexion" class="text-decoration-none">Se connecter</a>
                </p>
                <a href="index.php" class="text-decoration-none">
                    <i class="bx bx-arrow-back"></i> Retour à l'accueil
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>