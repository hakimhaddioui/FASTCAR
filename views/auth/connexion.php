<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - FastCar Location</title>
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
            max-width: 400px;
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
            <!-- Compte de test -->
            <div class="mt-4 p-3 bg-light rounded">
                <small class="text-muted">Compte de test :</small><br>
                <small><strong>Email:</strong> admin@fastcar.ma</small><br>
                <small><strong>Mot de passe:</strong> password</small>
            </div>
            <div class="auth-logo">
                <h3 class="text-primary">
                    <i class="bx bx-car"></i> FastCar Location
                </h3>
                <p class="text-muted">Connectez-vous à votre compte</p>
            </div>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errors as $error): ?>
                        <div><?= htmlspecialchars($error) ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                
                <button type="submit" class="btn btn-primary-custom btn-lg">
                    <i class="bx bx-log-in"></i> Se connecter
                </button>
            </form>

            <div class="text-center mt-3">
                <p class="mb-0">
                    Pas de compte ? 
                    <a href="index.php?action=inscription" class="text-decoration-none">S'inscrire</a>
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