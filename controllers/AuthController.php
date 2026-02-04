<?php
require_once 'models/repositories/UserRepository.php';

class AuthController {
    private $userRepo;
    
    public function __construct() {
        $this->userRepo = new UserRepository();
    }
    
    public function connexion() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            
            // Validation
            if (empty($email)) {
                $errors[] = "L'email est obligatoire";
            }
            if (empty($password)) {
                $errors[] = "Le mot de passe est obligatoire";
            }
            
            if (empty($errors)) {
                $user = $this->userRepo->findByEmail($email);
                
                if ($user && password_verify($password, $user->password)) {
                    // Connexion réussie
                    $_SESSION['user_id'] = $user->id;
                    $_SESSION['user_nom'] = $user->nom;
                    $_SESSION['user_prenom'] = $user->prenom;
                    $_SESSION['user_email'] = $user->email;
                    $_SESSION['user_role'] = $user->role;
                    
                    header('Location: dashboard.php');
                    exit;
                } else {
                    $errors[] = "Email ou mot de passe incorrect";
                }
            }
        }
        
        // Afficher la vue de connexion
        include 'views/auth/connexion.php';
        exit;
    }
    
    public function inscription() {
        $errors = [];
        $success = false;
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nom = $_POST['nom'] ?? '';
            $prenom = $_POST['prenom'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            
            // Validation
            if (empty($nom)) $errors[] = "Le nom est obligatoire";
            if (empty($prenom)) $errors[] = "Le prénom est obligatoire";
            if (empty($email)) $errors[] = "L'email est obligatoire";
            if (empty($password)) $errors[] = "Le mot de passe est obligatoire";
            if ($password !== $confirm_password) $errors[] = "Les mots de passe ne correspondent pas";
            if (strlen($password) < 6) $errors[] = "Le mot de passe doit contenir au moins 6 caractères";
            
            // Vérifier si l'email existe déjà
            if (empty($errors)) {
                $existingUser = $this->userRepo->findByEmail($email);
                if ($existingUser) {
                    $errors[] = "Cet email est déjà utilisé";
                }
            }
            
            if (empty($errors)) {
                $user = new User([
                    'nom' => $nom,
                    'prenom' => $prenom,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role' => 'user'
                ]);
                
                if ($this->userRepo->save($user)) {
                    $success = true;
                } else {
                    $errors[] = "Erreur lors de l'inscription";
                }
            }
        }
        
        // Afficher la vue d'inscription
        include 'views/auth/inscription.php';
        exit;
    }
}
?>