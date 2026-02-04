<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-user me-2"></i>Gestion des Clients</h3>
    <a href="dashboard.php?action=clients_create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i>Nouveau Client
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($clients)): ?>
            <div class="text-center py-5">
                <i class="bx bx-user bx-lg text-muted mb-3"></i>
                <h5 class="text-muted">Aucun client enregistré</h5>
                <p class="text-muted">Commencez par ajouter votre premier client</p>
                <a href="dashboard.php?action=clients_create" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>Ajouter un client
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>CIN</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clients as $client): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($client->cin) ?></strong></td>
                            <td><?= htmlspecialchars($client->nom) ?></td>
                            <td><?= htmlspecialchars($client->prenom) ?></td>
                            <td><?= htmlspecialchars($client->telephone) ?></td>
                            <td><?= htmlspecialchars($client->email) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="dashboard.php?action=clients_edit&cin=<?= urlencode($client->cin) ?>" 
                                       class="btn btn-outline-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="dashboard.php?action=clients_delete&cin=<?= urlencode($client->cin) ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce client ?')">
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
