<?php
require_once 'config/database.php';
require_once 'models/entities/Agent.php';

class AgentRepository {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    public function findAll(): array {
        try {
            $stmt = $this->pdo->query("SELECT * FROM agents ORDER BY nom, prenom");
            $agents = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $agents[] = new Agent($row);
            }
            return $agents;
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des agents: " . $e->getMessage());
            return [];
        }
    }
    
    public function findById(string $numAgent): ?Agent {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM agents WHERE num_agent = ?");
            $stmt->execute([$numAgent]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            return $data ? new Agent($data) : null;
        } catch (PDOException $e) {
            error_log("Erreur lors de la recherche de l'agent: " . $e->getMessage());
            return null;
        }
    }
    
    public function save(Agent $agent): bool {
        try {
            $sql = "INSERT INTO agents (num_agent, nom, prenom) VALUES (?, ?, ?)";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $agent->numAgent,
                $agent->nom,
                $agent->prenom
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de l'ajout de l'agent: " . $e->getMessage());
            return false;
        }
    }
    
    public function update(Agent $agent): bool {
        try {
            $sql = "UPDATE agents SET nom = ?, prenom = ? WHERE num_agent = ?";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                $agent->nom,
                $agent->prenom,
                $agent->numAgent
            ]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la modification de l'agent: " . $e->getMessage());
            return false;
        }
    }
    
    public function delete(string $numAgent): bool {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM agents WHERE num_agent = ?");
            return $stmt->execute([$numAgent]);
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression de l'agent: " . $e->getMessage());
            return false;
        }
    }
}
?>