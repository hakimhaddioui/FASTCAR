<?php
require_once 'models/repositories/ContratRepository.php';
require_once 'models/repositories/VoitureRepository.php';
require_once 'models/repositories/ClientRepository.php';
require_once 'models/repositories/AgentRepository.php';
require_once 'models/services/LocationService.php';

class ContratController {
    private $contratRepo;
    private $voitureRepo;
    private $clientRepo;
    private $agentRepo;
    private $locationService;
    
    public function __construct() {
        $this->contratRepo = new ContratRepository();
        $this->voitureRepo = new VoitureRepository();
        $this->clientRepo = new ClientRepository();
        $this->agentRepo = new AgentRepository();
        $this->locationService = new LocationService($this->contratRepo, $this->voitureRepo);
    }
    
    public function index() {
        $contrats = $this->contratRepo->findAllWithDetails();
        ob_start();
        require 'views/contrats/index.php';
        return ob_get_clean();
    }
    
    public function create() {
        $voitures = $this->voitureRepo->findDisponibles();
        $clients = $this->clientRepo->findAll();
        $agents = $this->agentRepo->findAll();
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contrat = new Contrat([
                'date_debut' => trim($_POST['date_debut'] ?? ''),
                'date_fin' => trim($_POST['date_fin'] ?? ''),
                'montant_total' => floatval($_POST['montant_total'] ?? 0),
                'mode_paiement' => $_POST['mode_paiement'] ?? 'Espèce',
                'kilometrage_location' => intval($_POST['kilometrage_location'] ?? 0),
                'etat_vehicule_location' => trim($_POST['etat_vehicule_location'] ?? 'Très bon état'),
                'cin_client' => trim($_POST['cin_client'] ?? ''),
                'matricule_vehicule' => trim($_POST['matricule_vehicule'] ?? ''),
                'num_agent' => trim($_POST['num_agent'] ?? '')
            ]);
            
            $result = $this->locationService->creerContrat($contrat);
            
            if ($result['success']) {
                header('Location: dashboard.php?action=contrats&message=success&contrat=' . $result['numContrat']);
                exit;
            } else {
                $errors = $result['errors'];
            }
        }
        
        ob_start();
        require 'views/contrats/create.php';
        return ob_get_clean();
    }
    
    public function edit($numContrat) {
        $contrat = $this->contratRepo->findById($numContrat);
        
        if (!$contrat) {
            header('Location: dashboard.php?action=contrats&error=not_found');
            exit;
        }
        
        $voitures = $this->voitureRepo->findAll();
        $clients = $this->clientRepo->findAll();
        $agents = $this->agentRepo->findAll();
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $contrat->dateDebut = trim($_POST['date_debut'] ?? '');
            $contrat->dateFin = trim($_POST['date_fin'] ?? '');
            $contrat->montantTotal = floatval($_POST['montant_total'] ?? 0);
            $contrat->modePaiement = $_POST['mode_paiement'] ?? 'Espèce';
            $contrat->kilometrageLocation = intval($_POST['kilometrage_location'] ?? 0);
            $contrat->etatVehiculeLocation = trim($_POST['etat_vehicule_location'] ?? 'Très bon état');
            $contrat->cinClient = trim($_POST['cin_client'] ?? '');
            $contrat->matriculeVehicule = trim($_POST['matricule_vehicule'] ?? '');
            $contrat->numAgent = trim($_POST['num_agent'] ?? '');
            
            if ($this->contratRepo->update($contrat)) {
                header('Location: dashboard.php?action=contrats&message=updated');
                exit;
            } else {
                $errors[] = "Erreur lors de la mise à jour du contrat";
            }
        }
        
        ob_start();
        require 'views/contrats/edit.php';
        return ob_get_clean();
    }
    
    public function delete($numContrat) {
        $contrat = $this->contratRepo->findById($numContrat);
        
        if (!$contrat) {
            header('Location: dashboard.php?action=contrats&error=not_found');
            exit;
        }
        
        // Libérer la voiture
        $voiture = $this->voitureRepo->findById($contrat->matriculeVehicule);
        if ($voiture) {
            $voiture->etatCourant = 'Disponible';
            $this->voitureRepo->update($voiture);
        }
        
        if ($this->contratRepo->delete($numContrat)) {
            header('Location: dashboard.php?action=contrats&message=deleted');
        } else {
            header('Location: dashboard.php?action=contrats&error=delete_failed');
        }
        exit;
    }
    
    public function show($numContrat) {
        $contrat = $this->contratRepo->findByIdWithDetails($numContrat);
        
        if (!$contrat) {
            header('Location: dashboard.php?action=contrats&error=not_found');
            exit;
        }
        
        ob_start();
        require 'views/contrats/show.php';
        return ob_get_clean();
    }
}
?>