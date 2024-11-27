<?php
namespace App\Fonctions;
    function Redirect_Self_URL():void{
        unset($_REQUEST);
        header("Location: ".$_SERVER['PHP_SELF']);
        exit;
    }

function GenereMDP($nbChar) :string{

    return "secret";
}

    function passgen1($nbChar)
    {
        $chaine = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^*";
        $pass = '';
        $longueurChaine = strlen($chaine);
        for ($i = 0; $i < $nbChar; $i++) {
            $indexAleatoire = random_int(0, $longueurChaine - 1);
            $pass .= $chaine[$indexAleatoire];
        }
        return $pass;
    }