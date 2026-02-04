<?php
require_once 'config/database.php';

class AnalyticsController {
    private $pdo;
    
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    
    public function index() {
        $stats = $this->getStats();
        $revenusStats = $this->getRevenusStats();
        $locationsParMois = $this->getLocationsParMois();
        $locationsParAgent = $this->getLocationsParAgent();
        $locationsParVoiture = $this->getLocationsParVoiture();
        $etatsVoitures = $this->getEtatsVoitures();
        $topClients = $this->getTopClients();
        
        ob_start();
        require 'views/analytics/index.php';
        return ob_get_clean();
    }
    
    private function getStats(): array {
        $stats = [];
        
        // Nombre total de voitures
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM voitures");
        $stats['total_voitures'] = $stmt->fetch()['total'];
        
        // Nombre de voitures disponibles
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM voitures WHERE etat_courant = 'Disponible'");
        $stats['voitures_disponibles'] = $stmt->fetch()['total'];
        
        // Nombre de voitures louées
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM voitures WHERE etat_courant = 'Louée'");
        $stats['voitures_louees'] = $stmt->fetch()['total'];
        
        // Nombre total de clients
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM clients");
        $stats['total_clients'] = $stmt->fetch()['total'];
        
        // Nombre total d'agents
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM agents");
        $stats['total_agents'] = $stmt->fetch()['total'];
        
        // Nombre total de contrats
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM contrats");
        $stats['total_contrats'] = $stmt->fetch()['total'];
        
        // Contrats actifs (en cours)
        $today = date('Y-m-d');
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM contrats WHERE date_debut <= ? AND date_fin >= ?");
        $stmt->execute([$today, $today]);
        $stats['contrats_actifs'] = $stmt->fetch()['total'];
        
        // Revenus totaux
        $stmt = $this->pdo->query("SELECT COALESCE(SUM(montant_total), 0) as total FROM contrats");
        $stats['revenus_totaux'] = $stmt->fetch()['total'];
        
        // Revenus du mois en cours
        $firstDay = date('Y-m-01');
        $lastDay = date('Y-m-t');
        $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(montant_total), 0) as total FROM contrats WHERE date_debut BETWEEN ? AND ?");
        $stmt->execute([$firstDay, $lastDay]);
        $stats['revenus_mois'] = $stmt->fetch()['total'];
        
        return $stats;
    }
    
    private function getRevenusStats(): array {
        $revenus = [];
        
        // Revenus des 12 derniers mois
        for ($i = 11; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $firstDay = date('Y-m-01', strtotime("-$i months"));
            $lastDay = date('Y-m-t', strtotime("-$i months"));
            
            $stmt = $this->pdo->prepare("SELECT COALESCE(SUM(montant_total), 0) as total FROM contrats WHERE date_debut BETWEEN ? AND ?");
            $stmt->execute([$firstDay, $lastDay]);
            $result = $stmt->fetch();
            
            $revenus[] = [
                'mois' => date('M Y', strtotime("-$i months")),
                'mois_short' => date('M', strtotime("-$i months")),
                'total' => floatval($result['total'])
            ];
        }
        
        return $revenus;
    }
    
    private function getLocationsParMois(): array {
        $locations = [];
        
        // Locations des 12 derniers mois
        for ($i = 11; $i >= 0; $i--) {
            $date = date('Y-m', strtotime("-$i months"));
            $firstDay = date('Y-m-01', strtotime("-$i months"));
            $lastDay = date('Y-m-t', strtotime("-$i months"));
            
            $stmt = $this->pdo->prepare("SELECT COUNT(*) as total FROM contrats WHERE date_debut BETWEEN ? AND ?");
            $stmt->execute([$firstDay, $lastDay]);
            $result = $stmt->fetch();
            
            $locations[] = [
                'mois' => date('M Y', strtotime("-$i months")),
                'mois_short' => date('M', strtotime("-$i months")),
                'total' => intval($result['total'])
            ];
        }
        
        return $locations;
    }
    
    private function getLocationsParAgent(): array {
        $sql = "SELECT a.num_agent, a.nom, a.prenom, COUNT(c.num_contrat) as total_locations,
                COALESCE(SUM(c.montant_total), 0) as revenus_total
                FROM agents a
                LEFT JOIN contrats c ON a.num_agent = c.num_agent
                GROUP BY a.num_agent, a.nom, a.prenom
                ORDER BY total_locations DESC
                LIMIT 3";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    private function getLocationsParVoiture(): array {
        $sql = "SELECT v.matricule, v.marque, v.modele, COUNT(c.num_contrat) as total_locations,
                COALESCE(SUM(c.montant_total), 0) as revenus_total
                FROM voitures v
                LEFT JOIN contrats c ON v.matricule = c.matricule_vehicule
                GROUP BY v.matricule, v.marque, v.modele
                ORDER BY total_locations DESC
                LIMIT 5";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    private function getEtatsVoitures(): array {
        $sql = "SELECT etat_courant, COUNT(*) as total 
                FROM voitures 
                GROUP BY etat_courant";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    private function getTopClients(): array {
        $sql = "SELECT c.cin, c.nom, c.prenom, COUNT(ct.num_contrat) as total_locations,
                COALESCE(SUM(ct.montant_total), 0) as total_depense
                FROM clients c
                LEFT JOIN contrats ct ON c.cin = ct.cin_client
                GROUP BY c.cin, c.nom, c.prenom
                HAVING total_locations > 0
                ORDER BY total_locations DESC, total_depense DESC
                LIMIT 5";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll();
    }
    
    public function getStatsJSON(): void {
        header('Content-Type: application/json');
        echo json_encode([
            'stats' => $this->getStats(),
            'revenus' => $this->getRevenusStats(),
            'locations_mois' => $this->getLocationsParMois(),
            'locations_agent' => $this->getLocationsParAgent(),
            'locations_voiture' => $this->getLocationsParVoiture(),
            'etats_voitures' => $this->getEtatsVoitures(),
            'top_clients' => $this->getTopClients()
        ]);
    }
    
    public function exportPDF(): void {
    require_once __DIR__ . '/../vendor/autoload.php';

    $stats = $this->getStats();
    $revenusStats = $this->getRevenusStats();
    $locationsParMois = $this->getLocationsParMois();
    $locationsParAgent = $this->getLocationsParAgent();
    $locationsParVoiture = $this->getLocationsParVoiture();
    $etatsVoitures = $this->getEtatsVoitures();
    $topClients = $this->getTopClients();

    try {
        $html = $this->generateAnalyticsHTML(
            $stats,
            $revenusStats,
            $locationsParMois,
            $locationsParAgent,
            $locationsParVoiture,
            $etatsVoitures,
            $topClients
        );

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'Dashboard_FastCar_' . date('Y-m-d') . '.pdf';
        $dompdf->stream($filename, ['Attachment' => true]);

        } catch (Exception $e) {
            error_log('Erreur génération PDF Dashboard: ' . $e->getMessage());
            die('Erreur lors de la génération du PDF: ' . $e->getMessage());
        }
    }

    
    private function generateAnalyticsHTML($stats, $revenusStats, $locationsParMois, $locationsParAgent, $locationsParVoiture, $etatsVoitures, $topClients): string {
    $html = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - FastCar Location</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1e3c72; padding-bottom: 15px; }
        .header h1 { color: #1e3c72; margin: 0; font-size: 24px; }
        .header p { color: #666; margin: 5px 0; font-size: 14px; }
        .stats-grid { display: table; width: 100%; margin-bottom: 20px; border-spacing: 10px; }
        .stat-card { display: table-cell; width: 25%; color: white; padding: 15px; border-radius: 5px; text-align: center; vertical-align: top; }
        .stat-card h3 { margin: 0 0 8px 0; font-size: 12px; opacity: 0.9; }
        .stat-card .value { font-size: 24px; font-weight: bold; margin: 0; }
        .stat-card small { font-size: 11px; opacity: 0.9; }
        .section { margin-bottom: 20px; page-break-inside: avoid; }
        .section-title { background: #1e3c72; color: white; padding: 10px; margin-bottom: 0; font-size: 16px; font-weight: bold; }
        .section-content { border: 1px solid #ddd; padding: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 8px; font-size: 12px; }
        table th { background: #f5f5f5; padding: 8px; text-align: left; border-bottom: 1px solid #ddd; font-weight: bold; }
        table td { padding: 8px; border-bottom: 1px solid #eee; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .badge { display: inline-block; padding: 2px 6px; border-radius: 3px; background: #1e3c72; color: white; font-size: 10px; }
        .footer { margin-top: 30px; padding-top: 15px; border-top: 1px solid #ddd; text-align: center; color: #666; font-size: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>FASTCAR LOCATION</h1>
        <p>Rapport d\'Analyse & Synthèse</p>
        <p>Généré le ' . date('d/m/Y à H:i') . '</p>
    </div>
    
    <div class="stats-grid">
        <div class="stat-card" style="background: #667eea;">
            <h3>Total Voitures</h3>
            <p class="value">' . $stats['total_voitures'] . '</p>
            <small>' . $stats['voitures_disponibles'] . ' disponibles</small>
        </div>
        <div class="stat-card" style="background: #f5576c;">
            <h3>Total Clients</h3>
            <p class="value">' . $stats['total_clients'] . '</p>
        </div>
        <div class="stat-card" style="background: #4facfe;">
            <h3>Total Contrats</h3>
            <p class="value">' . $stats['total_contrats'] . '</p>
            <small>' . $stats['contrats_actifs'] . ' actifs</small>
        </div>
        <div class="stat-card" style="background: #fa709a;">
            <h3>Revenus Totaux</h3>
            <p class="value">' . number_format($stats['revenus_totaux'], 0, ',', ' ') . ' MAD</p>
            <small>' . number_format($stats['revenus_mois'], 0, ',', ' ') . ' ce mois</small>
        </div>
    </div>';

    // Revenus par mois
    $html .= '<div class="section">
        <div class="section-title">Revenus par Mois (12 derniers mois)</div>
        <div class="section-content">
            <table><thead><tr><th>Mois</th><th class="text-right">Montant (MAD)</th></tr></thead><tbody>';
    foreach ($revenusStats as $revenu) {
        $html .= '<tr><td>' . $revenu['mois'] . '</td><td class="text-right">' . number_format($revenu['total'], 2, ',', ' ') . ' MAD</td></tr>';
    }
    $html .= '</tbody></table></div></div>';

    // Locations par mois
    $html .= '<div class="section">
        <div class="section-title">Locations par Mois (12 derniers mois)</div>
        <div class="section-content">
            <table><thead><tr><th>Mois</th><th class="text-right">Nombre</th></tr></thead><tbody>';
    foreach ($locationsParMois as $location) {
        $html .= '<tr><td>' . $location['mois'] . '</td><td class="text-right">' . $location['total'] . '</td></tr>';
    }
    $html .= '</tbody></table></div></div>';

    // État des voitures
    $html .= '<div class="section">
        <div class="section-title">État des Voitures</div>
        <div class="section-content">
            <table><thead><tr><th>État</th><th class="text-right">Nombre</th></tr></thead><tbody>';
    foreach ($etatsVoitures as $etat) {
        $html .= '<tr><td>' . $etat['etat_courant'] . '</td><td class="text-right">' . $etat['total'] . '</td></tr>';
    }
    $html .= '</tbody></table></div></div>';

    // Top clients
    $html .= '<div class="section">
        <div class="section-title">Top 5 Clients</div>
        <div class="section-content">
            <table><thead><tr><th>Client</th><th>CIN</th><th class="text-right">Locations</th><th class="text-right">Dépense Total</th></tr></thead><tbody>';
    if (empty($topClients)) {
        $html .= '<tr><td colspan="4" class="text-center">Aucun client trouvé</td></tr>';
    } else {
        foreach ($topClients as $client) {
            $html .= '<tr>
                <td><strong>' . $client['prenom'] . ' ' . $client['nom'] . '</strong></td>
                <td>' . $client['cin'] . '</td>
                <td class="text-right"><span class="badge">' . $client['total_locations'] . '</span></td>
                <td class="text-right"><strong>' . number_format($client['total_depense'], 2, ',', ' ') . ' MAD</strong></td>
            </tr>';
        }
    }
    $html .= '</tbody></table></div></div>';

    // Top voitures
    $html .= '<div class="section">
        <div class="section-title">Top 5 Voitures</div>
        <div class="section-content">
            <table><thead><tr><th>Voiture</th><th>Matricule</th><th class="text-right">Locations</th><th class="text-right">Revenus</th></tr></thead><tbody>';
    if (empty($locationsParVoiture)) {
        $html .= '<tr><td colspan="4" class="text-center">Aucune voiture trouvée</td></tr>';
    } else {
        foreach ($locationsParVoiture as $voiture) {
            $html .= '<tr>
                <td><strong>' . $voiture['marque'] . ' ' . $voiture['modele'] . '</strong></td>
                <td>' . $voiture['matricule'] . '</td>
                <td class="text-right"><span class="badge">' . $voiture['total_locations'] . '</span></td>
                <td class="text-right"><strong>' . number_format($voiture['revenus_total'], 2, ',', ' ') . ' MAD</strong></td>
            </tr>';
        }
    }
    $html .= '</tbody></table></div></div>';

    // Top agents
    $html .= '<div class="section">
        <div class="section-title">Top 3 Agents</div>
        <div class="section-content">
            <table><thead><tr><th>Agent</th><th>Numéro</th><th class="text-right">Locations</th><th class="text-right">Revenus</th></tr></thead><tbody>';
    if (empty($locationsParAgent)) {
        $html .= '<tr><td colspan="4" class="text-center">Aucun agent trouvé</td></tr>';
    } else {
        foreach ($locationsParAgent as $agent) {
            $html .= '<tr>
                <td><strong>' . $agent['prenom'] . ' ' . $agent['nom'] . '</strong></td>
                <td>' . $agent['num_agent'] . '</td>
                <td class="text-right"><span class="badge">' . $agent['total_locations'] . '</span></td>
                <td class="text-right"><strong>' . number_format($agent['revenus_total'], 2, ',', ' ') . ' MAD</strong></td>
            </tr>';
        }
    }
    $html .= '</tbody></table></div></div>';

    // Footer
    $html .= '<div class="footer">
        <p>FastCar Location - Rapport généré automatiquement</p>
        <p>Bd Mohammed V, Casablanca | Tél : 05 22 33 44 55</p>
    </div>
</body>
</html>';
    
    return $html;
}
}

