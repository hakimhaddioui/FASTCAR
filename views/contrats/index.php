<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-file me-2"></i>Gestion des Contrats</h3>
    <a href="dashboard.php?action=contrats_create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i>Nouveau Contrat
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($contrats)): ?>
            <div class="text-center py-5">
                <i class="bx bx-file bx-lg text-muted mb-3"></i>
                <h5 class="text-muted">Aucun contrat enregistré</h5>
                <p class="text-muted">Commencez par créer votre premier contrat de location</p>
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
                            <th>Agent</th>
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
                            <td><?= htmlspecialchars($contrat['agent_nom']) ?> <?= htmlspecialchars($contrat['agent_prenom']) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="dashboard.php?action=contrats_show&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                       class="btn btn-outline-info" title="Voir">
                                        <i class="bx bx-show"></i>
                                    </a>
                                    <a href="dashboard.php?action=contrats_edit&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                       class="btn btn-outline-primary" title="Modifier">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="dashboard.php?action=factures_generate&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                       target="_blank" class="btn btn-outline-success" title="Facture">
                                        <i class="bx bx-printer"></i>
                                    </a>
                                    <a href="dashboard.php?action=contrats_delete&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce contrat ?')" title="Supprimer">
                                        <i class="bx bx-trash"></i>
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