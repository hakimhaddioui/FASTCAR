<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-edit me-2"></i>Modifier la Voiture</h3>
    <a href="index.php?action=voitures" class="btn btn-secondary">
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
                    <div class="mb-3">
                        <label class="form-label">Matricule</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($voiture->matricule) ?>" readonly>
                        <small class="text-muted">Le matricule ne peut pas être modifié</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Marque *</label>
                        <input type="text" name="marque" class="form-control" 
                               placeholder="Ex: Dacia, Renault..." required
                               value="<?= htmlspecialchars($voiture->marque) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Modèle *</label>
                        <input type="text" name="modele" class="form-control" 
                               placeholder="Ex: Sandero, Clio..." required
                               value="<?= htmlspecialchars($voiture->modele) ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Prix Journalier (MAD) *</label>
                        <input type="number" step="0.01" name="prix_journalier" class="form-control" 
                               placeholder="Ex: 150.00" required
                               value="<?= htmlspecialchars($voiture->prixJournalier) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Kilométrage Actuel *</label>
                        <input type="number" name="kilometrage_actuel" class="form-control" 
                               placeholder="Ex: 32850" required
                               value="<?= htmlspecialchars($voiture->kilometrageActuel) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">État *</label>
                        <select name="etat_courant" class="form-select" required>
                            <option value="Disponible" <?= $voiture->etatCourant === 'Disponible' ? 'selected' : '' ?>>Disponible</option>
                            <option value="Louée" <?= $voiture->etatCourant === 'Louée' ? 'selected' : '' ?>>Louée</option>
                            <option value="En maintenance" <?= $voiture->etatCourant === 'En maintenance' ? 'selected' : '' ?>>En maintenance</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bx bx-check me-1"></i>Modifier la Voiture
                </button>
                <a href="dashboard.php?action=voitures" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>