<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-show me-2"></i>Détails du Contrat</h3>
    <div>
        <a href="dashboard.php?action=factures_generate&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
           target="_blank" class="btn btn-success">
            <i class="bx bx-printer me-1"></i>Imprimer Facture
        </a>
        <a href="dashboard.php?action=contrats" class="btn btn-secondary">
            <i class="bx bx-arrow-back me-1"></i>Retour
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Informations Contrat</h5>
                <p><strong>N° Contrat:</strong> <?= htmlspecialchars($contrat['num_contrat']) ?></p>
                <p><strong>Date début:</strong> <?= date('d/m/Y', strtotime($contrat['date_debut'])) ?></p>
                <p><strong>Date fin:</strong> <?= date('d/m/Y', strtotime($contrat['date_fin'])) ?></p>
                <p><strong>Mode paiement:</strong> <?= htmlspecialchars($contrat['mode_paiement']) ?></p>
                <p><strong>Montant total:</strong> <?= number_format($contrat['montant_total'], 2, ',', ' ') ?> MAD</p>
            </div>
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Informations Véhicule</h5>
                <p><strong>Matricule:</strong> <?= htmlspecialchars($contrat['matricule_vehicule']) ?></p>
                <p><strong>Véhicule:</strong> <?= htmlspecialchars($contrat['marque']) ?> <?= htmlspecialchars($contrat['modele']) ?></p>
                <p><strong>Prix journalier:</strong> <?= number_format($contrat['prix_journalier'], 2, ',', ' ') ?> MAD</p>
                <p><strong>Kilométrage:</strong> <?= number_format($contrat['kilometrage_location'], 0, '', ' ') ?> km</p>
                <p><strong>État:</strong> <?= htmlspecialchars($contrat['etat_vehicule_location']) ?></p>
            </div>
        </div>
        
        <hr>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Informations Client</h5>
                <p><strong>CIN:</strong> <?= htmlspecialchars($contrat['cin_client']) ?></p>
                <p><strong>Nom:</strong> <?= htmlspecialchars($contrat['client_nom']) ?> <?= htmlspecialchars($contrat['client_prenom']) ?></p>
                <p><strong>Adresse:</strong> <?= htmlspecialchars($contrat['client_adresse']) ?></p>
                <p><strong>Téléphone:</strong> <?= htmlspecialchars($contrat['client_telephone']) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($contrat['client_email']) ?></p>
            </div>
            <div class="col-md-6">
                <h5 class="text-primary mb-3">Informations Agent</h5>
                <p><strong>N° Agent:</strong> <?= htmlspecialchars($contrat['num_agent']) ?></p>
                <p><strong>Agent:</strong> <?= htmlspecialchars($contrat['agent_nom']) ?> <?= htmlspecialchars($contrat['agent_prenom']) ?></p>
            </div>
        </div>
    </div>
</div>