<?php
require_once 'models/entities/Contrat.php';

class LocationService {
    private $contratRepo;
    private $voitureRepo;
    
    public function __construct($contratRepo, $voitureRepo) {
        $this->contratRepo = $contratRepo;
        $this->voitureRepo = $voitureRepo;
    }
    
    public function creerContrat(Contrat $contrat): array {
        $errors = [];
        
        // Validation des dates
        $dateDebut = strtotime($contrat->dateDebut);
        $dateFin = strtotime($contrat->dateFin);
        
        if ($dateDebut === false || $dateFin === false) {
            $errors[] = "Les dates fournies ne sont pas valides";
        } elseif ($dateFin <= $dateDebut) {
            $errors[] = "La date de fin doit être postérieure à la date de début";
        }
        
        // Vérifier disponibilité véhicule
        $voiture = $this->voitureRepo->findById($contrat->matriculeVehicule);
        if (!$voiture) {
            $errors[] = "Le véhicule sélectionné n'existe pas";
        } elseif ($voiture->etatCourant !== 'Disponible') {
            $errors[] = "Le véhicule n'est pas disponible pour la location (état: " . $voiture->etatCourant . ")";
        }
        
        // Validation du montant
        if ($contrat->montantTotal <= 0) {
            $errors[] = "Le montant total doit être positif";
        }
        
        if (empty($errors)) {
            // Générer numéro contrat unique
            do {
                $contrat->numContrat = 'LOC-' . date('Y') . '-' . sprintf('%05d', rand(1, 99999));
                $existing = $this->contratRepo->findById($contrat->numContrat);
            } while ($existing !== null);
            
            if ($this->contratRepo->save($contrat)) {
                // Mettre à jour état du véhicule
                $voiture->etatCourant = 'Louée';
                $this->voitureRepo->update($voiture);
                return ['success' => true, 'numContrat' => $contrat->numContrat];
            }
            $errors[] = "Erreur lors de la création du contrat";
        }
        
        return ['success' => false, 'errors' => $errors];
    }
    
    public function calculerMontant($dateDebut, $dateFin, $prixJournalier): float {
        $timestampDebut = strtotime($dateDebut);
        $timestampFin = strtotime($dateFin);
        // Calculer le nombre de jours (dates inclusives: +1 jour)
        $jours = max(1, floor(($timestampFin - $timestampDebut) / (60 * 60 * 24)) + 1);
        return $jours * $prixJournalier;
    }
}
?>