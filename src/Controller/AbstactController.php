<?php

namespace Themis\Controller;

abstract class AbstactController
{
    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    public function showError(string $errorMessage): void
    {
        self::showView($errorMessage);
    }

    abstract protected function getCreationMessage(): string;

    abstract protected function getViewFolderName(): string;

    public function create()
    {
        $this->showView("view.php", [
            "pageTitle" => $this->getCreationMessage(),
            "pathBodyView" => $this->getViewFolderName() . "/create.php"
        ]);
    }
}