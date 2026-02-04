<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FASTCAR LOCATION - Gestion Centrale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        /* Variables CSS pour les couleurs */
        :root {
            --primary-color: #1e3c72;
            --primary-light: #2a5298;
        }

        /* Styles de base */
        .sidebar {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: white;
            min-height: 100vh;
            box-shadow: 3px 0 10px rgba(0,0,0,0.1);
            position: fixed;
            width: 250px;
            z-index: 1000;
        }
        .main-content {
            margin-left: 250px;
            width: calc(100% - 250px);
            min-height: 100vh;
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            margin: 5px 0;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover {
            background: rgba(255,255,255,0.1);
            color: white;
            transform: translateX(5px);
        }
        .sidebar .nav-link.active {
            background: rgba(255,255,255,0.2);
            color: white;
            font-weight: 600;
        }
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 999;
        }
        .content {
            background: #f8f9fa;
            min-height: calc(100vh - 80px);
            padding: 30px;
        }
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .user-info {
            background: rgba(255,255,255,0.1);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        /* Styles pour les boutons primaires */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background: var(--primary-light);
            border-color: var(--primary-light);
        }

        /* Styles responsives */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                min-height: auto;
            }
            .main-content {
                margin-left: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-lg-2 sidebar p-0">
                <div class="p-4">
                    <h4 class="text-center mb-4">
                        <i class="bx bx-car"></i>
                        FASTCAR
                    </h4>
                    
                    <nav class="nav flex-column">
                        <a class="nav-link <?= $currentPage === 'analytics' ? 'active' : '' ?>" 
                           href="dashboard.php?action=analytics">
                            <i class="bx bx-line-chart me-2"></i>Dashboard
                        </a>
                        <a class="nav-link <?= $currentPage === 'voitures' ? 'active' : '' ?>" 
                           href="dashboard.php?action=voitures">
                            <i class="bx bx-car me-2"></i>Gérer les Voitures
                        </a>
                        <a class="nav-link <?= $currentPage === 'clients' ? 'active' : '' ?>" 
                           href="dashboard.php?action=clients">
                            <i class="bx bx-user me-2"></i>Gérer les Clients
                        </a>
                        <a class="nav-link <?= $currentPage === 'agents' ? 'active' : '' ?>" 
                           href="dashboard.php?action=agents">
                            <i class="bx bx-id-card me-2"></i>Gérer les Agents
                        </a>
                        <a class="nav-link <?= $currentPage === 'contrats' ? 'active' : '' ?>" 
                           href="dashboard.php?action=contrats">
                            <i class="bx bx-file me-2"></i>Gérer les Contrats
                        </a>
                        <a class="nav-link <?= $currentPage === 'factures' ? 'active' : '' ?>" 
                           href="dashboard.php?action=factures">
                            <i class="bx bx-printer me-2"></i>Factures
                        </a>
                        <a class="nav-link <?= $currentPage === 'search' ? 'active' : '' ?>" 
                           href="dashboard.php?action=search">
                            <i class="bx bx-search me-2"></i>Recherche
                        </a>
                        <a class="nav-link <?= $currentPage === 'parametres' ? 'active' : '' ?>" 
                           href="dashboard.php?action=parametres">
                            <i class="bx bx-cog me-2"></i>Paramètres
                        </a>
                        <a class="nav-link text-danger" href="dashboard.php?action=deconnexion">
                            <i class="bx bx-log-out me-2"></i>Déconnexion
                        </a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-10 main-content p-0">
                <!-- Header -->
                <div class="header">
                    <div class="container-fluid">
                        <h2 class="mb-0 px-4">FASTCAR LOCATION - Gestion Centrale</h2>
                    </div>
                </div>

                <!-- Content -->
                <div class="content">
                    <?php if (isset($_GET['message'])): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php
                            $messages = [
                                'success' => 'Opération effectuée avec succès!',
                                'updated' => 'Modification enregistrée!',
                                'deleted' => 'Suppression effectuée!'
                            ];
                            echo $messages[$_GET['message']] ?? 'Opération réussie!';
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($_GET['error'])): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?php
                            $errors = [
                                'not_found' => 'Élément non trouvé!',
                                'delete_failed' => 'Erreur lors de la suppression!',
                                'email_exists' => 'Cet email est déjà utilisé!',
                                'password_mismatch' => 'Les mots de passe ne correspondent pas!',
                                'invalid_password' => 'Mot de passe actuel incorrect!',
                                'pdf_failed' => 'Impossible de générer le PDF. Veuillez réessayer.'
                            ];
                            echo $errors[$_GET['error']] ?? 'Une erreur est survenue!';
                            ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- CONTENU PRINCIPAL DE L'APPLICATION -->
                    <?php echo $content; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion des alertes auto-dismiss
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });

        // Amélioration de l'UX pour les formulaires
        const forms = document.querySelectorAll('form');
        forms.forEach(form => {
            form.addEventListener('submit', function() {
                const submitBtn = this.querySelector('button[type="submit"]');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="bx bx-loader bx-spin me-1"></i>Chargement...';
                }
            });
        });

        // Gestion du responsive
        function handleResize() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (window.innerWidth <= 768) {
                sidebar.style.position = 'relative';
                sidebar.style.width = '100%';
                mainContent.style.marginLeft = '0';
                mainContent.style.width = '100%';
            } else {
                sidebar.style.position = 'fixed';
                sidebar.style.width = '250px';
                mainContent.style.marginLeft = '250px';
                mainContent.style.width = 'calc(100% - 250px)';
            }
        }

        // Écouter le redimensionnement
        window.addEventListener('resize', handleResize);
        
        // Initialiser
        handleResize();
    });
    </script>
</body>
</html>