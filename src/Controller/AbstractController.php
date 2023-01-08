<?php

namespace Themis\Controller;

use JetBrains\PhpStorm\NoReturn;
use Themis\Lib\ConnexionUtilisateur;
use Themis\Lib\FlashMessage;

/**
 * Classe qui regroupe les méthodes utiles aux controlleurs
 */
abstract class AbstractController
{

    /**
     * Permet d'afficher les vues dans le fichier {@link "src/View"}
     *
     * @param string $pathView Le chemin de la vue qu'on souhaite afficher.
     * @param array $parameters Une array contenant toutes les variables utilisées pas la vue chargée.
     * @return void
     */
    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }


    /**
     * Redirige l'utilisateur vers une vue en utilisant la méthode {@link header()}
     *
     * @param string $url Chemin de la vue ou la méthode doit rediriger l'utilisateur
     * @return void
     */
    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }

    /**
     * Permet de savoir si l'utilisateur est connecté
     *
     * Appelé de manière systématique en premier dans les méthodes des controlleurs nécessitant d'avoir un
     * utilisateur connecté pour fonctionner
     *
     * @return void
     */
    protected function connectionCheck() {
        if (!ConnexionUtilisateur::isConnected()) {
            (new FlashMessage())->flash("notConnected", "Vous n'êtes pas connecté", FlashMessage::FLASH_DANGER);
            $this->redirect("frontController.php?action=readAll");
        }
    }

    /**
     * Permet de savoir si l'utilisateur actuellement connecté est un administrateur
     *
     * Fait appel à la méthode statique {@link ConnexionUtilisateur::isAdministrator()}
     *
     * @return bool
     */
    protected function isAdmin() {
        return ConnexionUtilisateur::isAdministrator();
    }

    /**
     * Permet de savoir si l'utilisateur actuellement connecté est un organisateur
     *
     * Fait appel à la méthode statique {@link ConnexionUtilisateur::$isOrganisateur()}
     * @return bool
     */
    protected function isOrganisateur() {
        return ConnexionUtilisateur::isOrganisateur();
    }

    public function readAPropos(): void
    {
        $this->showView("view.php", ["pageTitle" => "A propos",
            "pathBodyView" => "divers/aPropos.php"]);
    }


}