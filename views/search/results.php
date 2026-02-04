<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-search me-2"></i>Résultats de Recherche</h3>
    <a href="dashboard.php" class="btn btn-secondary">
        <i class="bx bx-arrow-back me-1"></i>Retour
    </a>
</div>

<!-- Barre de recherche -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="dashboard.php" class="d-flex gap-2">
            <input type="hidden" name="action" value="search">
            <div class="flex-grow-1">
                <input type="text" name="q" class="form-control form-control-lg" 
                       placeholder="Rechercher voitures, clients, agents, contrats..." 
                       value="<?= htmlspecialchars($query) ?>">
            </div>
            <div>
                <select name="type" class="form-select form-select-lg">
                    <option value="all" <?= $type === 'all' ? 'selected' : '' ?>>Tout</option>
                    <option value="voitures" <?= $type === 'voitures' ? 'selected' : '' ?>>Voitures</option>
                    <option value="clients" <?= $type === 'clients' ? 'selected' : '' ?>>Clients</option>
                    <option value="agents" <?= $type === 'agents' ? 'selected' : '' ?>>Agents</option>
                    <option value="contrats" <?= $type === 'contrats' ? 'selected' : '' ?>>Contrats</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bx bx-search me-1"></i>Rechercher
            </button>
        </form>
    </div>
</div>

<?php if (empty($query)): ?>
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bx bx-search bx-lg text-muted mb-3"></i>
            <h5 class="text-muted">Entrez un terme de recherche</h5>
            <p class="text-muted">Recherchez parmi les voitures, clients, agents et contrats</p>
        </div>
    </div>
<?php else: ?>
    <?php $totalResults = count($voitures) + count($clients) + count($agents) + count($contrats); ?>
    
    <div class="alert alert-info">
        <i class="bx bx-info-circle me-2"></i>
        <strong><?= $totalResults ?></strong> résultat(s) trouvé(s) pour "<strong><?= htmlspecialchars($query) ?></strong>"
    </div>

    <!-- Voitures -->
    <?php if (!empty($voitures) && ($type === 'all' || $type === 'voitures')): ?>
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bx bx-car me-2"></i>Voitures (<?= count($voitures) ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Matricule</th>
                                <th>Marque</th>
                                <th>Modèle</th>
                                <th>Prix Journalier</th>
                                <th>État</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($voitures as $voiture): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($voiture['matricule']) ?></strong></td>
                                    <td><?= htmlspecialchars($voiture['marque']) ?></td>
                                    <td><?= htmlspecialchars($voiture['modele']) ?></td>
                                    <td><?= number_format($voiture['prix_journalier'], 2, ',', ' ') ?> MAD</td>
                                    <td>
                                        <span class="badge bg-<?= 
                                            $voiture['etat_courant'] === 'Disponible' ? 'success' : 
                                            ($voiture['etat_courant'] === 'Louée' ? 'warning' : 'secondary') 
                                        ?>">
                                            <?= htmlspecialchars($voiture['etat_courant']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a href="dashboard.php?action=voitures_edit&matricule=<?= urlencode($voiture['matricule']) ?>" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Clients -->
    <?php if (!empty($clients) && ($type === 'all' || $type === 'clients')): ?>
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bx bx-user me-2"></i>Clients (<?= count($clients) ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
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
                                    <td><strong><?= htmlspecialchars($client['cin']) ?></strong></td>
                                    <td><?= htmlspecialchars($client['nom']) ?></td>
                                    <td><?= htmlspecialchars($client['prenom']) ?></td>
                                    <td><?= htmlspecialchars($client['telephone']) ?></td>
                                    <td><?= htmlspecialchars($client['email']) ?></td>
                                    <td>
                                        <a href="dashboard.php?action=clients_edit&cin=<?= urlencode($client['cin']) ?>" 
                                           class="btn btn-sm btn-outline-success">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Agents -->
    <?php if (!empty($agents) && ($type === 'all' || $type === 'agents')): ?>
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bx bx-id-card me-2"></i>Agents (<?= count($agents) ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N° Agent</th>
                                <th>Nom</th>
                                <th>Prénom</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($agents as $agent): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($agent['num_agent']) ?></strong></td>
                                    <td><?= htmlspecialchars($agent['nom']) ?></td>
                                    <td><?= htmlspecialchars($agent['prenom']) ?></td>
                                    <td>
                                        <a href="dashboard.php?action=agents_edit&num_agent=<?= urlencode($agent['num_agent']) ?>" 
                                           class="btn btn-sm btn-outline-info">
                                            <i class="bx bx-edit"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Contrats -->
    <?php if (!empty($contrats) && ($type === 'all' || $type === 'contrats')): ?>
        <div class="card mb-4">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bx bx-file me-2"></i>Contrats (<?= count($contrats) ?>)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>N° Contrat</th>
                                <th>Client</th>
                                <th>Voiture</th>
                                <th>Dates</th>
                                <th>Montant</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($contrats as $contrat): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($contrat['num_contrat']) ?></strong></td>
                                    <td><?= htmlspecialchars($contrat['client_prenom'] . ' ' . $contrat['client_nom']) ?></td>
                                    <td><?= htmlspecialchars($contrat['marque'] . ' ' . $contrat['modele']) ?></td>
                                    <td>
                                        <small>
                                            <?= date('d/m/Y', strtotime($contrat['date_debut'])) ?><br>
                                            <?= date('d/m/Y', strtotime($contrat['date_fin'])) ?>
                                        </small>
                                    </td>
                                    <td><strong><?= number_format($contrat['montant_total'], 2, ',', ' ') ?> MAD</strong></td>
                                    <td>
                                        <a href="dashboard.php?action=contrats_show&num_contrat=<?= urlencode($contrat['num_contrat']) ?>" 
                                           class="btn btn-sm btn-outline-warning">
                                            <i class="bx bx-show"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($totalResults === 0): ?>
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="bx bx-search bx-lg text-muted mb-3"></i>
                <h5 class="text-muted">Aucun résultat trouvé</h5>
                <p class="text-muted">Essayez avec d'autres mots-clés</p>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>

