<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
include ('../../x9km-o_f_d/DAO/Dbo.php');

if(isset($_GET['date']) && !empty($_GET['date'])) $dates = $_GET['date'];
else $dates = date("Y-m-d");
$year = date("Y");


if(isset($_GET['daten']) && !empty($_GET['daten'])) $daten = $_GET['daten'];
else $daten = $dates;

$type_res = array('attribution','annulation','infructuosite','amd');
$type_color = array(
    'attribution' => 'type-attribution',
    'annulation' => 'type-annulation',
    'infructuosite' => 'type-infructuosite',
    'amd' => 'type-amd'
);
$sectors = array(
    3 => 'Architecture et urbanisme', 
    34 => "Certifications études et formations"
);

// Début du HTML
$content = '<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenders-DZ - Alertes Appels d\'Offres</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: "Segoe UI", -apple-system, BlinkMacSystemFont, sans-serif;
            background: #f0f2f5;
            padding: 20px 0;
            line-height: 1.5;
            color: #333;
        }

        .email-container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border-radius: 8px;
            overflow: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 50%, #1e3a8a 100%);
            padding: 45px 40px;
            position: relative;
            overflow: hidden;
            text-align: center;
        }
        
        .hero-section::before {
            content: "";
            position: absolute;
            width: 250px;
            height: 250px;
            background: rgba(255,255,255,0.08);
            border-radius: 50%;
            top: -80px;
            right: -80px;
        }
        
        .logo-img {
            max-width: 220px;
            height: auto;
            margin-bottom: 15px;
            position: relative;
            z-index: 2;
        }
        
        .brand .tagline {
            color: rgba(255,255,255,0.92);
            font-size: 15px;
            font-weight: 400;
            position: relative;
            z-index: 2;
        }
        
        .date-badge {
            display: inline-block;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 10px 24px;
            border-radius: 25px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 18px;
            border: 1px solid rgba(255,255,255,0.25);
            position: relative;
            z-index: 2;
        }
        
        .content-area {
            padding: 35px 30px;
            background: #f8f9fa;
        }
        
        .section-header {
            background: transparent;
            padding: 0 0 15px 0;
            margin: 0 0 20px 0;
            border: none;
            border-radius: 0;
            box-shadow: none;
        }
        
        .section-header h2 {
            color: #2c3e50;
            font-size: 19px;
            font-weight: 700;
        }
        
        .tender-card {
            background: #fff;
            border-radius: 12px;
            margin-bottom: 18px;
            overflow: hidden;
            border: 1px solid #e5e7eb;
            transition: all 0.2s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        
        .tender-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-color: #f59e0b;
        }
        
        .card-top {
            background: linear-gradient(to right, #f1f5f9, #e0e7ff);
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
            gap: 12px;
        }
        
        .type-badge {
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.12);
        }
        
        .type-ao { background: linear-gradient(135deg, #10b981, #059669); }
        .type-attribution { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .type-annulation { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .type-infructuosite { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }
        .type-amd { background: linear-gradient(135deg, #ec4899, #db2777); }
        
        .location-tag {
            background: #1e293b;
            color: #fff;
            padding: 7px 16px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }
        
        .card-content {
            padding: 20px 24px;
        }
        
        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px 20px;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }
        
        .detail-item.full-width {
            grid-column: 1 / -1;
        }
        
        .detail-label {
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .detail-value {
            color: #1e293b;
            font-size: 14px;
            font-weight: 500;
            line-height: 1.4;
        }
        
        .card-action {
            padding: 16px 24px;
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }
        
        .view-icon {
            width: 38px;
            height: 38px;
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
            flex-shrink: 0;
        }
        
        .view-icon:hover {
            transform: scale(1.08);
            box-shadow: 0 4px 10px rgba(59, 130, 246, 0.4);
        }
        
        .view-icon svg {
            width: 18px;
            height: 18px;
            fill: #fff;
        }
        
        .footer-section {
            background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
            color: #cbd5e1;
            padding: 35px 30px;
            text-align: center;
        }
        
        .footer-logo {
            max-width: 180px;
            height: auto;
            margin: 0 auto 12px;
        }
        
        .footer-section p {
            margin: 6px 0;
            font-size: 13px;
            line-height: 1.5;
        }
        
        @media (max-width: 768px) {
            .email-container {
                margin: 0;
                border-radius: 0;
            }
            
            .hero-section {
                padding: 35px 25px;
            }
            
            .logo-img {
                max-width: 180px;
            }
            
            .content-area {
                padding: 25px 20px;
            }
            
            .detail-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }
            
            .detail-item {
                grid-column: 1 !important;
            }
            
            .card-top {
                flex-wrap: wrap;
            }
        }
        
        @media (max-width: 480px) {
            body {
                padding: 0;
            }
            
            .section-header {
                padding: 0 0 12px 0;
            }
            
            .card-content {
                padding: 16px 20px;
            }
            
            .card-action {
                padding: 14px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="hero-section">
            <div class="brand">
                <img src="https://tenders-dz.com/images/logo.png" alt="Tenders-DZ" class="logo-img">
                <p class="tagline">Les derniers appels d\'offres, directement chez vous</p>
                <div class="date-badge">'.date("d F Y", strtotime($dates)).'</div>
            </div>
        </div>
        
        <div class="content-area">';

// Boucle sur les secteurs
foreach($sectors as $key => $value) {
    $id_sec = $key;
    $name_sector = $value;
    
    $content .= '<div class="section-header">
                    <h2>'.$name_sector.'</h2>
                </div>';
    
    // Récupération des appels d'offres
    $data_ao = getEmailingAO($dates, $daten, $id_sec, 'all');
    
    foreach ($data_ao as $row_ao) {
        $org = getOrgName($row_ao['organisme']);
        $wil = $row_ao['locid'];
        $ref = $row_ao['ref'];
        $link = 'https://www.tenders-dz.com/Capture_1.php?lien='.base64_encode($row_ao['contenu']);
        
        $content .= '<div class="tender-card">
                        <div class="card-top">
                            <span class="type-badge type-ao">Appel d\'offre</span>
                            <span class="location-tag">'.$wil.'</span>
                        </div>
                        <div class="card-content">
                            <div class="detail-grid">
                                <div class="detail-item full-width">
                                    <span class="detail-label">Organisme</span>
                                    <span class="detail-value">'.$org.'</span>
                                </div>
                                <div class="detail-item full-width">
                                    <span class="detail-label">Objet</span>
                                    <span class="detail-value">'.$row_ao['objet'].'</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Publication</span>
                                    <span class="detail-value">'.$row_ao['pubdate'].'</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Échéance</span>
                                    <span class="detail-value">'.$row_ao['enddate'].'</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Type d\'appel</span>
                                    <span class="detail-value">'.$row_ao['type_offre'].'</span>
                                </div>
                                <div class="detail-item">
                                    <span class="detail-label">Montant</span>
                                    <span class="detail-value">'.$row_ao['montant_ch'].'</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-action">';
        
        if($row_ao['source'] != 'Autres') {
            $content .= '<a href="'.$link.'" target="_blank" class="view-icon" title="Voir capture"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></a>';
        } else {
            $content .= '<a href="https://www.tenders-dz.com/mail/architectesAlerte/div.php?t=a_01O&ref='.$ref.'" target="_blank" class="view-icon" title="Voir contenu"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg></a>';
        }
        
        $content .= '</div></div>';
    }
    
    // Récupération des résultats (attribution, annulation, etc.)
    for($i = 0; $i < 4; $i++) {
        $type = $type_res[$i];
        $data_res = getEmailingRes_archi($dates, $daten, $id_sec, $type);
        
        foreach ($data_res as $row_res) {
            $org1 = getOrgName($row_res['organisme']);
            $ref = $row_res['ref'];
            $link = 'https://www.tenders-dz.com/Capture_1.php?lien='.base64_encode($row_res['contenu']);
            
            $content .= '<div class="tender-card">
                            <div class="card-top">
                                <span class="type-badge '.$type_color[$type].'">'.ucfirst($type).'</span>
                                <span class="location-tag">'.$row_res['locid'].'</span>
                            </div>
                            <div class="card-content">
                                <div class="detail-grid">
                                    <div class="detail-item full-width">
                                        <span class="detail-label">Organisme</span>
                                        <span class="detail-value">'.$org1.'</span>
                                    </div>
                                    <div class="detail-item full-width">
                                        <span class="detail-label">Objet</span>
                                        <span class="detail-value">'.$row_res['objet'].'</span>
                                    </div>
                                    <div class="detail-item">
                                        <span class="detail-label">Publication</span>
                                        <span class="detail-value">'.$row_res['pubdate'].'</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card-action">';
            
            if($row_res['source'] != 'Autres') {
                $content .= '<a href="'.$link.'" target="_blank" class="view-icon" title="Voir capture"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/></svg></a>';
            } else {
                $content .= '<a href="https://www.tenders-dz.com/mail/architectesAlerte/div.php?ref='.$ref.'" target="_blank" class="view-icon" title="Voir contenu"><svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M14 2H6c-1.1 0-1.99.9-1.99 2L4 20c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm2 16H8v-2h8v2zm0-4H8v-2h8v2zm-3-5V3.5L18.5 9H13z"/></svg></a>';
            }
            
            $content .= '</div></div>';
        }
    }
}

$content .= '</div>
        
        <div class="footer-section">
            <img src="https://tenders-dz.com/images/logo.png" alt="Tenders-DZ" class="footer-logo">
            <p>Plateforme algérienne des appels d\'offres et marchés publics</p>
            <p>Restez informé des opportunités d\'affaires en temps réel</p>
            <p style="margin-top: 20px; font-size: 12px; color: #64748b;">
                © '.$year.' Tenders-DZ. Tous droits réservés.
            </p>
        </div>
    </div>
</body>
</html>';

echo $content;
?>