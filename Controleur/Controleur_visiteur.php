<?php

use PHPMailer\PHPMailer\PHPMailer;
use App\Modele\Modele_Jeton;
use App\Modele\Modele_Utilisateur;
use App\Vue\Vue_Connexion_Formulaire_client;
use App\Vue\Vue_Mail_Confirme;
use App\Vue\Vue_Structure_BasDePage;
use App\Vue\Vue_Structure_Entete;

$Vue->setEntete(new Vue_Structure_Entete());

switch ($action) {
    case "reinitmdp":
        $email = $_POST['email'] ?? null;

        if ($email && $utilisateur = Modele_Utilisateur::trouverParEmail($email)) {
            try {
                $valeurToken = Modele_Jeton::insert($utilisateur['idUtilisateur']);
                $lien = "http://localhost:8000/index.php?action=token&token=$valeurToken";

                // Envoyer l'e-mail avec le lien
                $mail = new PHPMailer();
                $mail->addAddress($utilisateur["login"]);
                $mail->Subject = 'Réinitialisation de mot de passe';
                $mail->isHTML(true);
                $mail->Body = "Veuillez cliquer sur ce lien pour réinitialiser votre mot de passe : <a href='$lien'>Lien à cliquer</a>";

                if ($mail->send()) {
                    $Vue->addToCorps(new Vue_Mail_Confirme());
                } else {
                    throw new \Exception("Erreur lors de l'envoi de l'e-mail.");
                }
            } catch (Exception $e) {
                $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Une erreur est survenue : " . $e->getMessage()));
            }
        } else {
            $Vue->addToCorps(new Vue_Connexion_Formulaire_client("Aucun utilisateur trouvé avec cet e-mail."));
        }
        break;

    case "Se connecter" :
        if (isset($_REQUEST["compte"]) and isset($_REQUEST["password"])) {
            //Si tous les paramètres du formulaire sont bons

            $utilisateur = Modele_Utilisateur::Utilisateur_Select_ParLogin($_REQUEST["compte"]);

            if ($utilisateur != null) {
                //error_log("utilisateur : " . $utilisateur["idUtilisateur"]);
                if ($utilisateur["desactiver"] == 0) {
                    if (isset($_SESSION["motdepasseProv"])) {
                        if ($_SESSION["motdepasseProv"]==$utilisateur["motDePasse"]) {
                            $Vue->addToCorps(new Vue_Utilisateur_Changement_MDP("", "Gerer_monCompte"));
                            session_destroy();
                        }
                    } else {
                        if ($_REQUEST["password"] == $utilisateur["motDePasse"]) {
                            $_SESSION["idUtilisateur"] = $utilisateur["idUtilisateur"];
                            $_SESSION["idCategorie_utilisateur"] = $utilisateur["idCategorie_utilisateur"];

                            if (Modele_Utilisateur::Utilisateur_Select_RGPD($_SESSION["idUtilisateur"]) == 0) {
                                include "./Controleur/Controleur_AccepterRGPD.php";
                                $erreur = true;
                            } else
                                switch ($utilisateur["idCategorie_utilisateur"]) {
                                    case 1:
                                        $_SESSION["typeConnexionBack"] = "administrateurLogiciel"; //Champ inutile, mais bien pour voir ce qu'il se passe avec des étudiants !
                                        $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                        break;
                                    case 2:
                                        $_SESSION["typeConnexionBack"] = "gestionnaireCatalogue";
                                        $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                        $Vue->addToCorps(new \App\Vue\Vue_AfficherMessage("Bienvenue " . $_REQUEST["compte"]));
                                        break;
                                    case 3:
                                        $_SESSION["typeConnexionBack"] = "entrepriseCliente";
                                        //error_log("idUtilisateur : " . $_SESSION["idUtilisateur"]);
                                        $_SESSION["idEntreprise"] = Modele_Entreprise::Entreprise_Select_Par_IdUtilisateur($_SESSION["idUtilisateur"])["idEntreprise"];
                                        include "./Controleur/Controleur_Gerer_Entreprise.php";
                                        break;
                                    case 4:
                                        $_SESSION["typeConnexionBack"] = "salarieEntrepriseCliente";
                                        $_SESSION["idSalarie"] = $utilisateur["idUtilisateur"];
                                        $_SESSION["idEntreprise"] = Modele_Salarie::Salarie_Select_byId($_SESSION["idUtilisateur"])["idEntreprise"];
                                        include "./Controleur/Controleur_Catalogue_client.php";
                                        break;
                                    case 5:
                                        $_SESSION["typeConnexionBack"] = "commercialCafe";
                                        $Vue->setMenu(new Vue_Menu_Administration($_SESSION["typeConnexionBack"]));
                                        break;
                                }

                        } else {//mot de passe pas bon
                            $msgError = "Mot de passe erroné";

                            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                        }
                    }
                } else {
                    $msgError = "Compte désactivé";

                    $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));

                }
            } else {
                $msgError = "Identification invalide";

                $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
            }
        } else {
            $msgError = "Identification incomplete";

            $Vue->addToCorps(new Vue_Connexion_Formulaire_client($msgError));
        }
        break;

//    case 'choixmdp' :
//        $mdp = new Modele_Utilisateur();
//        $mdp->Utilisateur_Modifier_motDePasse($_SESSION["idUtilisateur"], $_REQUEST["NouveauPassword"]);
//        break;

    case 'token':
        $token = rawurldecode($_GET['token']) ?? null;
        if ($token) {
            // Vérifier si le jeton est valide
            $Vue->addToCorps(new \App\Vue\Vue_Mail_ChoisirNouveauMdp($token));
            break;
        }
    default:
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        break;
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());