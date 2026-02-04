<?php
session_start();

// Composer autoload (bibliothèques externes)
$composerAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
} else {
    error_log('Attention: vendor/autoload.php introuvable. Les bibliothèques Composer ne sont pas chargées.');
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

// Si l'utilisateur est connecté et qu'on est sur l'index, rediriger vers le dashboard
if (isset($_SESSION['user_id']) && empty($_GET['action'])) {
    header('Location: dashboard.php');
    exit;
}

// Gestion des actions
$action = $_GET['action'] ?? 'accueil';

switch ($action) {
    case 'connexion':
        if (!isset($_SESSION['user_id'])) {
            require_once 'controllers/AuthController.php';
            $controller = new AuthController();
            $controller->connexion();
        } else {
            header('Location: dashboard.php');
        }
        exit;
        
    case 'inscription':
        if (!isset($_SESSION['user_id'])) {
            require_once 'controllers/AuthController.php';
            $controller = new AuthController();
            $controller->inscription();
        } else {
            header('Location: dashboard.php');
        }
        exit;
        
    case 'deconnexion':
        session_destroy();
        header('Location: index.php');
        exit;
        
    case 'accueil':
    default:
        // Si l'utilisateur est connecté, rediriger vers le dashboard
        if (isset($_SESSION['user_id'])) {
            header('Location: dashboard.php');
            exit;
        }
        // Sinon afficher la page d'accueil
        include 'views/accueil.php';
        break;
}
?>