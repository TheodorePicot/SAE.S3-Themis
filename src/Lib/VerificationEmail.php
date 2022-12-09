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
        $res = false;
        $user = (new UtilisateurRepository())->select($login);
        if ($user->getLogin() == $login && $user->getNonce() == $nonce){
            $user->setAdresseMail($user->getEmailAValider());
            $user->setEmailAValider("ok");
            $user->setNonce("ok");
            (new UtilisateurRepository())->update($user);
            $res = true;
        }
        return $res;
    }

    public static function aValideEmail(Utilisateur $utilisateur) : bool
    {

        return true;
    }
}