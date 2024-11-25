<?php
//include "vendor/autoload.php";
//use PHPMailer\PHPMailer\PHPMailer; //Obligatoire pour avoir l’objet phpmailer qui marche
//$mail = new PHPMailer;
//$mail->isSMTP();
//$mail->Host = '127.0.0.1';
//$mail->Port = 1025; //Port non crypté
//$mail->SMTPAuth = false; //Pas d’authentification
//$mail->SMTPAutoTLS = false; //Pas de certificat TLS
//$mail->setFrom('test@labruleriecomtoise.fr', 'admin');
//$mail->addAddress('client@labruleriecomtoise.fr', 'Mon client');
//if ($mail->addReplyTo('test@labruleriecomtoise.fr', 'admin')) {
//    $mail->Subject = 'Objet : Bonjour !';
//    $mail->isHTML(false);
//    $mail->Body = "Corps du message pour mon client :)";
//
//    if (!$mail->send()) {
//        $msg = 'Désolé, quelque chose a mal tourné. Veuillez réessayer plus tard.';
//    } else {
//        $msg = 'Message envoyé ! Merci de nous avoir contactés.';
//    }
//} else {
//    $msg = 'Il doit manquer qqc !';
//}
//echo $msg;


//function passgen1($nbChar) {
//    $chaine = "mnoTUzS5678kVvwxy9WXYZRNCDEFrslq41GtuaHIJKpOPQA23LcdefghiBMbj0";
//    srand((double)microtime() * 1000000);
//    $pass = '';
//    for ($i = 0; $i < $nbChar; $i++) {
//        $pass .= $chaine[rand() % strlen($chaine)];
//    }
//    return $pass;
//}
//
//for ($i = 0; $i < 1000000; $i++) {
//    $password = passgen1(10);
//    echo $password . "\n";
//}

////Création de la séquence aléatoire à la base du mot de passe
//$octetsAleatoires = openssl_random_pseudo_bytes (12) ;
////Transformation de la séquence binaire en caractères alpha
//$motDePasse = sodium_bin2base64($octetsAleatoires, SODIUM_BASE64_VARIANT_ORIGINAL);
//echo $motDePasse;

function passgen1($nbChar)
{
    $chaine = "ABCDEFGHIJKLMONOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789&é\"'(-è_çà)=$^*ù!:;,~#{[|`\^@]}¤€";
    $pass = '';
    $longueurChaine = strlen($chaine);
    for ($i = 0; $i < $nbChar; $i++) {
        $indexAleatoire = random_int(0, $longueurChaine - 1);
        $pass .= $chaine[$indexAleatoire];
    }
    return $pass;
}

echo passgen1(10);


?>


