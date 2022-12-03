<?php

namespace Themis\Controller;

use Themis\Lib\PreferenceControleur;

abstract class AbstactController
{
    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    protected function redirect(string $url) {
        header("Location: $url");
        exit();
    }

    public function showError(string $errorMessage): void
    {
        self::showView($errorMessage);
    }
}