<?php

namespace Themis\Lib;

class FlashMessage
{
    const FLASH = 'FLASH_MESSAGES';
    const FLASH_DANGER = 'danger';
    const FLASH_WARNING = 'warning';
    const FLASH_INFO = 'info';
    const FLASH_SUCCESS = 'success';

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

    function createFlashMessage(string $name, string $message, string $type): void
    {
        if (isset($_SESSION[self::FLASH][$name])) {
            unset($_SESSION[self::FLASH][$name]);
        }
        $_SESSION[self::FLASH][$name] = ['message' => $message, 'type' => $type];
    }

    function displayFlashMessage(string $name): void
    {
        if (!isset($_SESSION[self::FLASH][$name])) {
            return;
        }

        $flashMessage = $_SESSION[self::FLASH][$name];

        unset($_SESSION[self::FLASH][$name]);

        echo($flashMessage);
    }

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

    function formatFlashMessage(array $flashMessage): string
    {
        return sprintf('<div class="alert alert-%s">%s</div>',
            $flashMessage['type'],
            $flashMessage['message']
        );
    }
}