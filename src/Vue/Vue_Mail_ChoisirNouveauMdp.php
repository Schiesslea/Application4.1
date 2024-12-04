<?php
namespace App\Vue;
use App\Utilitaire\Vue_Composant;

class Vue_Mail_ChoisirNouveauMdp extends Vue_Composant
{
    private string $token;

    public function __construct(string $token)
    {
        $this->token = $token;
    }

    function donneTexte(): string
    {
        return "  <form action='index.php' method='post' style='width: 50%; display: block; margin: auto;'>
                <h1>Choisissez votre nouveau mot de passe</h1>
                <input type='hidden' name='token' value='{$this->token}'>
                <label><b>Nouveau mot de passe</b></label>
                <input type='password' placeholder='nouveau mot de passe' name='mdp1' required>
                <input type='password' placeholder='confirmer nouveau mot de passe' name='mdp2' required>
                
                <button type='submit' id='submit' name='action' value='choixmdp'>
                      Confirmer le mot de passe
                </button>
            </form>";
    }
}