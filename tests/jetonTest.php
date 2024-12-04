<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Modele\Modele_Jeton;

$idUtilisateur = 671;

try {
    $jetonGenere = Modele_Jeton::insert($idUtilisateur);
    echo "Jeton généré : " . $jetonGenere . "\n";
} catch (Exception $e) {
    echo "Échec de la génération du jeton : " . $e->getMessage() . "\n";
    exit;
}

try {
    $jetonRecupere = Modele_Jeton::search($jetonGenere);
    if ($jetonRecupere) {
        echo "Jeton récupéré avec succès : " . print_r($jetonRecupere, true) . "\n";
    } else {
        echo "Échec de la récupération du jeton.\n";
    }
} catch (Exception $e) {
    echo "Échec de la récupération du jeton : " . $e->getMessage() . "\n";
    exit;
}

if ($jetonRecupere) {
    try {
        Modele_Jeton::update($jetonRecupere['id']);
        echo "Jeton expiré.\n";

        // 4. Vérifier que le jeton est bien invalidé
        $jetonApresInvalidation = Modele_Jeton::search($jetonGenere);
        if ($jetonApresInvalidation['dateFin'] < date('Y-m-d H:i:s')) {
            echo "Jeton expiré avec succès.\n";
        } else {
            echo "Échec de l'expiration du jeton.\n";
        }
    } catch (Exception $e) {
        echo "Échec de l'expiration du jeton : " . $e->getMessage() . "\n";
    }
}