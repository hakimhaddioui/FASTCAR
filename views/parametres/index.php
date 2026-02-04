<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-cog me-2"></i>Paramètres</h3>
</div>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?php
        $messages = [
            'profil' => 'Profil mis à jour avec succès!',
            'password' => 'Mot de passe modifié avec succès!',
            'apparence' => 'Préférences d\'apparence sauvegardées!',
            'entreprise' => 'Informations de l\'entreprise mises à jour!'
        ];
        echo $messages[$_GET['success']] ?? 'Modifications sauvegardées!';
        ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="row">
    <!-- Menu latéral -->
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-profil-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profil" type="button" role="tab">
                        <i class="bx bx-user me-2"></i>Profil
                    </button>
                    <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab">
                        <i class="bx bx-lock me-2"></i>Mot de passe
                    </button>
                    <button class="nav-link" id="v-pills-entreprise-tab" data-bs-toggle="pill" data-bs-target="#v-pills-entreprise" type="button" role="tab">
                        <i class="bx bx-building me-2"></i>Entreprise
                    </button>
                    <button class="nav-link" id="v-pills-systeme-tab" data-bs-toggle="pill" data-bs-target="#v-pills-systeme" type="button" role="tab">
                        <i class="bx bx-chip me-2"></i>Système
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu -->
    <div class="col-md-9">
        <div class="tab-content" id="v-pills-tabContent">
            
            <!-- Profil -->
            <div class="tab-pane fade show active" id="v-pills-profil" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bx bx-user me-2"></i>Informations du profil</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="dashboard.php?action=parametres_update_profil">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nom</label>
                                        <input type="text" name="nom" class="form-control" 
                                               value="<?= htmlspecialchars($_SESSION['user_nom']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Prénom</label>
                                        <input type="text" name="prenom" class="form-control" 
                                               value="<?= htmlspecialchars($_SESSION['user_prenom']) ?>" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" 
                                       value="<?= htmlspecialchars($_SESSION['user_email']) ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-save me-1"></i>Enregistrer les modifications
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Mot de passe -->
            <div class="tab-pane fade" id="v-pills-password" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0"><i class="bx bx-lock me-2"></i>Changer le mot de passe</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="dashboard.php?action=parametres_update_password">
                            <div class="mb-3">
                                <label class="form-label">Mot de passe actuel</label>
                                <input type="password" name="current_password" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="form-control" required>
                                <small class="text-muted">Minimum 6 caractères</small>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bx bx-refresh me-1"></i>Changer le mot de passe
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Entreprise -->
            <div class="tab-pane fade" id="v-pills-entreprise" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="bx bx-building me-2"></i>Informations de l'entreprise</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="dashboard.php?action=parametres_update_entreprise">
                            <div class="mb-3">
                                <label class="form-label">Nom de l'entreprise</label>
                                <input type="text" name="nom_entreprise" class="form-control" 
                                       value="<?= htmlspecialchars($entrepriseInfo['nom']) ?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adresse</label>
                                <textarea name="adresse" class="form-control" rows="3" required><?= htmlspecialchars($entrepriseInfo['adresse']) ?></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Téléphone</label>
                                        <input type="text" name="telephone" class="form-control" 
                                               value="<?= htmlspecialchars($entrepriseInfo['telephone']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email_entreprise" class="form-control" 
                                               value="<?= htmlspecialchars($entrepriseInfo['email']) ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Registre de Commerce</label>
                                        <input type="text" name="rc" class="form-control" 
                                               value="<?= htmlspecialchars($entrepriseInfo['rc']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Numéro Patente</label>
                                        <input type="text" name="patente" class="form-control" 
                                               value="<?= htmlspecialchars($entrepriseInfo['patente']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Identifiant Fiscal</label>
                                        <input type="text" name="if" class="form-control" 
                                               value="<?= htmlspecialchars($entrepriseInfo['if']) ?>">
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-building me-1"></i>Mettre à jour l'entreprise
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Système -->
            <div class="tab-pane fade" id="v-pills-systeme" role="tabpanel">
                <div class="card">
                    <div class="card-header bg-secondary text-white">
                        <h5 class="mb-0"><i class="bx bx-chip me-2"></i>Paramètres système</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <h6><i class="bx bx-data me-2"></i>Base de données</h6>
                                        <p class="text-muted mb-2">Statut: <span class="badge bg-success">Connecté</span></p>
                                        <small>Dernière sauvegarde: Aujourd'hui</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card bg-light mb-4">
                                    <div class="card-body">
                                        <h6><i class="bx bx-server me-2"></i>Serveur</h6>
                                        <p class="text-muted mb-2">PHP: <?= phpversion() ?></p>
                                        <small>Mémoire: <?= ini_get('memory_limit') ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h6>Actions système</h6>
                            <div class="d-flex gap-2">
                                <button class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-reset me-1"></i>Vider le cache
                                </button>
                                <button class="btn btn-outline-warning btn-sm">
                                    <i class="bx bx-archive me-1"></i>Sauvegarde
                                </button>
                                <button class="btn btn-outline-info btn-sm">
                                    <i class="bx bx-stats me-1"></i>Logs système
                                </button>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bx bx-info-circle me-2"></i>
                            <strong>Version:</strong> FastCar Location v1.0.0
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.theme-card {
    transition: all 0.3s;
    cursor: pointer;
}
.theme-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
.theme-card .form-check-input {
    position: absolute;
    top: 10px;
    left: 10px;
}
.color-preview {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    margin: 0 auto;
    border: 2px solid #dee2e6;
    cursor: pointer;
}
.form-check-input:checked + label .color-preview {
    border-color: #495057;
}
.nav-pills .nav-link {
    text-align: left;
    padding: 12px 15px;
    margin-bottom: 5px;
    border-radius: 8px;
}
.nav-pills .nav-link.active {
    background: #1e3c72;
    color: white;
}
</style>