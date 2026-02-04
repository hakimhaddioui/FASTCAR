<div class="d-flex justify-content-between align-items-center mb-4">
    <h3><i class="bx bx-line-chart me-2"></i>Analyse & Synthèse</h3>
    <div class="d-flex gap-2">
        <a href="dashboard.php?action=analytics_export_pdf" class="btn btn-outline-success" target="_blank">
            <i class="bx bx-download me-1"></i>Exporter en PDF
        </a>
    </div>
</div>

<!-- Cartes de statistiques -->
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-gradient-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Voitures</h6>
                        <h2 class="mb-0"><?= $stats['total_voitures'] ?></h2>
                        <small class="text-white-50">
                            <i class="bx bx-check-circle me-1"></i>
                            <?= $stats['voitures_disponibles'] ?> disponibles
                        </small>
                    </div>
                    <div class="display-1 opacity-25">
                        <i class="bx bx-car"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-gradient-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Clients</h6>
                        <h2 class="mb-0"><?= $stats['total_clients'] ?></h2>
                        <small class="text-white-50">
                            <i class="bx bx-user me-1"></i>
                            Actifs
                        </small>
                    </div>
                    <div class="display-1 opacity-25">
                        <i class="bx bx-user"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-gradient-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Total Contrats</h6>
                        <h2 class="mb-0"><?= $stats['total_contrats'] ?></h2>
                        <small class="text-white-50">
                            <i class="bx bx-file me-1"></i>
                            <?= $stats['contrats_actifs'] ?> actifs
                        </small>
                    </div>
                    <div class="display-1 opacity-25">
                        <i class="bx bx-file"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="card bg-gradient-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="text-white-50 mb-1">Revenus Totaux</h6>
                        <h2 class="mb-0"><?= number_format($stats['revenus_totaux'], 0, ',', ' ') ?></h2>
                        <small class="text-white-50">
                            <i class="bx bx-money me-1"></i>
                            <?= number_format($stats['revenus_mois'], 0, ',', ' ') ?> ce mois
                        </small>
                    </div>
                    <div class="display-1 opacity-25">
                        <i class="bx bx-money"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Graphiques -->
<div class="row g-4 mb-4">
    <!-- Revenus par mois -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="bx bx-line-chart me-2"></i>Revenus par Mois</h5>
            </div>
            <div class="card-body">
                <canvas id="revenusChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Locations par mois -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bx bx-bar-chart me-2"></i>Locations par Mois</h5>
            </div>
            <div class="card-body">
                <canvas id="locationsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- États des voitures -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bx bx-pie-chart me-2"></i>État des Voitures</h5>
            </div>
            <div class="card-body">
                <canvas id="etatsChart" height="300"></canvas>
            </div>
        </div>
    </div>
    
    <!-- Top Agents -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bx bx-trophy me-2"></i>Top 3 Agents</h5>
            </div>
            <div class="card-body">
                <canvas id="agentsChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Tableaux détaillés -->
<div class="row g-4">
    <!-- Top Clients -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-star me-2"></i>Top 5 Clients</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Client</th>
                                <th>Locations</th>
                                <th>Dépense Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($topClients)): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucun client trouvé</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($topClients as $index => $client): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($client['prenom'] . ' ' . $client['nom']) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($client['cin']) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-primary"><?= $client['total_locations'] ?></span>
                                        </td>
                                        <td>
                                            <strong><?= number_format($client['total_depense'], 2, ',', ' ') ?> MAD</strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Top Voitures -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-car me-2"></i>Top 5 Voitures</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Voiture</th>
                                <th>Locations</th>
                                <th>Revenus</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($locationsParVoiture)): ?>
                                <tr>
                                    <td colspan="3" class="text-center text-muted">Aucune voiture trouvée</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($locationsParVoiture as $voiture): ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($voiture['marque'] . ' ' . $voiture['modele']) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($voiture['matricule']) ?></small>
                                        </td>
                                        <td>
                                            <span class="badge bg-success"><?= $voiture['total_locations'] ?></span>
                                        </td>
                                        <td>
                                            <strong><?= number_format($voiture['revenus_total'], 2, ',', ' ') ?> MAD</strong>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .bg-gradient-success {
        background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    }
    .bg-gradient-info {
        background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
    }
    .bg-gradient-warning {
        background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
    }
    @media print {
        .btn, .no-print { display: none !important; }
    }
</style>

<script>
// Données pour les graphiques
const revenusData = <?= json_encode(array_map(function($r) { return $r['total']; }, $revenusStats)) ?>;
const revenusLabels = <?= json_encode(array_map(function($r) { return $r['mois_short']; }, $revenusStats)) ?>;

const locationsData = <?= json_encode(array_map(function($l) { return $l['total']; }, $locationsParMois)) ?>;
const locationsLabels = <?= json_encode(array_map(function($l) { return $l['mois_short']; }, $locationsParMois)) ?>;

const etatsData = <?= json_encode(array_map(function($e) { return $e['total']; }, $etatsVoitures)) ?>;
const etatsLabels = <?= json_encode(array_map(function($e) { return $e['etat_courant']; }, $etatsVoitures)) ?>;

const agentsData = <?= json_encode(array_map(function($a) { return $a['total_locations']; }, $locationsParAgent)) ?>;
const agentsLabels = <?= json_encode(array_map(function($a) { return $a['prenom'] . ' ' . $a['nom']; }, $locationsParAgent)) ?>;

// Configuration des couleurs
const colors = {
    primary: '#667eea',
    success: '#f5576c',
    info: '#4facfe',
    warning: '#fee140',
    danger: '#fa709a'
};

// Graphique des revenus
const revenusCtx = document.getElementById('revenusChart').getContext('2d');
new Chart(revenusCtx, {
    type: 'line',
    data: {
        labels: revenusLabels,
        datasets: [{
            label: 'Revenus (MAD)',
            data: revenusData,
            borderColor: colors.primary,
            backgroundColor: 'rgba(102, 126, 234, 0.1)',
            tension: 0.4,
            fill: true,
            pointRadius: 5,
            pointHoverRadius: 7
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return value.toLocaleString('fr-FR') + ' MAD';
                    }
                }
            }
        }
    }
});

// Graphique des locations
const locationsCtx = document.getElementById('locationsChart').getContext('2d');
new Chart(locationsCtx, {
    type: 'bar',
    data: {
        labels: locationsLabels,
        datasets: [{
            label: 'Nombre de locations',
            data: locationsData,
            backgroundColor: colors.success,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

// Graphique des états
const etatsCtx = document.getElementById('etatsChart').getContext('2d');
new Chart(etatsCtx, {
    type: 'doughnut',
    data: {
        labels: etatsLabels,
        datasets: [{
            data: etatsData,
            backgroundColor: [
                colors.success,
                colors.warning,
                colors.info
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Graphique des agents
const agentsCtx = document.getElementById('agentsChart').getContext('2d');
new Chart(agentsCtx, {
    type: 'bar',
    data: {
        labels: agentsLabels,
        datasets: [{
            label: 'Nombre de locations',
            data: agentsData,
            backgroundColor: colors.warning,
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        indexAxis: 'y',
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    stepSize: 0.5
                }
            }
        }
    }
});

</script>

