<?php


// Controleur/Controleur_AccepterRGPD.php

use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_ConsentementRGPD;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

$Vue->setEntete(new Vue_Structure_Entete());

switch ($action) {
    case "AfficherRGPD":
        $Vue->addToCorps(new Vue_ConsentementRGPD());
        break;
    case "AccepterRGPD":
        $idUtilisateur = $_REQUEST["idUtilisateur"];
        $aAccepteRGPD = $_REQUEST['aAccepteRGPD'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $dateAcceptionRGPD = date('Y-m-d H:i:s');
        Modele_Utilisateur::Utilisateur_AccepterRGPD($idUtilisateur, $aAccepteRGPD, $dateAcceptionRGPD, $ip);
        break;
    case "RefuserRGPD":
        session_destroy();
        header("Location: index.php");
        break;
    default:
        $Vue->addToCorps(new Vue_ConsentementRGPD());
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());
