<?php

namespace App\Modele;

use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;

class Modele_Jeton
{

    public static function insert($idUtilisateur)
    {
        $octetsAleatoires = openssl_random_pseudo_bytes (256) ;
        $jeton = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
        $expiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        INSERT INTO token (valeur, idUtilisateur, dateFin) 
        VALUES (:valeur, :idUtilisateur, :dateFin)
    ');

        $requetePreparee->bindValue(':valeur', $jeton);
        $requetePreparee->bindValue(':idUtilisateur', $idUtilisateur);
        $requetePreparee->bindValue(':dateFin', $expiration);

        if ($requetePreparee->execute()) {
            return $jeton;
        }

        throw new \Exception("Échec de l'insertion du jeton.");
    }

    public static function update($idJeton)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $stmt = $connexionPDO->prepare('UPDATE token SET dateFin = NOW() WHERE id = :id');
        $stmt->bindValue(':id', $idJeton);

        if (!$stmt->execute()) {
            throw new \Exception("Échec de la mise à jour du jeton.");
        }
    }

    public static function search($valeur)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $stmt = $connexionPDO->prepare('SELECT * FROM token WHERE valeur = :valeur');
        $stmt->bindValue(':valeur', $valeur);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }

        throw new \Exception("Échec de la récupération du jeton.");
    }
}