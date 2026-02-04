<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-car me-2"></i>Gestion des Voitures</h3>
    <a href="dashboard.php?action=voitures_create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i>Nouvelle Voiture
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($voitures)): ?>
            <div class="text-center py-5">
                <i class="bx bx-car bx-lg text-muted mb-3"></i>
                <h5 class="text-muted">Aucune voiture enregistrée</h5>
                <p class="text-muted">Commencez par ajouter votre première voiture</p>
                <a href="dashboard.php?action=voitures_create" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>Ajouter une voiture
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Matricule</th>
                            <th>Marque</th>
                            <th>Modèle</th>
                            <th>Prix Journalier</th>
                            <th>Kilométrage</th>
                            <th>État</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($voitures as $voiture): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($voiture->matricule) ?></strong></td>
                            <td><?= htmlspecialchars($voiture->marque) ?></td>
                            <td><?= htmlspecialchars($voiture->modele) ?></td>
                            <td><?= number_format($voiture->prixJournalier, 2, ',', ' ') ?> MAD</td>
                            <td><?= number_format($voiture->kilometrageActuel, 0, '', ' ') ?> km</td>
                            <td>
                                <span class="badge bg-<?= 
                                    $voiture->etatCourant === 'Disponible' ? 'success' : 
                                    ($voiture->etatCourant === 'Louée' ? 'warning' : 'secondary') 
                                ?>">
                                    <?= $voiture->etatCourant ?>
                                </span>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="dashboard.php?action=voitures_edit&matricule=<?= urlencode($voiture->matricule) ?>" 
                                       class="btn btn-outline-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="dashboard.php?action=voitures_delete&matricule=<?= urlencode($voiture->matricule) ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette voiture ?')">
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