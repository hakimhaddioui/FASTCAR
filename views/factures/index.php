<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-printer me-2"></i>Imprimer une Facture</h3>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($contrats)): ?>
            <div class="text-center py-5">
                <i class="bx bx-file bx-lg text-muted mb-3"></i>
                <h5 class="text-muted">Aucun contrat disponible</h5>
                <p class="text-muted">Créez d'abord un contrat de location pour générer une facture</p>
                <a href="dashboard.php?action=contrats_create" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>Créer un contrat
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>N° Contrat</th>
                            <th>Client</th>
                            <th>Véhicule</th>
                            <th>Période</th>
                            <th>Montant</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($contrats as $contrat): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($contrat['num_contrat']) ?></strong></td>
                            <td><?= htmlspecialchars($contrat['client_nom']) ?> <?= htmlspecialchars($contrat['client_prenom']) ?></td>
                            <td><?= htmlspecialchars($contrat['marque']) ?> <?= htmlspecialchars($contrat['modele']) ?></td>
                            <td>
                                <?= date('d/m/Y', strtotime($contrat['date_debut'])) ?> - 
                                <?= date('d/m/Y', strtotime($contrat['date_fin'])) ?>
                            </td>
                            <td><?= number_format($contrat['montant_total'], 2, ',', ' ') ?> MAD</td>
                            <td>
                                <div class="btn-group" role="group">
                                    <!-- Nouveau bouton Charger PDF -->
                                    <a href="dashboard.php?action=factures_download&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                       class="btn btn-primary btn-sm" title="Télécharger PDF">
                                        <i class="bx bx-download me-1"></i>PDF
                                    </a>
                                    <!-- Bouton Imprimer existant -->
                                    <a href="dashboard.php?action=factures_generate&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                       target="_blank" class="btn btn-success btn-sm" title="Imprimer">
                                        <i class="bx bx-printer me-1"></i>Imprimer
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>