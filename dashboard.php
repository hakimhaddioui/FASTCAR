<?php
session_start();

// Composer autoload (bibliothèques externes)
$composerAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    error_log('Attention: vendor/autoload.php introuvable. Les bibliothèques Composer ne sont pas chargées.');
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?action=connexion');
    exit;
}

// Autoload simple
spl_autoload_register(function($class) {
    $paths = [
        'controllers/',
        'models/repositories/',
        'models/entities/',
        'models/services/'
    ];
    
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Configuration de la base de données
require_once 'config/database.php';

// Gestion des routes
$action = $_GET['action'] ?? 'analytics';
$currentPage = $action;

try {
    switch ($action) {
        // Analytics / Analyse
        case 'analytics':
            require_once 'controllers/AnalyticsController.php';
            $controller = new AnalyticsController();
            $content = $controller->index();
            break;
        case 'analytics_json':
            require_once 'controllers/AnalyticsController.php';
            $controller = new AnalyticsController();
            $controller->getStatsJSON();
            exit;
        case 'analytics_export_pdf':
            require_once 'controllers/AnalyticsController.php';
            $controller = new AnalyticsController();
            $controller->exportPDF();
            exit;

        // Gestion des voitures
        case 'voitures':
            $controller = new VoitureController();
            $content = $controller->index();
            break;
        case 'voitures_create':
            $controller = new VoitureController();
            $content = $controller->create();
            break;
        case 'voitures_edit':
            $controller = new VoitureController();
            $content = $controller->edit($_GET['matricule'] ?? '');
            break;
        case 'voitures_delete':
            $controller = new VoitureController();
            $controller->delete($_GET['matricule'] ?? '');
            exit;
            
        // Gestion des clients
        case 'clients':
            $controller = new ClientController();
            $content = $controller->index();
            break;
        case 'clients_create':
            $controller = new ClientController();
            $content = $controller->create();
            break;
        case 'clients_edit':
            $controller = new ClientController();
            $content = $controller->edit($_GET['cin'] ?? '');
            break;
        case 'clients_delete':
            $controller = new ClientController();
            $controller->delete($_GET['cin'] ?? '');
            exit;
            
        // Gestion des agents
        case 'agents':
            $controller = new AgentController();
            $content = $controller->index();
            break;
        case 'agents_create':
            $controller = new AgentController();
            $content = $controller->create();
            break;
        case 'agents_edit':
            $controller = new AgentController();
            $content = $controller->edit($_GET['num_agent'] ?? '');
            break;
        case 'agents_delete':
            $controller = new AgentController();
            $controller->delete($_GET['num_agent'] ?? '');
            exit;
            
        // Gestion des contrats
        case 'contrats':
            $controller = new ContratController();
            $content = $controller->index();
            break;
        case 'contrats_create':
            $controller = new ContratController();
            $content = $controller->create();
            break;
        case 'contrats_show':
            $controller = new ContratController();
            $content = $controller->show($_GET['num_contrat'] ?? '');
            break;
        case 'contrats_edit':
            $controller = new ContratController();
            $content = $controller->edit($_GET['num_contrat'] ?? '');
            break;
        case 'contrats_delete':
            $controller = new ContratController();
            $controller->delete($_GET['num_contrat'] ?? '');
            exit;
            
        // Gestion des factures
        case 'factures':
            $controller = new FactureController();
            $content = $controller->index();
            break;
        case 'factures_generate':
            $controller = new FactureController();
            $controller->generate($_GET['num_contrat'] ?? '');
            exit;
        case 'factures_download':
            $controller = new FactureController();
            $controller->download($_GET['num_contrat'] ?? '');
            exit;
            
        // Recherche
        case 'search':
            require_once 'controllers/SearchController.php';
            $controller = new SearchController();
            $content = $controller->search();
            break;
            
        // Paramètres
        case 'parametres':
            require_once 'controllers/ParametresController.php';
            $controller = new ParametresController();
            $content = $controller->index();
            break;
        case 'parametres_update_profil':
            require_once 'controllers/ParametresController.php';
            $controller = new ParametresController();
            $controller->updateProfil();
            break;
        case 'parametres_update_password':
            require_once 'controllers/ParametresController.php';
            $controller = new ParametresController();
            $controller->updatePassword();
            break;
        case 'parametres_update_entreprise':
            require_once 'controllers/ParametresController.php';
            $controller = new ParametresController();
            $controller->updateEntreprise();
            break;
            
        // Déconnexion
        case 'deconnexion':
            session_destroy();
            header('Location: index.php');
            exit;
            
        default:
            // Si l'action n'est pas reconnue, afficher les voitures
            $controller = new VoitureController();
            $content = $controller->index();
            break;
    }
    
} catch (Exception $e) {
    // En cas d'erreur, afficher un message et rediriger vers les voitures
    error_log("Erreur dans le dashboard: " . $e->getMessage());
    $content = "<div class='alert alert-danger'>Erreur : " . htmlspecialchars($e->getMessage()) . "</div>";
}

// Inclure le layout principal du dashboard
require 'views/layouts/main.php';
?>