<?php

namespace Themis\Lib;

/**
 * Classe permettant d'afficher des messages d'erreur
 */
class FlashMessage
{
    const FLASH = 'FLASH_MESSAGES';
    const FLASH_DANGER = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    /**
     * Cette méthode permet d'accéder aux méthodes internes de cette classe
     *
     * Par rapport aux attributs donnés cette méthode execute un code différent.
     * Si l'utilisateur spécifie les 3 arguments alors cette méthode crée un message flash et stocke cette information
     * dans le tableau {@link $_SESSION}.
     * Si l'utilisateur ne spécifie aucuns arguments cette méthode retourne tous les messages flash stockés dans le tableau {@link $_SESSION}.
     * Elle agit comme intermédiaire et simplifie l'accès aux méthodes de cette classe.
     *
     * @see static::createFlashMessage()
     * @see static::returnAllFlashMessages()
     *
     * @param string $name
     * @param string $message
     * @param string $type
     * @return void
     */
    function flash(string $name = '', string $message = '', string $type = ''): void
    {
        if ($name !== '' && $message !== '' && $type !== '') {
            $this->createFlashMessage($name, $message, $type);
        } elseif ($name === '' && $message === '' && $type === '') {
            $this->returnAllFlashMessages();
        }
    }

    /**
     * Crée un message flash
     *
     * Stocke les données dans {@link $_SESSION}
     *
     * @param string $name
     * @param string $message
     * @param string $type
     * @return void
     */
    function createFlashMessage(string $name, string $message, string $type): void
    {
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }
        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
    }

    /**
     * Affiche tous les messages flashs.
     *
     * Stocke les messages flashs dans une variable puis supprime tous les messages flash du tableau session.
     * Ensuite on les affiche dans la vue {@link src/View/view.php}.
     *
     * @see unset()
     *
     * @return void
     */
    function returnAllFlashMessages(): void
    {
        if (!isset($_SESSION[self::FLASH])) {
            return;
        }

        $flashMessages = $_SESSION[self::FLASH];

        unset($_SESSION[self::FLASH]);

        foreach ($flashMessages as $flashMessage) {
            echo $this->formatFlashMessage($flashMessage);
        }
    }

    /**
     * Renvoie le flash message en format CSS
     *
     * @param array $flashMessage
     * @return string
     */
    function formatFlashMessage(array $flashMessage): string
    {
        return sprintf('<div class="alert alert-%s">%s</div>',
            $flashMessage['type'],
            $flashMessage['message']
        );
    }
}