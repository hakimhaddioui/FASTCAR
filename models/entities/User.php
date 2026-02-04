<?php
class User {
    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $password;
    public $role;
    public $dateCreation;
    
    public function __construct($data = []) {
        $this->id = $data['id'] ?? null;
        $this->nom = $data['nom'] ?? '';
        $this->prenom = $data['prenom'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->role = $data['role'] ?? 'user';
        $this->dateCreation = $data['created_at'] ?? date('Y-m-d H:i:s');
    }
    
    // Getters
    public function getNomComplet(): string {
        return $this->prenom . ' ' . $this->nom;
    }
}
?>