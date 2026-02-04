<?php
require_once 'models/repositories/ContratRepository.php';
require_once 'models/services/FactureService.php';

class FactureController {
    private $contratRepo;
    private $factureService;
    
    public function __construct() {
        $this->contratRepo = new ContratRepository();
        $this->factureService = new FactureService();
    }
    
    public function index() {
        $contrats = $this->contratRepo->findAllWithDetails();
        ob_start();
        require 'views/factures/index.php';
        return ob_get_clean();
    }
    
    public function generate($numContrat) {
        $contrat = $this->contratRepo->findByIdWithDetails($numContrat);
        
        if (!$contrat) {
            header('Location: dashboard.php?action=factures&error=not_found');
            exit;
        }
        
        $factureHTML = $this->factureService->genererFacture($contrat);
        
        // Pour l'impression directe
        if (isset($_GET['print'])) {
            header('Content-Type: text/html');
            echo $factureHTML;
            exit;
        }
        
        ob_start();
        require 'views/factures/generate.php';
        echo ob_get_clean();
        exit;
    }

    public function download($numContrat) {
        $contrat = $this->contratRepo->findByIdWithDetails($numContrat);

        if (!$contrat) {
            header('Location: dashboard.php?action=factures&error=not_found');
            exit;
        }

        try {
            $fileName = 'Facture_FastCar_' . $contrat['num_contrat'] . '_' . date('Ymd_His') . '.pdf';
            $pdfContent = $this->factureService->genererFacturePdf($contrat, $fileName);

            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
            header('Content-Length: ' . strlen($pdfContent));
            header('Cache-Control: no-cache, no-store, must-revalidate');
            header('Pragma: no-cache');
            header('Expires: 0');
            
            echo $pdfContent;
            
        } catch (Exception $e) {
            error_log('Erreur génération PDF: ' . $e->getMessage());
            $_SESSION['error'] = "Erreur lors de la génération du PDF: " . $e->getMessage();
            header('Location: dashboard.php?action=factures');
        }

        exit;
    }
}
?>