<?php
require_once 'models/repositories/AgentRepository.php';

class AgentController {
    private $agentRepo;
    
    public function __construct() {
        $this->agentRepo = new AgentRepository();
    }
    
    public function index() {
        try {
            $agents = $this->agentRepo->findAll();
            ob_start();
            include 'views/agents/index.php';
            return ob_get_clean();
        } catch (Exception $e) {
            error_log("Erreur dans AgentController::index(): " . $e->getMessage());
            return "<div class='alert alert-danger'>Erreur lors du chargement des agents</div>";
        }
    }
    
    public function create() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $agent = new Agent([
                'num_agent' => trim($_POST['num_agent'] ?? ''),
                'nom' => trim($_POST['nom'] ?? ''),
                'prenom' => trim($_POST['prenom'] ?? '')
            ]);
            
            // Validation
            if (empty($agent->numAgent)) $errors[] = "Le numéro d'agent est obligatoire";
            if (empty($agent->nom)) $errors[] = "Le nom est obligatoire";
            if (empty($agent->prenom)) $errors[] = "Le prénom est obligatoire";
            
            if (empty($errors)) {
                if ($this->agentRepo->save($agent)) {
                    header('Location: dashboard.php?action=agents&message=success');
                    exit;
                } else {
                    $errors[] = "Erreur lors de l'ajout de l'agent (numéro peut-être déjà existant)";
                }
            }
        }
        
        ob_start();
        include 'views/agents/create.php';
        return ob_get_clean();
    }
    
    public function edit($numAgent) {
        $agent = $this->agentRepo->findById($numAgent);
        $errors = [];
        
        if (!$agent) {
            header('Location: dashboard.php?action=agents&error=not_found');
            exit;
        }
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $agent->nom = trim($_POST['nom'] ?? '');
            $agent->prenom = trim($_POST['prenom'] ?? '');
            
            // Validation
            if (empty($agent->nom)) $errors[] = "Le nom est obligatoire";
            if (empty($agent->prenom)) $errors[] = "Le prénom est obligatoire";
            
            if (empty($errors)) {
                if ($this->agentRepo->update($agent)) {
                    header('Location: dashboard.php?action=agents&message=updated');
                    exit;
                } else {
                    $errors[] = "Erreur lors de la modification";
                }
            }
        }
        
        ob_start();
        include 'views/agents/edit.php';
        return ob_get_clean();
    }
    
    public function delete($numAgent) {
        if ($this->agentRepo->delete($numAgent)) {
            header('Location: dashboard.php?action=agents&message=deleted');
            exit;
        } else {
            header('Location: dashboard.php?action=agents&error=delete_failed');
            exit;
        }
    }
}
?>