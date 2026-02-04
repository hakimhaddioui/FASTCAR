<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facture - FastCar Location</title>
    <style>
        :root {
            --primary-color: #1e3c72;
            --primary-light: #2a5298;
            --accent-color: #f59f00;
            --border-color: #e6ebf1;
            --text-muted: #6c757d;
            --bg-soft: #f5f7fb;
        }

        @page {
            margin: 18mm 18mm 20mm 18mm;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', system-ui, -apple-system, BlinkMacSystemFont, sans-serif;
            margin: 0;
            padding: 30px 20px 60px;
            background: var(--bg-soft);
            color: #1f2933;
        }

        .invoice-wrapper {
            max-width: 900px;
            margin: 0 auto;
        }

        .invoice-card {
            background: #fff;
            border-radius: 16px;
            border: 1px solid var(--border-color);
            box-shadow: 0 20px 40px rgba(30, 60, 114, 0.08);
            overflow: hidden;
        }

        .invoice {
            padding: 48px;
        }

        .invoice__header {
            display: flex;
            justify-content: space-between;
            gap: 32px;
            margin-bottom: 40px;
        }

        .brand {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .brand__title {
            font-size: 26px;
            font-weight: 700;
            color: var(--primary-color);
            letter-spacing: 0.08em;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            text-transform: uppercase;
            background: rgba(30, 60, 114, 0.08);
            color: var(--primary-color);
            padding: 6px 14px;
            border-radius: 999px;
            letter-spacing: 0.18em;
            font-weight: 600;
        }

        .company-info,
        .client-info,
        .contract-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            font-size: 14px;
        }

        .info-block {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-block__label {
            font-size: 12px;
            font-weight: 600;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--text-muted);
        }

        .info-block__value {
            font-size: 15px;
            font-weight: 600;
            color: #1f2933;
        }

        .section {
            margin-bottom: 32px;
            page-break-inside: avoid;
        }

        .section__title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 20px;
        }

        .section__title::before {
            content: '';
            width: 6px;
            height: 22px;
            border-radius: 4px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
        }

        .vehicle-card {
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 20px;
            background: linear-gradient(135deg, rgba(30, 60, 114, 0.04), rgba(42, 82, 152, 0.08));
        }

        .vehicle-card__title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 14px;
            color: var(--primary-color);
        }

        .vehicle-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 12px;
            font-size: 14px;
        }

        .amount-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            overflow: hidden;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .amount-table thead {
            background: var(--primary-color);
            color: #fff;
        }

        .amount-table th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            text-align: left;
            padding: 14px 20px;
        }

        .amount-table td {
            padding: 16px 20px;
            border-bottom: 1px solid var(--border-color);
            font-size: 15px;
        }

        .amount-table tr:last-child td {
            border-bottom: none;
        }

        .amount-table__line {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .amount-table__subtitle {
            font-size: 12px;
            color: var(--text-muted);
        }

        .total-amount {
            margin-top: 24px;
            padding: 26px 28px;
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: #fff;
            border-radius: 14px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 22px;
            font-weight: 700;
        }

        .total-amount small {
            font-size: 12px;
            font-weight: 500;
            letter-spacing: 0.1em;
            opacity: 0.8;
        }

        .footer {
            margin-top: 48px;
            display: flex;
            justify-content: space-between;
            gap: 28px;
            font-size: 13px;
            color: var(--text-muted);
            border-top: 1px solid var(--border-color);
            padding-top: 22px;
        }

        .signature {
            margin-top: 28px;
            border: 1px dashed var(--border-color);
            border-radius: 12px;
            padding: 18px;
            font-size: 13px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
        }

        .signature__block {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .signature__label {
            font-size: 11px;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 600;
            color: var(--text-muted);
        }

        .signature__line {
            height: 1px;
            background: var(--border-color);
            position: relative;
        }

        .signature__line::after {
            content: attr(data-placeholder);
            position: absolute;
            top: -10px;
            right: 0;
            font-size: 11px;
            color: #ced4da;
        }

        .actions-bar {
            margin-top: 32px;
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .btn {
            border: none;
            border-radius: 999px;
            padding: 12px 26px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .btn i {
            font-style: normal;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-light));
            color: #fff;
            box-shadow: 0 12px 20px rgba(30, 60, 114, 0.25);
        }

        .btn-outline {
            background: #fff;
            color: var(--primary-color);
            border: 1px solid var(--primary-color);
        }

        .btn-secondary {
            background: #6c757d;
            color: #fff;
        }

        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 26px rgba(30, 60, 114, 0.18);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: wait;
            transform: none;
            box-shadow: none;
        }

        .no-print {
            margin-top: 18px;
        }

        .sub-info {
            font-size: 13px;
            color: var(--text-muted);
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }
            .invoice-card {
                border: none;
                box-shadow: none;
                border-radius: 0;
            }
            .invoice {
                padding: 12mm 10mm 14mm;
            }
            .no-print {
                display: none !important;
            }
        }

        @media (max-width: 700px) {
            body {
                padding: 12px;
            }
            .invoice {
                padding: 28px 22px;
            }
            .invoice__header {
                flex-direction: column;
                align-items: flex-start;
                gap: 16px;
            }
            .total-amount {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
        }
    </style>
</head>
<body>
    <?php
    $dateFacture = date('d/m/Y');
    $start = isset($contrat['date_debut']) ? strtotime($contrat['date_debut']) : false;
    $end = isset($contrat['date_fin']) ? strtotime($contrat['date_fin']) : false;
    $dureeBrute = ($start && $end) ? (($end - $start) / (60 * 60 * 24)) : 0;
    $dureeLocation = max(1, (int) round($dureeBrute));
    $montantTotal = $contrat['montant_total'] ?? 0;
    $prixJournalier = $contrat['prix_journalier'] ?? ($dureeBrute > 0 ? ($montantTotal / $dureeBrute) : ($montantTotal / $dureeLocation));
    $prixJournalier = $prixJournalier ?: 0;
    $montantEnLettres = '';
    if (class_exists('NumberFormatter')) {
        $formatter = new NumberFormatter('fr_FR', NumberFormatter::SPELLOUT);
        $montantEnLettres = strtoupper($formatter->format($montantTotal)) . ' dirhams';
    }
    ?>

    <div class="invoice-wrapper">
        <div id="facture-content" class="invoice-card">
            <div class="invoice">
                <div class="invoice__header">
                    <div class="brand">
                        <span class="badge">Facture officielle</span>
                        <span class="brand__title">FASTCAR LOCATION</span>
                        <div class="sub-info">
                            <span>Bd Mohammed V, Casablanca</span>
                            <span>Tél : 05 22 33 44 55</span>
                            <span>RC 123456 &nbsp;|&nbsp; Patente 78901234 &nbsp;|&nbsp; IF 98765432</span>
                        </div>
                    </div>
                    <div class="contract-info">
                        <div class="info-block">
                            <span class="info-block__label">N° de facture</span>
                            <span class="info-block__value"><?= htmlspecialchars($contrat['num_contrat'] ?? '') ?></span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Date d'émission</span>
                            <span class="info-block__value"><?= $dateFacture ?></span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Période</span>
                            <span class="info-block__value">
                                <?= $start ? date('d/m/Y', $start) : '-' ?> → <?= $end ? date('d/m/Y', $end) : '-' ?>
                            </span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Durée</span>
                            <span class="info-block__value"><?= $dureeLocation ?> jour(s)</span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section__title">Informations Client</div>
                    <div class="client-info">
                        <div class="info-block">
                            <span class="info-block__label">Client</span>
                            <span class="info-block__value">
                                <?= htmlspecialchars(trim(($contrat['client_prenom'] ?? '') . ' ' . ($contrat['client_nom'] ?? ''))) ?>
                            </span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">CIN</span>
                            <span class="info-block__value"><?= htmlspecialchars($contrat['cin_client'] ?? 'Non spécifié') ?></span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Téléphone</span>
                            <span class="info-block__value"><?= htmlspecialchars($contrat['client_telephone'] ?? 'Non spécifié') ?></span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Email</span>
                            <span class="info-block__value"><?= htmlspecialchars($contrat['client_email'] ?? 'Non spécifié') ?></span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Adresse</span>
                            <span class="info-block__value"><?= htmlspecialchars($contrat['client_adresse'] ?? 'Non spécifiée') ?></span>
                        </div>
                        <div class="info-block">
                            <span class="info-block__label">Mode de paiement</span>
                            <span class="info-block__value"><?= htmlspecialchars($contrat['mode_paiement'] ?? 'Non spécifié') ?></span>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section__title">Détails du Véhicule</div>
                    <div class="vehicle-card">
                        <div class="vehicle-card__title">
                            <?= htmlspecialchars(($contrat['marque'] ?? 'Véhicule') . ' ' . ($contrat['modele'] ?? '')) ?>
                        </div>
                        <div class="vehicle-grid">
                            <div class="info-block">
                                <span class="info-block__label">Matricule</span>
                                <span class="info-block__value"><?= htmlspecialchars($contrat['matricule_vehicule'] ?? '') ?></span>
                            </div>
                            <div class="info-block">
                                <span class="info-block__label">Prix journalier</span>
                                <span class="info-block__value"><?= number_format($prixJournalier, 2, ',', ' ') ?> MAD</span>
                            </div>
                            <div class="info-block">
                                <span class="info-block__label">Kilométrage</span>
                                <span class="info-block__value"><?= number_format($contrat['kilometrage_location'] ?? 0, 0, '', ' ') ?> km</span>
                            </div>
                            <div class="info-block">
                                <span class="info-block__label">État à la remise</span>
                                <span class="info-block__value"><?= htmlspecialchars($contrat['etat_vehicule_location'] ?? 'Non spécifié') ?></span>
                            </div>
                            <div class="info-block">
                                <span class="info-block__label">Agent responsable</span>
                                <span class="info-block__value">
                                    <?= htmlspecialchars(trim(($contrat['agent_prenom'] ?? '') . ' ' . ($contrat['agent_nom'] ?? ''))) ?>
                                    <?php if (!empty($contrat['num_agent'])): ?>
                                        <small style="display:block; color: var(--text-muted); font-size: 12px;">
                                            ID Agent : <?= htmlspecialchars($contrat['num_agent']) ?>
                                        </small>
                                    <?php endif; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section">
                    <div class="section__title">Résumé Financier</div>
                    <table class="amount-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th class="align-right">Montant</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="amount-table__line">
                                        <strong>Location du véhicule</strong>
                                        <span class="amount-table__subtitle">
                                            <?= $dureeLocation ?> jour(s) × <?= number_format($prixJournalier, 2, ',', ' ') ?> MAD
                                        </span>
                                    </div>
                                </td>
                                <td style="text-align: right;">
                                    <?= number_format($contrat['montant_total'] ?? 0, 2, ',', ' ') ?> MAD
                                </td>
                            </tr>
                            <?php if (!empty($contrat['frais_supplementaires']) && $contrat['frais_supplementaires'] > 0): ?>
                                <tr>
                                    <td>
                                        <div class="amount-table__line">
                                            <strong>Frais supplémentaires</strong>
                                            <span class="amount-table__subtitle">Services additionnels / pénalités</span>
                                        </div>
                                    </td>
                                    <td style="text-align: right;">
                                        <?= number_format($contrat['frais_supplementaires'], 2, ',', ' ') ?> MAD
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <div class="total-amount">
                        <div>
                            <small>Total à payer</small><br>
                            <?= number_format($contrat['montant_total'] ?? 0, 2, ',', ' ') ?> MAD
                        </div>
                        <?php if (!empty($montantEnLettres)): ?>
                        <div style="font-size:14px; font-weight:500;">
                            <?= htmlspecialchars($montantEnLettres) ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="signature">
                    <div class="signature__block">
                        <span class="signature__label">Signature Agent</span>
                        <div class="signature__line" data-placeholder="Signature"></div>
                        <span><?= htmlspecialchars(trim(($contrat['agent_prenom'] ?? '') . ' ' . ($contrat['agent_nom'] ?? ''))) ?></span>
                    </div>
                    <div class="signature__block">
                        <span class="signature__label">Signature Client</span>
                        <div class="signature__line" data-placeholder="Signature"></div>
                        <span><?= htmlspecialchars(trim(($contrat['client_prenom'] ?? '') . ' ' . ($contrat['client_nom'] ?? ''))) ?></span>
                    </div>
                </div>

                <div class="footer">
                    <div>
                        <strong>Merci pour votre confiance.</strong><br>
                        FastCar Location - Partenaire mobilité depuis 2018.
                    </div>
                    <div style="text-align: right;">
                        Facture générée automatiquement le <?= date('d/m/Y à H:i') ?><br>
                        Document à présenter pour toute réclamation.
                    </div>
                </div>
            </div>
        </div>

        <div class="no-print actions-bar">
            <a href="dashboard.php?action=factures_download&num_contrat=<?= urlencode($contrat['num_contrat'] ?? '') ?>" class="btn btn-primary">
                <i>📄</i> Télécharger en PDF
            </a>
            <button class="btn btn-outline" onclick="window.print()">
                <i>🖨️</i> Imprimer la facture
            </button>
            <button class="btn btn-secondary" onclick="window.close()">
                <i>✕</i> Fermer
            </button>
        </div>
    </div>

    <script>
    console.log('Données facture', <?= json_encode($contrat) ?>);
    </script>
</body>
</html>