<?php
class Agent {
    public $numAgent;
    public $nom;
    public $prenom;
    public $dateCreation;
    
    public function __construct($data = []) {
        $this->numAgent = $data['num_agent'] ?? '';
        $this->nom = $data['nom'] ?? '';
        $this->prenom = $data['prenom'] ?? '';
        $this->dateCreation = $data['created_at'] ?? date('Y-m-d H:i:s');
    }
    
    // Getters
    public function getNumAgent(): string {
        return $this->numAgent;
    }
    
    public function getNom(): string {
        return $this->nom;
    }
    
    public function getPrenom(): string {
        return $this->prenom;
    }
    
    public function getNomComplet(): string {
        return $this->prenom . ' ' . $this->nom;
    }
    
    public function getDateCreation(): string {
        return $this->dateCreation;
    }
    
    public function getDateCreationFormatee(): string {
        return date('d/m/Y H:i', strtotime($this->dateCreation));
    }
    
    // Setters avec validation
    public function setNumAgent(string $numAgent): void {
        if (empty($numAgent)) {
            throw new InvalidArgumentException("Le numéro d'agent ne peut pas être vide");
        }
        $this->numAgent = $numAgent;
    }
    
    public function setNom(string $nom): void {
        if (empty($nom)) {
            throw new InvalidArgumentException("Le nom ne peut pas être vide");
        }
        $this->nom = htmlspecialchars(trim($nom));
    }
    
    public function setPrenom(string $prenom): void {
        if (empty($prenom)) {
            throw new InvalidArgumentException("Le prénom ne peut pas être vide");
        }
        $this->prenom = htmlspecialchars(trim($prenom));
    }
    
    // Méthodes de validation
    public function valider(): array {
        $erreurs = [];
        
        try {
            $this->setNumAgent($this->numAgent);
        } catch (InvalidArgumentException $e) {
            $erreurs['num_agent'] = $e->getMessage();
        }
        
        try {
            $this->setNom($this->nom);
        } catch (InvalidArgumentException $e) {
            $erreurs['nom'] = $e->getMessage();
        }
        
        try {
            $this->setPrenom($this->prenom);
        } catch (InvalidArgumentException $e) {
            $erreurs['prenom'] = $e->getMessage();
        }
        
        return $erreurs;
    }
    
    // Conversion en tableau pour les vues
    public function toArray(): array {
        return [
            'num_agent' => $this->numAgent,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'nom_complet' => $this->getNomComplet(),
            'date_creation' => $this->dateCreation,
            'date_creation_formatee' => $this->getDateCreationFormatee()
        ];
    }
    
    // Méthode magique pour l'affichage
    public function __toString(): string {
        return $this->getNomComplet() . " ({$this->numAgent})";
    }
}
?>