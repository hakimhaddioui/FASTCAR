<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-edit me-2"></i>Modifier l'Agent</h3>
    <a href="index.php?action=agents" class="btn btn-secondary">
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
                        <label class="form-label">Numéro Agent</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($agent->numAgent) ?>" readonly>
                        <small class="text-muted">Le numéro d'agent ne peut pas être modifié</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" class="form-control" 
                               placeholder="Ex: BENSAID" required
                               value="<?= htmlspecialchars($agent->nom) ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Prénom *</label>
                        <input type="text" name="prenom" class="form-control" 
                               placeholder="Ex: Amina" required
                               value="<?= htmlspecialchars($agent->prenom) ?>">
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bx bx-check me-1"></i>Modifier l'Agent
                </button>
                <a href="dashboard.php?action=agents" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>