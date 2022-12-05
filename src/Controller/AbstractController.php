<?php

namespace Themis\Controller;

abstract class AbstractController
{
    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}