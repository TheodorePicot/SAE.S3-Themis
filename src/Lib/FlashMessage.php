<?php

namespace Themis\Lib;

use function Sodium\add;

class FlashMessage
{
    const FLASH = 'FLASH_MESSAGES';
    const FLASH_DANGER = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

    function createFlashMessage(string $name, string $message, string $type): void
    {
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }
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

        $flash_message = $_SESSION[self::FLASH][$name];

        unset($_SESSION[self::FLASH][$name]);

        echo($flash_message);
    }

    function returnAllFlashMessages(): void
    {
        if (!isset($_SESSION[self::FLASH])) {
            return;
        }

        $flash_messages = $_SESSION[self::FLASH];

        unset($_SESSION[self::FLASH]);

        foreach ($flash_messages as $flash_message) {
            echo $this->formatFlashMessage($flash_message);
        }
    }

    function flash(string $name = '', string $message = '', string $type = ''): void
    {
        if ($name !== '' && $message !== '' && $type !== '') {
            $this->createFlashMessage($name, $message, $type);
        } elseif ($name !== '' && $message === '' && $type === '') {
            $this->displayFlashMessage($name);
        } elseif ($name === '' && $message === '' && $type === '') {
            $this->returnAllFlashMessages();
        }
    }
}