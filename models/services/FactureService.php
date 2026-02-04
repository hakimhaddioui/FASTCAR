<?php
// Charger l'autoload de Composer depuis la racine du projet
$rootAutoload = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($rootAutoload)) {
    require_once $rootAutoload;
}

class FactureService {
    
    public function genererFacture(array $contrat): string {
        $sanitize = static function ($value): string {
            return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
        };

        $dateFacture = date('d/m/Y');
        $start = isset($contrat['date_debut']) ? strtotime($contrat['date_debut']) : false;
        $end = isset($contrat['date_fin']) ? strtotime($contrat['date_fin']) : false;
        $dureeBrute = ($start && $end) ? (($end - $start) / (60 * 60 * 24)) : 0;
        $dureeLocation = max(1, (int) round($dureeBrute));

        $montantTotal = (float) ($contrat['montant_total'] ?? 0);
        $prixJournalier = isset($contrat['prix_journalier'])
            ? (float) $contrat['prix_journalier']
            : (($dureeBrute > 0) ? $montantTotal / $dureeBrute : ($dureeLocation > 0 ? $montantTotal / $dureeLocation : 0));
        $prixJournalier = $prixJournalier ?: 0;

        $formatter = class_exists('NumberFormatter') ? new \NumberFormatter('fr_FR', \NumberFormatter::SPELLOUT) : null;
        $montantEnLettres = $formatter ? mb_strtoupper($formatter->format($montantTotal)) . ' DIRHAMS' : '';

        $dateDebut = $start ? date('d/m/Y', $start) : '-';
        $dateFin = $end ? date('d/m/Y', $end) : '-';
        $clientNomComplet = trim(($contrat['client_prenom'] ?? '') . ' ' . ($contrat['client_nom'] ?? ''));
        $agentNomComplet = trim(($contrat['agent_prenom'] ?? '') . ' ' . ($contrat['agent_nom'] ?? ''));
        $vehiculeTitre = trim(($contrat['marque'] ?? 'Véhicule') . ' ' . ($contrat['modele'] ?? ''));

        $fraisSupp = '';
        if (!empty($contrat['frais_supplementaires']) && $contrat['frais_supplementaires'] > 0) {
            $fraisSupp = "
                            <tr>
                                <td>
                                    <div style='display: block;'>
                                        <strong>Frais supplémentaires</strong>
                                        <div style='font-size: 11px; color: #666;'>Services additionnels / pénalités</div>
                                    </div>
                                </td>
                                <td style='text-align: right; vertical-align: top;'>"
                                . number_format((float) $contrat['frais_supplementaires'], 2, ',', ' ')
                                . " MAD</td>
                            </tr>";
        }

        return "
        <!DOCTYPE html>
        <html lang='fr'>
        <head>
            <meta charset='UTF-8'>
            <title>Facture - FastCar Location</title>
            <style>
                body {
                    font-family: 'DejaVu Sans', Arial, sans-serif;
                    margin: 0;
                    padding: 15px;
                    color: #333;
                    font-size: 12px;
                    line-height: 1.4;
                }
                .invoice-container {
                    max-width: 100%;
                    margin: 0 auto;
                    border: 2px solid #1e3c72;
                    border-radius: 8px;
                    padding: 20px;
                    background: white;
                }
                .header {
                    text-align: center;
                    margin-bottom: 25px;
                    border-bottom: 2px solid #1e3c72;
                    padding-bottom: 15px;
                }
                .company-name {
                    font-size: 24px;
                    font-weight: bold;
                    color: #1e3c72;
                    margin: 10px 0 5px 0;
                }
                .badge {
                    display: inline-block;
                    padding: 4px 12px;
                    background: #1e3c72;
                    color: white;
                    border-radius: 4px;
                    font-size: 10px;
                    font-weight: bold;
                    text-transform: uppercase;
                    margin-bottom: 8px;
                }
                .company-info {
                    font-size: 11px;
                    color: #666;
                    line-height: 1.3;
                }
                .invoice-info {
                    margin: 20px 0;
                    padding: 15px;
                    background: #f8f9fa;
                    border-radius: 6px;
                    border-left: 4px solid #1e3c72;
                }
                .info-grid {
                    display: block;
                    margin: 15px 0;
                }
                .info-row {
                    display: block;
                    margin-bottom: 8px;
                    page-break-inside: avoid;
                }
                .info-label {
                    font-weight: bold;
                    color: #1e3c72;
                    font-size: 11px;
                    display: inline-block;
                    width: 120px;
                }
                .info-value {
                    display: inline-block;
                    font-weight: 600;
                }
                .section {
                    margin: 25px 0;
                    page-break-inside: avoid;
                }
                .section-title {
                    background: #1e3c72;
                    color: white;
                    padding: 8px 12px;
                    font-size: 14px;
                    font-weight: bold;
                    border-radius: 4px;
                    margin-bottom: 12px;
                }
                .client-grid, .vehicle-grid {
                    display: block;
                    margin: 10px 0;
                }
                .grid-row {
                    display: block;
                    margin-bottom: 6px;
                    padding: 4px 0;
                }
                .grid-label {
                    font-weight: bold;
                    color: #555;
                    font-size: 11px;
                    display: inline-block;
                    width: 140px;
                }
                .grid-value {
                    display: inline-block;
                }
                .vehicle-card {
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    padding: 15px;
                    background: #f8f9fa;
                    margin: 10px 0;
                }
                .vehicle-title {
                    font-size: 14px;
                    font-weight: bold;
                    color: #1e3c72;
                    margin-bottom: 10px;
                }
                .amount-table {
                    width: 100%;
                    border-collapse: collapse;
                    margin: 15px 0;
                    font-size: 11px;
                }
                .amount-table th {
                    background: #1e3c72;
                    color: white;
                    padding: 10px;
                    text-align: left;
                    font-weight: bold;
                    border: 1px solid #1e3c72;
                }
                .amount-table td {
                    padding: 10px;
                    border: 1px solid #ddd;
                    vertical-align: top;
                }
                .amount-desc {
                    display: block;
                }
                .amount-subtitle {
                    font-size: 10px;
                    color: #666;
                    margin-top: 2px;
                }
                .text-right {
                    text-align: right;
                }
                .signature-section {
                    margin: 25px 0;
                    padding: 15px;
                    border: 1px dashed #ddd;
                    border-radius: 6px;
                }
                .signature-grid {
                    display: block;
                }
                .signature-block {
                    display: inline-block;
                    width: 48%;
                    vertical-align: top;
                }
                .signature-label {
                    font-size: 11px;
                    font-weight: bold;
                    color: #666;
                    margin-bottom: 5px;
                }
                .signature-line {
                    border-bottom: 1px solid #ddd;
                    margin: 25px 0 8px 0;
                }
                .footer {
                    margin-top: 30px;
                    padding-top: 15px;
                    border-top: 1px solid #ddd;
                    font-size: 10px;
                    color: #666;
                    text-align: center;
                }
                .footer-grid {
                    display: block;
                    margin: 10px 0;
                }
                .footer-left, .footer-right {
                    display: inline-block;
                    width: 48%;
                    vertical-align: top;
                    text-align: left;
                }
                .footer-right {
                    text-align: right;
                }
            </style>
        </head>
        <body>
            <div class='invoice-container'>
                <!-- En-tête -->
                <div class='header'>
                    <div class='badge'>FACTURE OFFICIELLE</div>
                    <div class='company-name'>FASTCAR LOCATION</div>
                    <div class='company-info'>
                        Bd Mohammed V, Casablanca | Tél : 05 22 33 44 55<br>
                        RC 123456 | Patente 78901234 | IF 98765432
                    </div>
                </div>

                <!-- Informations de la facture -->
                <div class='invoice-info'>
                    <div class='info-grid'>
                        <div class='info-row'>
                            <span class='info-label'>N° Facture:</span>
                            <span class='info-value'>" . $sanitize($contrat['num_contrat'] ?? '') . "</span>
                        </div>
                        <div class='info-row'>
                            <span class='info-label'>Date d'émission:</span>
                            <span class='info-value'>{$dateFacture}</span>
                        </div>
                        <div class='info-row'>
                            <span class='info-label'>Période:</span>
                            <span class='info-value'>{$dateDebut} → {$dateFin}</span>
                        </div>
                        <div class='info-row'>
                            <span class='info-label'>Durée:</span>
                            <span class='info-value'>{$dureeLocation} jour(s)</span>
                        </div>
                    </div>
                </div>

                <!-- Informations client -->
                <div class='section'>
                    <div class='section-title'>INFORMATIONS CLIENT</div>
                    <div class='client-grid'>
                        <div class='grid-row'>
                            <span class='grid-label'>Client:</span>
                            <span class='grid-value'>" . $sanitize($clientNomComplet) . "</span>
                        </div>
                        <div class='grid-row'>
                            <span class='grid-label'>CIN:</span>
                            <span class='grid-value'>" . $sanitize($contrat['cin_client'] ?? 'Non spécifié') . "</span>
                        </div>
                        <div class='grid-row'>
                            <span class='grid-label'>Téléphone:</span>
                            <span class='grid-value'>" . $sanitize($contrat['client_telephone'] ?? 'Non spécifié') . "</span>
                        </div>
                        <div class='grid-row'>
                            <span class='grid-label'>Email:</span>
                            <span class='grid-value'>" . $sanitize($contrat['client_email'] ?? 'Non spécifié') . "</span>
                        </div>
                        <div class='grid-row'>
                            <span class='grid-label'>Adresse:</span>
                            <span class='grid-value'>" . $sanitize($contrat['client_adresse'] ?? 'Non spécifiée') . "</span>
                        </div>
                        <div class='grid-row'>
                            <span class='grid-label'>Mode de paiement:</span>
                            <span class='grid-value'>" . $sanitize($contrat['mode_paiement'] ?? 'Non spécifié') . "</span>
                        </div>
                    </div>
                </div>

                <!-- Détails du véhicule -->
                <div class='section'>
                    <div class='section-title'>DÉTAILS DU VÉHICULE</div>
                    <div class='vehicle-card'>
                        <div class='vehicle-title'>" . $sanitize($vehiculeTitre) . "</div>
                        <div class='vehicle-grid'>
                            <div class='grid-row'>
                                <span class='grid-label'>Matricule:</span>
                                <span class='grid-value'>" . $sanitize($contrat['matricule_vehicule'] ?? '') . "</span>
                            </div>
                            <div class='grid-row'>
                                <span class='grid-label'>Prix journalier:</span>
                                <span class='grid-value'>" . number_format($prixJournalier, 2, ',', ' ') . " MAD</span>
                            </div>
                            <div class='grid-row'>
                                <span class='grid-label'>Kilométrage:</span>
                                <span class='grid-value'>" . number_format((float) ($contrat['kilometrage_location'] ?? 0), 0, '', ' ') . " km</span>
                            </div>
                            <div class='grid-row'>
                                <span class='grid-label'>État à la remise:</span>
                                <span class='grid-value'>" . $sanitize($contrat['etat_vehicule_location'] ?? 'Non spécifié') . "</span>
                            </div>
                            <div class='grid-row'>
                                <span class='grid-label'>Agent responsable:</span>
                                <span class='grid-value'>" . $sanitize($agentNomComplet) . "</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Résumé financier -->
                <div class='section'>
                    <div class='section-title'>RÉSUMÉ FINANCIER</div>
                    <table class='amount-table'>
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class='text-right'>Montant (MAD)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class='amount-desc'>
                                        <strong>Location du véhicule</strong>
                                        <div class='amount-subtitle'>{$dureeLocation} jour(s) × " . number_format($prixJournalier, 2, ',', ' ') . " MAD</div>
                                    </div>
                                </td>
                                <td class='text-right'>" . number_format($montantTotal, 2, ',', ' ') . " MAD</td>
                            </tr>
                            {$fraisSupp}
                        </tbody>
                    </table>

                    <!-- SECTION TOTAL CORRIGÉE -->
                    <div style='
                        background: #1e3c72;
                        color: white;
                        padding: 20px;
                        border-radius: 6px;
                        margin: 20px 0;
                        text-align: center;
                        border: 2px solid #1e3c72;
                    '>
                        <div style='
                            font-size: 11px;
                            opacity: 0.9;
                            margin-bottom: 5px;
                            font-weight: bold;
                            text-transform: uppercase;
                            letter-spacing: 1px;
                        '>TOTAL À PAYER</div>
                        <div style='
                            font-size: 24px;
                            font-weight: bold;
                            margin: 10px 0;
                            color: white;
                        '>" . number_format($montantTotal, 2, ',', ' ') . " MAD</div>
                        <div style='
                            font-size: 12px;
                            opacity: 0.9;
                            margin-top: 8px;
                            font-style: italic;
                            border-top: 1px solid rgba(255,255,255,0.3);
                            padding-top: 8px;
                        '>" . $sanitize($montantEnLettres) . "</div>
                    </div>
                </div>

                <!-- Signatures -->
                <div class='signature-section'>
                    <div class='signature-grid'>
                        <div class='signature-block'>
                            <div class='signature-label'>SIGNATURE AGENT</div>
                            <div class='signature-line'></div>
                            <div style='margin-top: 5px;'>" . $sanitize($agentNomComplet) . "</div>
                        </div>
                        <div class='signature-block'>
                            <div class='signature-label'>SIGNATURE CLIENT</div>
                            <div class='signature-line'></div>
                            <div style='margin-top: 5px;'>" . $sanitize($clientNomComplet) . "</div>
                        </div>
                    </div>
                </div>

                <!-- Pied de page -->
                <div class='footer'>
                    <div class='footer-grid'>
                        <div class='footer-left'>
                            <strong>Merci pour votre confiance.</strong><br>
                            FastCar Location - Partenaire mobilité depuis 2018.
                        </div>
                        <div class='footer-right'>
                            Facture générée automatiquement le " . date('d/m/Y à H:i') . "<br>
                            Document à présenter pour toute réclamation.
                        </div>
                    </div>
                </div>
            </div>
        </body>
        </html>";
    }

    /**
     * Génère un document PDF à partir des données du contrat en utilisant DomPDF.
     */
    public function genererFacturePdf(array $contrat, ?string $nomFichier = null): string {
        try {
            // Vérifier si DomPDF est disponible
            if (!class_exists('\\Dompdf\\Dompdf')) {
                throw new Exception('Dompdf n\'est pas installé. Exécutez: composer require dompdf/dompdf');
            }
            
            $html = $this->genererFacture($contrat);
            
            $dompdf = new \Dompdf\Dompdf();
            
            // Configuration optimisée pour DomPDF
            $options = $dompdf->getOptions();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('defaultFont', 'DejaVu Sans');
            $options->set('isRemoteEnabled', true);
            $options->set('dpi', 150);
            
            $dompdf->setOptions($options);
            $dompdf->loadHtml($html, 'UTF-8');
            $dompdf->setPaper('A4', 'portrait');
            
            $dompdf->render();
            
            return $dompdf->output();
            
        } catch (Exception $e) {
            error_log('Erreur génération PDF facture: ' . $e->getMessage());
            throw new Exception('Erreur lors de la génération du PDF: ' . $e->getMessage());
        }
    }
}
?>