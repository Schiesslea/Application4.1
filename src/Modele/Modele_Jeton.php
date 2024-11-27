<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;

class Modele_Jeton
{
    public static function Jeton_Generer($idUtilisateur)
    {
        $octetsAleatoires = random_bytes(256);
        $jeton = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            INSERT INTO token (valeur, codeAction, idUtilisateur, dateFin) 
            VALUES (:valeur, :codeAction, :idUtilisateur, :dateFin)
        ');

        // Utilisation de bindValue plutôt que bindParam
        $requetePreparee->bindValue(':valeur', $jeton);
        $requetePreparee->bindValue(':codeAction', 1);
        $requetePreparee->bindValue(':idUtilisateur', $idUtilisateur);
        $requetePreparee->bindValue(':dateFin', $expiration);

        if ($requetePreparee->execute()) {
            return $jeton;
        }

        throw new \Exception("Echec de la generation du jeton.");
    }

    public static function Jeton_Recuperer($valeurJeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            SELECT * FROM token 
            WHERE valeur = :valeurJeton AND dateFin > NOW()'
        );
        $requetePreparee->bindParam(':valeurJeton', $valeurJeton);
        $requetePreparee->execute();

        return $requetePreparee->fetch(PDO::FETCH_ASSOC);
    }

    public static function Jeton_Invalidate($idJeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            UPDATE token 
            SET dateFin = NOW() 
            WHERE id = :idJeton'
        );
        $requetePreparee->bindParam(':idJeton', $idJeton);

        if (!$requetePreparee->execute()) {
            throw new \Exception("Echec de l'invalidation du jeton.");
        }
    }

    public static function Jeton_Delete($idJeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
            DELETE FROM token 
            WHERE id = :idJeton'
        );
        $requetePreparee->bindParam(':idJeton', $idJeton);

        return $requetePreparee->execute();
    }
}