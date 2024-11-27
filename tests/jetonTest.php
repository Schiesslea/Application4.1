<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Modele\Modele_Jeton;

$idUtilisateur = 1; // Simuler un utilisateur avec un ID 1

try {
    // 1. Générer un jeton pour l'utilisateur
    $jetonGenere = Modele_Jeton::Jeton_Generer($idUtilisateur);
    echo "Jeton généré : " . $jetonGenere . "\n";
} catch (Exception $e) {
    echo "Échec de la génération du jeton : " . $e->getMessage() . "\n";
    exit;
}

try {
    // 2. Récupérer le jeton généré
    $jetonRecupere = Modele_Jeton::Jeton_Recuperer($jetonGenere);
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
        // 3. Invalider le jeton
        Modele_Jeton::Jeton_Invalidate($jetonRecupere['id']);
        echo "Jeton expiré.\n";

        // 4. Vérifier que le jeton est bien invalidé
        $jetonApresInvalidation = Modele_Jeton::Jeton_Recuperer($jetonGenere);
        if (!$jetonApresInvalidation) {
            echo "Jeton expiré avec succès.\n";
        } else {
            echo "Échec de l'expiration du jeton.\n";
        }
    } catch (Exception $e) {
        echo "Échec de l'expiration du jeton : " . $e->getMessage() . "\n";
    }
}
?>