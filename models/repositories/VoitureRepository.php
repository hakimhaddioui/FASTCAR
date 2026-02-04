<?php
require_once 'config/database.php';
require_once 'models/entities/Voiture.php';

class VoitureRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    public function findAll(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM voitures ORDER BY marque, modele");
            $voitures = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $voitures[] = new Voiture($row);
            }
            return $voitures;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des voitures: " . $e->getMessage());
            return [];
        }
    }
    
    public function findById(string $matricule): ?Voiture {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM voitures WHERE matricule = ?");
            $stmt->execute([$matricule]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new Voiture($data) : null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche de la voiture: " . $e->getMessage());
            return null;
        }
    }
    
    public function save(Voiture $voiture): bool {
        try {
            $sql = "INSERT INTO voitures (matricule, marque, modele, prix_journalier, etat_courant, kilometrage_actuel) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $voiture->matricule,
                $voiture->marque,
                $voiture->modele,
                $voiture->prixJournalier,
                $voiture->etatCourant,
                $voiture->kilometrageActuel
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de la voiture: " . $e->getMessage());
            return false;
        }
    }
    
    public function update(Voiture $voiture): bool {
        try {
            $sql = "UPDATE voitures SET marque = ?, modele = ?, prix_journalier = ?, 
                    etat_courant = ?, kilometrage_actuel = ? WHERE matricule = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $voiture->marque,
                $voiture->modele,
                $voiture->prixJournalier,
                $voiture->etatCourant,
                $voiture->kilometrageActuel,
                $voiture->matricule
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification de la voiture: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete(string $matricule): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM voitures WHERE matricule = ?");
            return $stmt->execute([$matricule]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de la voiture: " . $e->getMessage());
            return false;
        }
    }
    
    public function findDisponibles(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM voitures WHERE etat_courant = 'Disponible' ORDER BY marque, modele");
            $voitures = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $voitures[] = new Voiture($row);
            }
            return $voitures;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des voitures disponibles: " . $e->getMessage());
            return [];
        }
    }
}
?>