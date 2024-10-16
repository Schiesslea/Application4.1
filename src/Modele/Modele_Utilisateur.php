<?php

namespace App\Modele;
use App\Utilitaire\Singleton_ConnexionPDO;
use PDO;

class Modele_Utilisateur
{
    static function Utilisateur_Select()
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select utilisateur.*, categorie_utilisateur.libelle
        from `utilisateur`  inner join categorie_utilisateur on utilisateur.idCategorie_utilisateur = categorie_utilisateur.id
        order by login');
        $requetePreparee->execute();
        return $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
    }

    static function Utilisateur_Select_Cafe()
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('
        select utilisateur.*, categorie_utilisateur.libelle
        from `utilisateur`  inner join categorie_utilisateur on utilisateur.idCategorie_utilisateur = categorie_utilisateur.id
        where utilisateur.idCategorie_utilisateur = 2 or utilisateur.idCategorie_utilisateur = 1 or utilisateur.idCategorie_utilisateur = 5
        order by login');
        $requetePreparee->execute();
        return $requetePreparee->fetchAll(PDO::FETCH_ASSOC);
    }

    static function Utilisateur_Select_ParId($idUtilisateur)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('select * from `utilisateur` where idUtilisateur = :paramId');
        $requetePreparee->bindParam('paramId', $idUtilisateur);
        $requetePreparee->execute();
        return $requetePreparee->fetch(PDO::FETCH_ASSOC);
    }

    static function Utilisateur_Select_ParLogin($login)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('select * from `utilisateur` where login = :paramLogin');
        $requetePreparee->bindParam('paramLogin', $login);
        $requetePreparee->execute();
        return $requetePreparee->fetch(PDO::FETCH_ASSOC);
    }

    static function Utilisateur_Creer($login, $motDePasse, $codeCategorie)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();

        $requetePreparee = $connexionPDO->prepare('select * from `utilisateur` where login = :paramlogin');
        $requetePreparee->bindParam('paramlogin', $login);
        $requetePreparee->execute();
        $utilisateur = $requetePreparee->fetch(PDO::FETCH_ASSOC);
        if ($utilisateur != null) {
            return false;
        }

        $requetePreparee = $connexionPDO->prepare(
            'INSERT INTO `utilisateur` (`idUtilisateur`, `login`, `idCategorie_utilisateur`, `motDePasse`) 
             VALUES (NULL, :paramlogin, :paramidCategorie_utilisateur, "");');
        $requetePreparee->bindParam('paramlogin', $login);
        $requetePreparee->bindParam('paramidCategorie_utilisateur', $codeCategorie);
        $requetePreparee->execute();
        if ($requetePreparee->rowCount() > 0) {
            $idUtilisateur = $connexionPDO->lastInsertId();
            self::Utilisateur_Modifier_Desactivation($idUtilisateur, 0);
            self::Utilisateur_Modifier_motDePasse($idUtilisateur, $motDePasse);
            return $idUtilisateur;
        }
        return false;
    }

    static function Utilisateur_Supprimer($idUtilisateur)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare('delete from `utilisateur` where idUtilisateur = :paramId');
        $requetePreparee->bindParam('paramId', $idUtilisateur);
        return $requetePreparee->execute();
    }

    static function Utilisateur_Modifier($idUtilisateur, $login, $idCodeCategorie)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'UPDATE `utilisateur`
             SET `login`= :paramlogin, `idCategorie_utilisateur`= :paramidCategorie_utilisateur
             WHERE idUtilisateur = :paramidUtilisateur');
        $requetePreparee->bindParam('paramlogin', $login);
        $requetePreparee->bindParam('paramidCategorie_utilisateur', $idCodeCategorie);
        $requetePreparee->bindParam('paramidUtilisateur', $idUtilisateur);
        return $requetePreparee->execute();
    }

    static function Utilisateur_Modifier_Desactivation($idUtilisateur, $desactiver)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'UPDATE `utilisateur` 
             SET `desactiver`= :paramdesactiver
             WHERE idUtilisateur = :paramidUtilisateur');
        $requetePreparee->bindParam('paramdesactiver', $desactiver);
        $requetePreparee->bindParam('paramidUtilisateur', $idUtilisateur);
        return $requetePreparee->execute();
    }

    static function Utilisateur_Modifier_motDePasse($idUtilisateur, $motDePasse)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'UPDATE `utilisateur` 
             SET motDePasse = :parammotDePasse
             WHERE idUtilisateur = :paramidUtilisateur');
        $requetePreparee->bindParam('parammotDePasse', $motDePasse);
        $requetePreparee->bindParam('paramidUtilisateur', $idUtilisateur);
        return $requetePreparee->execute();
    }

    static function Utilisateur_Modifier_ALL($motDePasse)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'UPDATE `utilisateur` 
             SET motDePasse = :parammotDePasse');
        $requetePreparee->bindParam('parammotDePasse', $motDePasse);
        return $requetePreparee->execute();
    }

    static function Utilisateur_AccepterRGPD($idUtilisateur, $aAccepteRGPD, $dateAcceptionRGPD, $ip)
    {
        $connexionPDO = Singleton_ConnexionPDO::getInstance();
        $requetePreparee = $connexionPDO->prepare(
            'UPDATE `utilisateur` 
             SET aAccepteRGPD = :aAccepteRGPD, dateAcceptionRGPD = :dateAcceptionRGPD, IP = :ip
             WHERE idUtilisateur = :idUtilisateur');
        $requetePreparee->bindParam('aAccepteRGPD', $aAccepteRGPD);
        $requetePreparee->bindParam('dateAcceptionRGPD', $dateAcceptionRGPD);
        $requetePreparee->bindParam('ip', $ip);
        $requetePreparee->bindParam('idUtilisateur', $idUtilisateur);
        return $requetePreparee->execute();
    }


}