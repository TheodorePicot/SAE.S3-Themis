<?php

namespace Themis\Lib;


use Themis\Config\Conf;
use Themis\Model\DataObject\Utilisateur;
use Themis\Model\Repository\UtilisateurRepository;

class VerificationEmail
{
    public static function envoiEmailValidation(Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getLogin());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $absoluteURL = Conf::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=validerEmail&controller=utilisateur&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation</a>";

        // Temporairement avant d'envoyer un vrai mail
        (new FlashMessage())->flash("success", $corpsEmail, FlashMessage::FLASH_SUCCESS);
    }

    public static function traiterEmailValidation($login, $nonce): bool
    {
        $utilisateur = (new UtilisateurRepository())->select($login);
        if ($utilisateur->getLogin() == $login && $utilisateur->getNonce() == $nonce){
            $utilisateur->setAdresseMail($utilisateur->getEmailAValider());
            $utilisateur->setEmailAValider(null);
            $utilisateur->setNonce(null);
            (new UtilisateurRepository())->update($utilisateur);
            return true;
        }
        return false;
    }

    public static function aValideEmail(Utilisateur $utilisateur) : bool
    {
        return $utilisateur->getAdresseMail() != "";
    }
}