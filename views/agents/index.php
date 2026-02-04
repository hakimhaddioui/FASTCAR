<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-id-card me-2"></i>Gestion des Agents</h3>
    <a href="dashboard.php?action=agents_create" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i>Nouvel Agent
    </a>
</div>

<div class="card">
    <div class="card-body">
        <?php if (empty($agents)): ?>
            <div class="text-center py-5">
                <i class="bx bx-user-circle bx-lg text-muted mb-3"></i>
                <h5 class="text-muted">Aucun agent enregistré</h5>
                <p class="text-muted">Commencez par ajouter votre premier agent</p>
                <a href="dashboard.php?action=agents_create" class="btn btn-primary">
                    <i class="bx bx-plus me-1"></i>Ajouter un agent
                </a>
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Numéro Agent</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($agents as $agent): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($agent->numAgent) ?></strong></td>
                            <td><?= htmlspecialchars($agent->nom) ?></td>
                            <td><?= htmlspecialchars($agent->prenom) ?></td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="dashboard.php?action=agents_edit&num_agent=<?= urlencode($agent->numAgent) ?>" 
                                       class="btn btn-outline-primary">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <a href="dashboard.php?action=agents_delete&num_agent=<?= urlencode($agent->numAgent) ?>" 
                                       class="btn btn-outline-danger" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet agent ?')">
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
