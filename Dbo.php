<?php
// Dbo.php factice pour tester Alert.php (design/testing only)

// Retourne une liste d'alertes factices
function getEmailingAO() {
    return [
        [
            'organisme' => 'Organization Alpha',
            'locid' => 'LOC001',
            'ref' => 'REF123',
            'contenu' => 'Contenu de l\'alerte 1',
            'objet' => 'Objet de l\'alerte 1',
            'pubdate' => '2026-01-01',
            'enddate' => '2026-02-01',
            'type_offre' => 'Offre publique',
            'montant_ch' => '10000',
            'source' => 'Site officiel'
        ],
        [
            'organisme' => 'Organization Beta',
            'locid' => 'LOC002',
            'ref' => 'REF456',
            'contenu' => 'Contenu de l\'alerte 2',
            'objet' => 'Objet de l\'alerte 2',
            'pubdate' => '2026-01-05',
            'enddate' => '2026-02-05',
            'type_offre' => 'Offre restreinte',
            'montant_ch' => '5000',
            'source' => 'Newsletter'
        ]
    ];
}

// Retourne le nom de l'organisation
function getOrgName($org_id) {
    $orgs = [
        1 => 'Organization Alpha',
        2 => 'Organization Beta'
    ];
    return $orgs[$org_id] ?? 'Unknown Org';
}

// Simule une autre fonction appelée dans Alert.php
function getEmailingRes_archi() {
    return [
        [
            'organisme' => 'Organization Gamma',
            'locid' => 'LOC003',
            'ref' => 'REF789',
            'contenu' => 'Contenu de l\'alerte 3',
            'objet' => 'Objet de l\'alerte 3',
            'pubdate' => '2026-01-10',
            'enddate' => '2026-02-10',
            'type_offre' => 'Offre publique',
            'montant_ch' => '20000',
            'source' => 'Journal officiel'
        ]
    ];
}
