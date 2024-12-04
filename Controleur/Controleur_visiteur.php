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

    default:
        $Vue->addToCorps(new Vue_Connexion_Formulaire_client());
        break;
}

$Vue->setBasDePage(new Vue_Structure_BasDePage());