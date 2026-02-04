<?php
require_once 'config/database.php';
require_once 'models/entities/Contrat.php';

class ContratRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    public function findAll(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM contrats ORDER BY created_at DESC");
            $contrats = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $contrats[] = new Contrat($row);
            }
            return $contrats;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des contrats: " . $e->getMessage());
            return [];
        }
    }
    
    public function findAllWithDetails(): array {
        try {
            $sql = "SELECT c.*, cl.nom as client_nom, cl.prenom as client_prenom, 
                           v.marque, v.modele, a.nom as agent_nom, a.prenom as agent_prenom
                    FROM contrats c
                    JOIN clients cl ON c.cin_client = cl.cin
                    JOIN voitures v ON c.matricule_vehicule = v.matricule
                    JOIN agents a ON c.num_agent = a.num_agent
                    ORDER BY c.created_at DESC";
            
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des contrats avec détails: " . $e->getMessage());
            return [];
        }
    }
    
    public function findById(string $numContrat): ?Contrat {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM contrats WHERE num_contrat = ?");
            $stmt->execute([$numContrat]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new Contrat($data) : null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche du contrat: " . $e->getMessage());
            return null;
        }
    }
    
    public function findByIdWithDetails(string $numContrat): ?array {
        $sql = "SELECT 
                    c.*,
                    cl.nom AS client_nom,
                    cl.prenom AS client_prenom,
                    cl.adresse AS client_adresse,
                    cl.telephone AS client_telephone,
                    cl.email AS client_email,
                    v.marque,
                    v.modele,
                    v.prix_journalier,
                    a.nom AS agent_nom,
                    a.prenom AS agent_prenom
                FROM contrats c
                LEFT JOIN clients cl ON c.cin_client = cl.cin
                LEFT JOIN voitures v ON c.matricule_vehicule = v.matricule
                LEFT JOIN agents a ON c.num_agent = a.num_agent
                WHERE c.num_contrat = ?";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$numContrat]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return $result ?: null;
    }
    
    public function save(Contrat $contrat): bool {
        try {
            $sql = "INSERT INTO contrats (num_contrat, date_debut, date_fin, montant_total, 
                    mode_paiement, kilometrage_location, etat_vehicule_location, 
                    cin_client, matricule_vehicule, num_agent) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $contrat->numContrat,
                $contrat->dateDebut,
                $contrat->dateFin,
                $contrat->montantTotal,
                $contrat->modePaiement,
                $contrat->kilometrageLocation,
                $contrat->etatVehiculeLocation,
                $contrat->cinClient,
                $contrat->matriculeVehicule,
                $contrat->numAgent
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du contrat: " . $e->getMessage());
            return false;
        }
    }
    
    public function update(Contrat $contrat): bool {
        try {
            $sql = "UPDATE contrats SET 
                    date_debut = ?, date_fin = ?, montant_total = ?, 
                    mode_paiement = ?, kilometrage_location = ?, etat_vehicule_location = ?, 
                    cin_client = ?, matricule_vehicule = ?, num_agent = ?
                    WHERE num_contrat = ?";
            
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $contrat->dateDebut,
                $contrat->dateFin,
                $contrat->montantTotal,
                $contrat->modePaiement,
                $contrat->kilometrageLocation,
                $contrat->etatVehiculeLocation,
                $contrat->cinClient,
                $contrat->matriculeVehicule,
                $contrat->numAgent,
                $contrat->numContrat
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification du contrat: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete(string $numContrat): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM contrats WHERE num_contrat = ?");
            return $stmt->execute([$numContrat]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du contrat: " . $e->getMessage());
            return false;
        }
    }
}
?>