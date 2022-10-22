<?php

namespace Themis\Controller;

use Themis\Model\Repository\AbstractRepository;

abstract class AbstactController
{
    protected abstract function getRepository(): ?AbstractRepository;

    protected abstract function getPrimaryKey(): string;

    protected abstract function getControllerName(): string;

    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    public function showError(string $errorMessage): void {
        self::showView($errorMessage);
    }

    public function read(): void {
        $object = $this->getRepository()->select($_GET[$this->getPrimaryKey()]);
        $controllerName = $this->getControllerName();
        $this->showView("view.php", [
            $controllerName => $object,
            "pageTitle" => "Info $controllerName",
            "pathBodyView" => "$controllerName./read.php"
        ]);
    }

    public function readAll(): void {
        $objects = $this->getRepository()->selectAll();
        $controllerNamePlural = $this->getControllerName().'s';
        $this->showView("view.php", [
            $controllerNamePlural => $objects,
            "pageTitle" => "Info $controllerNamePlural",
            "pathBodyView" => $this->getControllerName()."/list.php"
        ]);
    }

    public function create(): void
    {
        self::showView("view.php", [
            "pageTitle" => "Création d'une question",
            "pathBodyView" => "question/create.php"
        ]);
    }
}