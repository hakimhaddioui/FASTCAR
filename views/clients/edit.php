<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-edit me-2"></i>Modifier le Client</h3>
    <a href="index.php?action=clients" class="btn btn-secondary">
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
                        <label class="form-label">CIN</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($client->cin) ?>" readonly>
                        <small class="text-muted">Le CIN ne peut pas être modifié</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Nom *</label>
                        <input type="text" name="nom" class="form-control" 
                               placeholder="Ex: EL FADLI" required
                               value="<?= htmlspecialchars($client->nom) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Prénom *</label>
                        <input type="text" name="prenom" class="form-control" 
                               placeholder="Ex: Karim" required
                               value="<?= htmlspecialchars($client->prenom) ?>">
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Téléphone *</label>
                        <input type="text" name="telephone" class="form-control" 
                               placeholder="Ex: 06 12 34 56 78" required
                               value="<?= htmlspecialchars($client->telephone) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" 
                               placeholder="Ex: karim@email.com"
                               value="<?= htmlspecialchars($client->email) ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Adresse *</label>
                        <textarea name="adresse" class="form-control" rows="3" 
                                  placeholder="Ex: 24, Av. Hassan II, Casablanca" required><?= htmlspecialchars($client->adresse) ?></textarea>
                    </div>
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success btn-lg">
                    <i class="bx bx-check me-1"></i>Modifier le Client
                </button>
                <a href="dashboard.php?action=clients" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>