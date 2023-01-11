<?php

namespace Themis\Lib;


use Themis\Config\Conf;
use Themis\Model\DataObject\Utilisateur;
use Themis\Model\Repository\UtilisateurRepository;

class VerificationEmail
{

    /**
     * Permet d'fenvoyer un mail à l’adresse renseignée avec un lien qui envoi le nonce au site à l'utilisateur plcé en paramètre
     *
     * @param Utilisateur $utilisateur L'utilisateur qui reçoi le mail de validation
     * @return void
     */
    public static function sendEmailValidation(Utilisateur $utilisateur): void
    {
        $loginURL = rawurlencode($utilisateur->getLogin());
        $nonceURL = rawurlencode($utilisateur->getNonce());
        $absoluteURL = Conf::getAbsoluteURL();
        $lienValidationEmail = "$absoluteURL?action=validerEmail&controller=utilisateur&login=$loginURL&nonce=$nonceURL";
        $corpsEmail = "<a href=\"$lienValidationEmail\">Validation</a>";
        mail($utilisateur->getAdresseMail(), "Verification Email Themis", $corpsEmail);
        // Temporairement avant d'envoyer un vrai mail
//        (new FlashMessage())->flash("success", $corpsEmail, FlashMessage::FLASH_SUCCESS);
    }

    /**
     * Permet de faire les modifications dans la base de donnée pour valider l'émail
     *
     * Si le login correspond à un utilisateur présent dans la base et que le nonce passé en GET correspond au nonce
     * de la BDD, alors le champ email contient l'email de l'utilisateur concerné et le champ nonce email à valider
     * deviennent vide de la BDD.
     *
     * @param $login Le login de l'utilisateur
     * @param $nonce Le nonce de l'utilisateur
     * @return bool
     */
    public static function handleEmailValidation($login, $nonce): bool
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


    /**
     * Return true si l'email de l'utilisateur placé en paramètre est validée sinon false
     *
     * @param Utilisateur $utilisateur Un utilisateur
     * @return bool
     */
    public static function hasValidatedEmail(Utilisateur $utilisateur) : bool
    {
        return $utilisateur->getEmailAValider() == null;
    }
}