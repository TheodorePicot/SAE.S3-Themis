<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Session;
use Themis\Model\Repository\UtilisateurRepository;

class ConnexionUtilisateur
{
    private static string $connectionKey = "connectedUser";
    private static string $isOrganisateur = "isOrganisateur";
    private static string $idAdministrator = "isAdministrator";


    /**
     * Permet à un utilisateur de se connecter
     *
     * @param string $loginUtilisateur Le login de l'utilisateur voulant se connecter
     * @return void
     */
    public static function connect(string $loginUtilisateur): void
    {
        $session = Session::getInstance();
        $session->save(self::$connectionKey, $loginUtilisateur);
        $session->save(self::$idAdministrator, self::isAdministrator());
        $session->save(self::$isOrganisateur, self::isOrganisateur());
    }

    /**
     * Permet à un utilisateur de se déconnecter
     *
     * En utilisant {@link $_SESSION} cette méthode supprime toutes les données stockées sur l'utilisateur actuel.
     *
     * @return void
     */
    public static function disconnect(): void
    {
        $session = Session::getInstance();
        $session->delete(self::$connectionKey);
        $session->delete(self::$idAdministrator);
        $session->delete(self::$isOrganisateur);
    }

    /**
     * Permet d'obtenir le login de l'utilisateur actuellement connecté
     *
     * @return string|null
     */
    public static function getConnectedUserLogin(): ?string
    {
        $session = Session::getInstance();
        if (!self::isConnected()) {
            return null;
        } else {
            return $session->read(self::$connectionKey);
        }
    }


    /**
     * Return true si l'utilisateur courant est connecté sinon false
     *
     * @return bool
     */
    public static function isConnected(): bool
    {
        $session = Session::getInstance();
        return $session->contains(self::$connectionKey);
    }

    /**
     * Return true si l'utilisateur courant qui est connecté a pour login la variable placé en paramètre sinon false
     *
     * @param $login string Le login de l'utilisateur
     * @return bool
     */
    public static function isUser(string $login): bool
    {
        return (self::isConnected() && self::getConnectedUserLogin() == $login);
    }


    /**
     * Return true si l'utilisateur courant qui est connecté est un administrateur sinon false
     *
     * Cette méthode utilise {@link Session} pour stocker le fait qu'il soit administrateur ou non.
     * Cela optimise le temps d'execution car nous n'avons plus besoins de passer par la base de données à chaque fois
     * que cette méthode est appelée, mais uniquement la première fois.
     *
     * @return bool
     */
    public static function isAdministrator(): bool
    {
        $session = Session::getInstance();
        if ($session->contains(self::$idAdministrator)) return $session->read(self::$idAdministrator);

        $user = self::getConnectedUserLogin();
        if ($user == null) return false;

        $adminOuPas = (new UtilisateurRepository())->select($user);
        $tab = $adminOuPas->tableFormat();
        if ($tab['estAdmin'] == 1) return true;
        else return false;
    }


    /**
     * Return true si l'utilisateur courant qui est connecté est un organisateur sinon false
     *
     * Cette méthode utilise {@link Session} pour stocker le fait qu'il soit organisateur ou non.
     * Cela optimise le temps d'execution car nous n'avons plus besoins de passer par la base de données à chaque fois
     * que cette méthode est appelée, mais uniquement la première fois.
     *
     * @return bool
     */
    public static function isOrganisateur(): bool
    {
        $session = Session::getInstance();
        if ($session->contains(self::$isOrganisateur)) return $session->read(self::$isOrganisateur); // Si valeur déjà stocker dans la session accéder au tableau $_SESSION

        $user = self::getConnectedUserLogin();
        if ($user == null) return false;

        $organisateurOuPas = (new UtilisateurRepository())->select($user);
        $tab = $organisateurOuPas->tableFormat();
        if ($tab['estOrganisateur'] == 1) return true;
        else return false;
    }
}


