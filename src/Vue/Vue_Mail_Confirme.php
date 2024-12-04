<?php

namespace App\Vue;

use App\Utilitaire\Vue_Composant;

class Vue_Mail_Confirme extends Vue_Composant
{
    function donneTexte(): string
    {
        return "<p>Un e-mail avec les instructions pour réinitialiser votre mot de passe a été envoyé.</p>";
    }
}