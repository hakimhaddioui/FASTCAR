<?php
require_once 'models/repositories/VoitureRepository.php';

class VoitureController {
    private $voitureRepo;
    
    public function __construct() {
        $this->voitureRepo = new VoitureRepository();
    }
    
    public function index() {
        try {
            $voitures = $this->voitureRepo->findAll();
            ob_start();
            include 'views/voitures/index.php';
            return ob_get_clean();
        } catch (Exception $e) {
            error_log("Erreur dans VoitureController::index(): " . $e->getMessage());
            return "<div class='alert alert-danger'>Erreur lors du chargement des voitures</div>";
        }
    }
    
    public function create() {
        $errors = [];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $voiture = new Voiture([
                'matricule' => trim($_POST['matricule'] ?? ''),
                'marque' => trim($_POST['marque'] ?? ''),
                'modele' => trim($_POST['modele'] ?? ''),
                'prix_journalier' => floatval($_POST['prix_journalier'] ?? 0),
                'etat_courant' => $_POST['etat_courant'] ?? 'Disponible',
                'kilometrage_actuel' => intval($_POST['kilometrage_actuel'] ?? 0)
            ]);
            
            // Validation simple
            if (empty($voiture->matricule)) $errors[] = "Le matricule est obligatoire";
            if (empty($voiture->marque)) $errors[] = "La marque est obligatoire";
            if (empty($voiture->modele)) $errors[] = "Le modèle est obligatoire";
            if ($voiture->prixJournalier <= 0) $errors[] = "Le prix journalier doit être positif";
            
            if (empty($errors)) {
                if ($this->voitureRepo->save($voiture)) {
                    header('Location: dashboard.php?action=voitures&message=success');
                    exit;
                } else {
                    $errors[] = "Erreur lors de l'ajout de la voiture (matricule peut-être déjà existant)";
                }
            }
        }
        
        ob_start();
        include 'views/voitures/create.php';
        return ob_get_clean();
    }
    
    public function edit($matricule) {
        try {
            $voiture = $this->voitureRepo->findById($matricule);
            $errors = [];
            
            if (!$voiture) {
                header('Location: dashboard.php?action=voitures&error=not_found');
                exit;
            }
            
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $voiture->marque = trim($_POST['marque'] ?? '');
                $voiture->modele = trim($_POST['modele'] ?? '');
                $voiture->prixJournalier = floatval($_POST['prix_journalier'] ?? 0);
                $voiture->etatCourant = $_POST['etat_courant'] ?? 'Disponible';
                $voiture->kilometrageActuel = intval($_POST['kilometrage_actuel'] ?? 0);
                
                // Validation
                if (empty($voiture->marque)) $errors[] = "La marque est obligatoire";
                if (empty($voiture->modele)) $errors[] = "Le modèle est obligatoire";
                if ($voiture->prixJournalier <= 0) $errors[] = "Le prix journalier doit être positif";
                
                if (empty($errors)) {
                    if ($this->voitureRepo->update($voiture)) {
                        header('Location: dashboard.php?action=voitures&message=updated');
                        exit;
                    } else {
                        $errors[] = "Erreur lors de la modification";
                    }
                }
            }
            
            ob_start();
            include 'views/voitures/edit.php';
            return ob_get_clean();
        } catch (Exception $e) {
            error_log("Erreur dans VoitureController::edit(): " . $e->getMessage());
            header('Location: dashboard.php?action=voitures&error=not_found');
            exit;
        }
    }
    
    public function delete($matricule) {
        try {
            if ($this->voitureRepo->delete($matricule)) {
                header('Location: dashboard.php?action=voitures&message=deleted');
                exit;
            } else {
                header('Location: dashboard.php?action=voitures&error=delete_failed');
                exit;
            }
        } catch (Exception $e) {
            error_log("Erreur dans VoitureController::delete(): " . $e->getMessage());
            header('Location: dashboard.php?action=voitures&error=delete_failed');
            exit;
        }
    }
}
?>