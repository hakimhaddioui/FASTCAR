<?php
require_once 'config/database.php';
require_once 'models/repositories/VoitureRepository.php';
require_once 'models/repositories/ClientRepository.php';
require_once 'models/repositories/AgentRepository.php';
require_once 'models/repositories/ContratRepository.php';

class SearchController {
    private $pdo;
    private $voitureRepo;
    private $clientRepo;
    private $agentRepo;
    private $contratRepo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
        $this->voitureRepo = new VoitureRepository();
        $this->clientRepo = new ClientRepository();
        $this->agentRepo = new AgentRepository();
        $this->contratRepo = new ContratRepository();
    }
    
    public function search() {
        $query = $_GET['q'] ?? '';
        $type = $_GET['type'] ?? 'all';
        
        if (empty($query)) {
            return $this->renderResults([], [], [], [], $query);
        }
        
        $voitures = [];
        $clients = [];
        $agents = [];
        $contrats = [];
        
        if ($type === 'all' || $type === 'voitures') {
            $voitures = $this->searchVoitures($query);
        }
        
        if ($type === 'all' || $type === 'clients') {
            $clients = $this->searchClients($query);
        }
        
        if ($type === 'all' || $type === 'agents') {
            $agents = $this->searchAgents($query);
        }
        
        if ($type === 'all' || $type === 'contrats') {
            $contrats = $this->searchContrats($query);
        }
        
        return $this->renderResults($voitures, $clients, $agents, $contrats, $query, $type);
    }
    
    private function searchVoitures(string $query): array {
        $sql = "SELECT * FROM voitures 
                WHERE matricule LIKE ? 
                   OR marque LIKE ? 
                   OR modele LIKE ?
                ORDER BY marque, modele
                LIMIT 20";
        
        $searchTerm = "%$query%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    private function searchClients(string $query): array {
        $sql = "SELECT * FROM clients 
                WHERE cin LIKE ? 
                   OR nom LIKE ? 
                   OR prenom LIKE ?
                   OR email LIKE ?
                   OR telephone LIKE ?
                ORDER BY nom, prenom
                LIMIT 20";
        
        $searchTerm = "%$query%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    private function searchAgents(string $query): array {
        $sql = "SELECT * FROM agents 
                WHERE num_agent LIKE ? 
                   OR nom LIKE ? 
                   OR prenom LIKE ?
                ORDER BY nom, prenom
                LIMIT 20";
        
        $searchTerm = "%$query%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    private function searchContrats(string $query): array {
        $sql = "SELECT c.*, cl.nom as client_nom, cl.prenom as client_prenom, 
                       v.marque, v.modele, a.nom as agent_nom, a.prenom as agent_prenom
                FROM contrats c
                JOIN clients cl ON c.cin_client = cl.cin
                JOIN voitures v ON c.matricule_vehicule = v.matricule
                JOIN agents a ON c.num_agent = a.num_agent
                WHERE c.num_contrat LIKE ? 
                   OR c.cin_client LIKE ?
                   OR c.matricule_vehicule LIKE ?
                   OR cl.nom LIKE ?
                   OR cl.prenom LIKE ?
                   OR v.marque LIKE ?
                   OR v.modele LIKE ?
                ORDER BY c.created_at DESC
                LIMIT 20";
        
        $searchTerm = "%$query%";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
    
    private function renderResults(array $voitures, array $clients, array $agents, array $contrats, string $query, string $type = 'all'): string {
        ob_start();
        require 'views/search/results.php';
        return ob_get_clean();
    }
}

