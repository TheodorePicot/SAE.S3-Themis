<?php

namespace Themis\Lib;

/**
 *
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
     * Si l'utilisateur spécifie les 3 arguments
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