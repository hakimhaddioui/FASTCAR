<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-edit me-2"></i>Modifier le Contrat de Location</h3>
    <a href="dashboard.php?action=contrats" class="btn btn-secondary">
        <i class="bx bx-arrow-back me-1"></i>Retour à la liste
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="row">
                <div class="col-md-6">
                    <h5 class="mb-3 text-primary">Informations Client</h5>
                    <div class="mb-3">
                        <label class="form-label">Client *</label>
                        <select name="cin_client" class="form-select" required>
                            <option value="">Sélectionner un client</option>
                            <?php foreach ($clients as $client): ?>
                                <option value="<?= $client->cin ?>" <?= ($contrat->cinClient === $client->cin) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($client->nom) ?> <?= htmlspecialchars($client->prenom) ?> (<?= $client->cin ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3 text-primary">Informations Véhicule</h5>
                    <div class="mb-3">
                        <label class="form-label">Véhicule *</label>
                        <select name="matricule_vehicule" class="form-select" required id="vehiculeSelect">
                            <option value="">Sélectionner un véhicule</option>
                            <?php foreach ($voitures as $voiture): ?>
                                <option value="<?= $voiture->matricule ?>" data-prix="<?= $voiture->prixJournalier ?>" 
                                    <?= ($contrat->matriculeVehicule === $voiture->matricule) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($voiture->marque) ?> <?= htmlspecialchars($voiture->modele) ?> - 
                                    <?= number_format($voiture->prixJournalier, 2, ',', ' ') ?> MAD/jour
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kilométrage actuel *</label>
                        <input type="number" name="kilometrage_location" class="form-control" 
                               value="<?= htmlspecialchars($contrat->kilometrageLocation) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">État du véhicule *</label>
                        <input type="text" name="etat_vehicule_location" class="form-control" 
                               placeholder="Ex: Très bon état, Bon état..." 
                               value="<?= htmlspecialchars($contrat->etatVehiculeLocation) ?>" required>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <h5 class="mb-3 text-primary">Période de Location</h5>
                    <div class="mb-3">
                        <label class="form-label">Date début *</label>
                        <input type="date" name="date_debut" class="form-control" 
                               value="<?= htmlspecialchars($contrat->dateDebut) ?>" required id="dateDebut">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Date fin *</label>
                        <input type="date" name="date_fin" class="form-control" 
                               value="<?= htmlspecialchars($contrat->dateFin) ?>" required id="dateFin">
                    </div>
                </div>

                <div class="col-md-6">
                    <h5 class="mb-3 text-primary">Informations Paiement</h5>
                    <div class="mb-3">
                        <label class="form-label">Mode de paiement *</label>
                        <select name="mode_paiement" class="form-select" required>
                            <option value="Espèce" <?= ($contrat->modePaiement === 'Espèce') ? 'selected' : '' ?>>Espèce</option>
                            <option value="Carte" <?= ($contrat->modePaiement === 'Carte') ? 'selected' : '' ?>>Carte</option>
                            <option value="Virement" <?= ($contrat->modePaiement === 'Virement') ? 'selected' : '' ?>>Virement</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Montant total *</label>
                        <input type="number" step="0.01" name="montant_total" class="form-control" 
                               value="<?= htmlspecialchars($contrat->montantTotal) ?>" required id="montantTotal" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Agent *</label>
                        <select name="num_agent" class="form-select" required>
                            <option value="">Sélectionner un agent</option>
                            <?php foreach ($agents as $agent): ?>
                                <option value="<?= $agent->numAgent ?>" <?= ($contrat->numAgent === $agent->numAgent) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($agent->nom) ?> <?= htmlspecialchars($agent->prenom) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bx bx-check me-1"></i>Enregistrer les Modifications
                </button>
                <a href="dashboard.php?action=contrats" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const vehiculeSelect = document.getElementById('vehiculeSelect');
    const dateDebut = document.getElementById('dateDebut');
    const dateFin = document.getElementById('dateFin');
    const montantTotal = document.getElementById('montantTotal');
    
    function calculerMontant() {
        const selectedOption = vehiculeSelect.selectedOptions[0];
        const prixJournalier = selectedOption ? selectedOption.dataset.prix : null;
        const debut = new Date(dateDebut.value);
        const fin = new Date(dateFin.value);
        
        if (prixJournalier && debut && fin && fin > debut) {
            const jours = (fin - debut) / (1000 * 60 * 60 * 24);
            const total = jours * parseFloat(prixJournalier);
            montantTotal.value = total.toFixed(2);
        }
    }
    
    vehiculeSelect.addEventListener('change', calculerMontant);
    dateDebut.addEventListener('change', calculerMontant);
    dateFin.addEventListener('change', calculerMontant);
    
    // Initialiser le calcul
    calculerMontant();
});
</script>

