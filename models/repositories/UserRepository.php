<?php
require_once 'config/database.php';
require_once 'models/entities/User.php';

class UserRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    public function findByEmail(string $email): ?User {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new User($data) : null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche de l'utilisateur: " . $e->getMessage());
            return null;
        }
    }
    
    public function findById(int $id): ?User {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
            $stmt->execute([$id]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new User($data) : null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche de l'utilisateur: " . $e->getMessage());
            return null;
        }
    }

    public function update(User $user): bool {
    try {
        $sql = "UPDATE users SET nom = ?, prenom = ?, email = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            $user->nom,
            $user->prenom,
            $user->email,
            $user->id
        ]);
    } catch (PDOException $e) {
        error_log("Erreur lors de la modification de l'utilisateur: " . $e->getMessage());
        return false;
    }
    }
    
    public function updatePassword(int $userId, string $newPassword): bool {
        try {
            $sql = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                password_hash($newPassword, PASSWORD_DEFAULT),
                $userId
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors du changement de mot de passe: " . $e->getMessage());
            return false;
        }
    }
    
    public function save(User $user): bool {
        try {
            $sql = "INSERT INTO users (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $user->nom,
                $user->prenom,
                $user->email,
                $user->password,
                $user->role
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'utilisateur: " . $e->getMessage());
            return false;
        }
    }
}
?>