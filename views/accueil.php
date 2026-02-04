<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FastCar Location - Location de Voitures à Marrakech</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #1e3c72, #2a5298);
            color: white;
            padding: 100px 0;
            text-align: center;
        }
        .features-section {
            padding: 80px 0;
            background: #f8f9fa;
        }
        .feature-card {
            text-align: center;
            padding: 30px;
            border-radius: 10px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .feature-icon {
            font-size: 3rem;
            color: #1e3c72;
            margin-bottom: 20px;
        }
        .btn-primary-custom {
            background: #1e3c72;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
        }
        .btn-primary-custom:hover {
            background: #2a5298;
        }
        .navbar-custom {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="index.php">
                <i class="bx bx-car"></i> FastCar Location
            </a>
        </div>
    </nav>

    <!-- Section Hero -->
    <section class="hero-section">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">FastCar Location Marrakech</h1>
            <p class="lead mb-4">Votre partenaire de confiance pour la location de voitures à Marrakech et dans tout le Maroc</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="index.php?action=inscription" class="btn btn-light btn-lg w-100">
                                <i class="bx bx-user-plus"></i> Créer un compte
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="index.php?action=connexion" class="btn btn-outline-light btn-lg w-100">
                                <i class="bx bx-log-in"></i> Se connecter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Section Features -->
    <section class="features-section">
        <div class="container">
            <h2 class="text-center mb-5">Pourquoi choisir FastCar Location ?</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bx bx-car feature-icon"></i>
                        <h4>Large Choix de Véhicules</h4>
                        <p>Des voitures économiques aux véhicules premium, nous avons la voiture parfaite pour vos besoins.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bx bx-shield feature-icon"></i>
                        <h4>Assurance Complète</h4>
                        <p>Tous nos véhicules sont entièrement assurés pour votre tranquillité d'esprit.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="bx bx-support feature-icon"></i>
                        <h4>Support 24/7</h4>
                        <p>Notre équipe est disponible 24h/24 et 7j/7 pour vous assister en cas de besoin.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>FastCar Location</h5>
                    <p>Votre partenaire de mobilité à Marrakech</p>
                </div>
                <div class="col-md-4">
                    <h5>Contact</h5>
                    <p><i class="bx bx-phone"></i> 05 22 33 44 55</p>
                    <p><i class="bx bx-envelope"></i> contact@fastcar.ma</p>
                </div>
                <div class="col-md-4">
                    <h5>Adresse</h5>
                    <p>Bd Mohammed V, Marrakech</p>
                    <p>Ouvert 7j/7 de 8h à 20h</p>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; 2024 FastCar Location. Tous droits réservés.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>