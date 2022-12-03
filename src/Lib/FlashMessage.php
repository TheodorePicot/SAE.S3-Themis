<?php

namespace Themis\Lib;

use function Sodium\add;

class FlashMessage
{
    // Les messages sont enregistrés en session associée à la clé suivante
    const FLASH = 'FLASH_MESSAGES';
    const FLASH_DANGER = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    function createFlashMessage(string $name, string $message, string $type): void
    {
        // remove existing message with the name
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }
        // add the message to the session
        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
    }

    function formatFlashMessage(array $flash_message): string
    {
        return sprintf('<div class="alert alert-%s">%s</div>',
            $flash_message['type'],
            $flash_message['message']
        );
    }

    function displayFlashMessage(string $name): void
    {
        if (!isset($_SESSION[self::FLASH][$name])) {
            return;
        }

        // get message from the session
        $flash_message = $_SESSION[self::FLASH][$name];

        // delete the flash message
        unset($_SESSION[self::FLASH][$name]);

        // display the flash message
        echo($flash_message);
    }

    function returnAllFlashMessages(): void
    {
        if (!isset($_SESSION[self::FLASH])) {
            return;
        }

        // get flash messages
        $flash_messages = $_SESSION[self::FLASH];

        // remove all the flash messages
        unset($_SESSION[self::FLASH]);

        // show all flash messages
        foreach ($flash_messages as $flash_message) {
            echo $this->formatFlashMessage($flash_message);
        }
    }

    function flash(string $name = '', string $message = '', string $type = ''): void
    {
        if ($name !== '' && $message !== '' && $type !== '') {
            // create a flash message
            $this->createFlashMessage($name, $message, $type);
        } elseif ($name !== '' && $message === '' && $type === '') {
            // display a flash message
            $this->displayFlashMessage($name);
        } elseif ($name === '' && $message === '' && $type === '') {
            // display all flash message
            $this->returnAllFlashMessages();
        }
    }
}