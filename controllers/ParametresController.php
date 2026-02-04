<?php
require_once 'models/repositories/UserRepository.php';

class ParametresController {
    private $userRepo;
    
    public function __construct() {
        $this->userRepo = new UserRepository();
    }
    
    public function index() {
        $user = $this->userRepo->findById($_SESSION['user_id']);
        $success = $_GET['success'] ?? false;
        $errors = [];
        
        // Informations de l'entreprise (simulées, vous pouvez les stocker en base)
        $entrepriseInfo = [
            'nom' => 'FastCar Location',
            'adresse' => 'Bd Mohammed V, Marrakech',
            'telephone' => '05 22 33 44 55',
            'email' => 'contact@fastcar.ma',
            'rc' => '123456',
            'patente' => '78901234',
            'if' => '98765432'
        ];
        
        ob_start();
        include 'views/parametres/index.php';
        return ob_get_clean();
    }
    
    public function updateProfil() {
        $user = $this->userRepo->findById($_SESSION['user_id']);
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            
            // Validation
            if (empty($nom)) $errors[] = "Le nom est obligatoire";
            if (empty($prenom)) $errors[] = "Le prénom est obligatoire";
            if (empty($email)) $errors[] = "L'email est obligatoire";
            
            // Vérifier si l'email existe déjà pour un autre utilisateur
            if (empty($errors)) {
                $existingUser = $this->userRepo->findByEmail($email);
                if ($existingUser && $existingUser->id != $user->id) {
                    $errors[] = "Cet email est déjà utilisé par un autre utilisateur";
                }
            }
            
            if (empty($errors)) {
                // Mettre à jour l'utilisateur
                $user->nom = $nom;
                $user->prenom = $prenom;
                $user->email = $email;
                
                // Ici vous devriez avoir une méthode update dans UserRepository
                // Pour l'instant, on simule la mise à jour
                $_SESSION['user_nom'] = $nom;
                $_SESSION['user_prenom'] = $prenom;
                $_SESSION['user_email'] = $email;
                
                header('Location: dashboard.php?action=parametres&success=profil');
                exit;
            }
        }
        
        ob_start();
        include 'views/parametres/index.php';
        return ob_get_clean();
    }
    
    public function updatePassword() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $current_password = $_POST['current_password'] ?? '';
            $new_password = $_POST['new_password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($current_password)) $errors[] = "Le mot de passe actuel est obligatoire";
            if (empty($new_password)) $errors[] = "Le nouveau mot de passe est obligatoire";
            if ($new_password !== $confirm_password) $errors[] = "Les nouveaux mots de passe ne correspondent pas";
            if (strlen($new_password) < 6) $errors[] = "Le nouveau mot de passe doit contenir au moins 6 caractères";
            
            if (empty($errors)) {
                $user = $this->userRepo->findById($_SESSION['user_id']);
                
                // Vérifier le mot de passe actuel
                if (!password_verify($current_password, $user->password)) {
                    $errors[] = "Le mot de passe actuel est incorrect";
                } else {
                    // Mettre à jour le mot de passe
                    // Ici vous devriez avoir une méthode updatePassword dans UserRepository
                    // Pour l'instant, on simule
                    header('Location: dashboard.php?action=parametres&success=password');
                    exit;
                }
            }
        }
        
        ob_start();
        include 'views/parametres/index.php';
        return ob_get_clean();
    }
    
    public function updateApparence() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $theme = $_POST['theme'] ?? 'light';
            
            // Sauvegarder le thème en session
            $_SESSION['theme'] = $theme;
            
            header('Location: dashboard.php?action=parametres&success=apparence');
            exit;
        }
        
        ob_start();
        include 'views/parametres/index.php';
        return ob_get_clean();
    }
    
    public function updateEntreprise() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom_entreprise = $_POST['nom_entreprise'] ?? '';
            $adresse = $_POST['adresse'] ?? '';
            $telephone = $_POST['telephone'] ?? '';
            $email = $_POST['email_entreprise'] ?? '';
            $rc = $_POST['rc'] ?? '';
            $patente = $_POST['patente'] ?? '';
            $if = $_POST['if'] ?? '';
            
            // Validation
            if (empty($nom_entreprise)) $errors[] = "Le nom de l'entreprise est obligatoire";
            if (empty($adresse)) $errors[] = "L'adresse est obligatoire";
            if (empty($telephone)) $errors[] = "Le téléphone est obligatoire";
            
            if (empty($errors)) {
                // Ici vous sauvegarderiez en base de données
                // Pour l'instant, on sauvegarde en session
                $_SESSION['entreprise_info'] = [
                    'nom' => $nom_entreprise,
                    'adresse' => $adresse,
                    'telephone' => $telephone,
                    'email' => $email,
                    'rc' => $rc,
                    'patente' => $patente,
                    'if' => $if
                ];
                
                header('Location: dashboard.php?action=parametres&success=entreprise');
                exit;
            }
        }
        
        ob_start();
        include 'views/parametres/index.php';
        return ob_get_clean();
    }
}
?>