<?php
class Voiture {
    public $matricule;
    public $marque;
    public $modele;
    public $prixJournalier;
    public $etatCourant;
    public $kilometrageActuel;
    
    public function __construct($data = []) {
        $this->matricule = $data['matricule'] ?? '';
        $this->marque = $data['marque'] ?? '';
        $this->modele = $data['modele'] ?? '';
        $this->prixJournalier = floatval($data['prix_journalier'] ?? 0);
        $this->etatCourant = $data['etat_courant'] ?? 'Disponible';
        $this->kilometrageActuel = intval($data['kilometrage_actuel'] ?? 0);
    }
    
    // Getters
    public function getMatricule(): string {
        return $this->matricule;
    }
    
    public function getMarque(): string {
        return $this->marque;
    }
    
    public function getModele(): string {
        return $this->modele;
    }
    
    public function getPrixJournalier(): float {
        return $this->prixJournalier;
    }
    
    public function getPrixJournalierFormate(): string {
        return number_format($this->prixJournalier, 2, ',', ' ');
    }
    
    public function getEtatCourant(): string {
        return $this->etatCourant;
    }
    
    public function getKilometrageActuel(): int {
        return $this->kilometrageActuel;
    }
    
    public function getKilometrageFormate(): string {
        return number_format($this->kilometrageActuel, 0, '', ' ');
    }
    
    // Setters avec validation
    public function setMatricule(string $matricule): void {
        if (empty($matricule)) {
            throw new InvalidArgumentException("Le matricule ne peut pas être vide");
        }
        $this->matricule = $matricule;
    }
    
    public function setMarque(string $marque): void {
        if (empty($marque)) {
            throw new InvalidArgumentException("La marque ne peut pas être vide");
        }
        $this->marque = htmlspecialchars(trim($marque));
    }
    
    public function setModele(string $modele): void {
        if (empty($modele)) {
            throw new InvalidArgumentException("Le modèle ne peut pas être vide");
        }
        $this->modele = htmlspecialchars(trim($modele));
    }
    
    public function setPrixJournalier(float $prix): void {
        if ($prix <= 0) {
            throw new InvalidArgumentException("Le prix journalier doit être positif");
        }
        $this->prixJournalier = $prix;
    }
    
    public function setKilometrageActuel(int $km): void {
        if ($km < 0) {
            throw new InvalidArgumentException("Le kilométrage ne peut pas être négatif");
        }
        $this->kilometrageActuel = $km;
    }
    
    // Méthode de validation
    public function valider(): array {
        $erreurs = [];
        
        try {
            $this->setMatricule($this->matricule);
        } catch (InvalidArgumentException $e) {
            $erreurs['matricule'] = $e->getMessage();
        }
        
        try {
            $this->setMarque($this->marque);
        } catch (InvalidArgumentException $e) {
            $erreurs['marque'] = $e->getMessage();
        }
        
        try {
            $this->setModele($this->modele);
        } catch (InvalidArgumentException $e) {
            $erreurs['modele'] = $e->getMessage();
        }
        
        try {
            $this->setPrixJournalier($this->prixJournalier);
        } catch (InvalidArgumentException $e) {
            $erreurs['prix_journalier'] = $e->getMessage();
        }
        
        try {
            $this->setKilometrageActuel($this->kilometrageActuel);
        } catch (InvalidArgumentException $e) {
            $erreurs['kilometrage_actuel'] = $e->getMessage();
        }
        
        return $erreurs;
    }
    
    // Conversion en tableau
    public function toArray(): array {
        return [
            'matricule' => $this->matricule,
            'marque' => $this->marque,
            'modele' => $this->modele,
            'prix_journalier' => $this->prixJournalier,
            'prix_journalier_formate' => $this->getPrixJournalierFormate(),
            'etat_courant' => $this->etatCourant,
            'kilometrage_actuel' => $this->kilometrageActuel,
            'kilometrage_formate' => $this->getKilometrageFormate()
        ];
    }
}
?>