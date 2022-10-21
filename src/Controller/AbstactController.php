<?php

namespace Themis\Controller;

class AbstactController
{
    private static function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

}