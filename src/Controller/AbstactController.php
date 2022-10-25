<?php

namespace Themis\Controller;

use Themis\Model\Repository\AbstractRepository;
use Themis\Model\Repository\SectionRepository;

abstract class AbstactController
{
    protected abstract function getRepository(): ?AbstractRepository;

    protected abstract function getPrimaryKey(): string;

    protected abstract function getControllerName(): string;

    protected abstract function getDataObject(): string;

    protected function showView(string $pathView, array $parameters = []): void
    {
        extract($parameters);
        require __DIR__ . "/../View/$pathView";
    }

    public function showError(string $errorMessage): void
    {
        self::showView($errorMessage);
    }

    public function create(): void
    {
        $controllerName = $this->getControllerName();
        self::showView("view.php", [
            "pageTitle" => "Création ".$controllerName,
            "pathBodyView" => $controllerName."/create.php"
        ]);
    }

    public abstract function created(): void;

    public function read(): void
    {
        $object = $this->getRepository()->select($_GET[$this->getPrimaryKey()]);
        $controllerName = $this->getControllerName();
        $this->showView("view.php", [
            $controllerName => $object,
            "pageTitle" => "Info $controllerName",
            "pathBodyView" => "$controllerName./read.php"
        ]);
    }

    public function readAll(): void
    {
        $objects = $this->getRepository()->selectAll();
        $controllerNamePlural = $this->getControllerName() . 's';
        $this->showView("view.php", [
            $controllerNamePlural => $objects,
            "pageTitle" => "Info $controllerNamePlural",
            "pathBodyView" => $this->getControllerName() . "/list.php"
        ]);
    }

    public function update(): void {
        $object = $this->getRepository()->select($_GET[$this->getPrimaryKey()]);
        $controllerName = $this->getControllerName();
        $this->showView("view.php", [
            $controllerName => $object,
            "pageTitle" => "Mise à jour $controllerName",
            "pathBodyView" => "$controllerName./update.php"
        ]);
    }

    public abstract function updated(): void;

    public function delete(): void {
        if ($this->getRepository()->delete($_GET[$this->getPrimaryKey()])) {
            $objects = $this->getRepository()->selectAll();
            $controllerNamePlural = $this->getControllerName() . 's';
            $this->showView("view.php", [
                $controllerNamePlural => $objects,
                "pageTitle" => "Suppression",
                "pathBodyView" => $this->getControllerName() . "/deleted.php"
            ]);
        }

    }
}