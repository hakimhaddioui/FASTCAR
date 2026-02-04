<?php
class Contrat {
    public $numContrat;
    public $dateDebut;
    public $dateFin;
    public $montantTotal;
    public $modePaiement;
    public $kilometrageLocation;
    public $etatVehiculeLocation;
    public $cinClient;
    public $matriculeVehicule;
    public $numAgent;
    
    public function __construct($data = []) {
        $this->numContrat = $data['num_contrat'] ?? '';
        $this->dateDebut = $data['date_debut'] ?? '';
        $this->dateFin = $data['date_fin'] ?? '';
        $this->montantTotal = $data['montant_total'] ?? 0;
        $this->modePaiement = $data['mode_paiement'] ?? 'Espèce';
        $this->kilometrageLocation = $data['kilometrage_location'] ?? 0;
        $this->etatVehiculeLocation = $data['etat_vehicule_location'] ?? '';
        $this->cinClient = $data['cin_client'] ?? '';
        $this->matriculeVehicule = $data['matricule_vehicule'] ?? '';
        $this->numAgent = $data['num_agent'] ?? '';
    }
}
?>