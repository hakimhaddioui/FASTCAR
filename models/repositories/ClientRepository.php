<?php
require_once 'config/database.php';
require_once 'models/entities/Client.php';

class ClientRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    public function findAll(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM clients ORDER BY nom, prenom");
            $clients = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $clients[] = new Client($row);
            }
            return $clients;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des clients: " . $e->getMessage());
            return [];
        }
    }
    
    public function findById(string $cin): ?Client {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM clients WHERE cin = ?");
            $stmt->execute([$cin]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new Client($data) : null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche du client: " . $e->getMessage());
            return null;
        }
    }
    
    public function save(Client $client): bool {
        try {
            $sql = "INSERT INTO clients (cin, nom, prenom, adresse, telephone, email) 
                    VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $client->cin,
                $client->nom,
                $client->prenom,
                $client->adresse,
                $client->telephone,
                $client->email
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout du client: " . $e->getMessage());
            return false;
        }
    }
    
    public function update(Client $client): bool {
        try {
            $sql = "UPDATE clients SET nom = ?, prenom = ?, adresse = ?, telephone = ?, email = ? 
                    WHERE cin = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $client->nom,
                $client->prenom,
                $client->adresse,
                $client->telephone,
                $client->email,
                $client->cin
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification du client: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete(string $cin): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM clients WHERE cin = ?");
            return $stmt->execute([$cin]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du client: " . $e->getMessage());
            return false;
        }
    }
}
?>