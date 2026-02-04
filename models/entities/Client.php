<?php
class Client {
    public $cin;
    public $nom;
    public $prenom;
    public $adresse;
    public $telephone;
    public $email;
    
    public function __construct($data = []) {
        $this->cin = $data['cin'] ?? '';
        $this->nom = $data['nom'] ?? '';
        $this->prenom = $data['prenom'] ?? '';
        $this->adresse = $data['adresse'] ?? '';
        $this->telephone = $data['telephone'] ?? '';
        $this->email = $data['email'] ?? '';
    }
}
?>