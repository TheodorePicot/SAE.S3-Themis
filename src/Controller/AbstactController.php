<?php

namespace Themis\Controller;

abstract class AbstactController
{
    protected static function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    public static function showError(string $errorMessage): void {
        self::showView($errorMessage);
    }
}