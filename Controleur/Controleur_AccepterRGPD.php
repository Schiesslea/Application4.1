<?php


// Controleur/Controleur_AccepterRGPD.php

use App\Modele\Modele_Entreprise;
use App\Modele\Modele_Salarie;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_ConsentementRGPD;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Menu_Administration;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

$Vue->setEntete(new Vue_Structure_Entete());

// Le changement dans la base de donnée ne fonctionne pas mais si on change soit même aAccepteRGPD en 1, on peut se connecter
switch ($action) {
    case "AfficherRGPD":
        $Vue->addToCorps(new Vue_ConsentementRGPD());
        break;
    case "AccepterRGPD":
        $ip = $_SERVER['REMOTE_ADDR'];
        $date = new DateTime();
        Modele_Utilisateur::Utilisateur_AccepterRGPD($_SESSION["idUtilisateur"],1,$date,$ip);
        switch ($_SESSION["idCategorie_utilisateur"]) {
            case 1:
                $_SESSION["typeConnexionBack"] = "administrateurLogiciel";
                $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                break;
            case 2:
                $_SESSION["typeConnexionBack"] = "gestionnaireCatalogue";
                $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                $Vue->addToCorps(new \App\Vue\Vue_AfficherMessage("Bienvenue " . $_REQUEST["compte"]));
                break;
            case 3:
                $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                include "./Controleur/Controleur_Gerer_Entreprise.php";
                break;
            case 4:
                $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                $_SESSION["idSalarie"] = $_SESSION["idUtilisateur"];
                $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                include "./Controleur/Controleur_Catalogue_client.php";
                break;
            case 5:
                $_SESSION["typeConnexionBack"] = "commercialCafe";
                $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                break;
        }
        break;
    case "RefuserRGPD":
        session_destroy();
        header("Location: index.php");
        break;
    default:
        $Vue->addToCorps(new Vue_ConsentementRGPD());
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());
