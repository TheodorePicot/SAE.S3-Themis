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

    public function showError(string $errorMessage): void
    {
        self::showView($errorMessage);
    }

    public function formulairePreference(){
        self::showView('formulairePreference.php');
    }

    public function enregistrerPreference() : void {
        $controller = $_GET['controleur_defaut'];
        PreferenceControleur::enregistrer($controller);
        self::showView('enregistrerPreference.php', ["pagetitle" => "Préférence utilisateur", "cheminVueBody" => "enregistrerPreference.php"]);

    }


}