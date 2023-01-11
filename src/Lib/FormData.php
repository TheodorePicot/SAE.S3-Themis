<?php

namespace Themis\Lib;

/**
 *
 */
class FormData
{
    /**
     * Méthode permettant de stocker les données d'un formulaire dans le tableau {@link $_SESSION}
     *
     * @param string $actionName
     * @return void
     */
    public static function saveFormData(string $actionName): void
    {
        foreach ($_POST as $item => $value) {
            $_SESSION['formData'][$actionName][$item] = $value;
            echo $item;
            var_dump($_SESSION['formData'][$actionName][$item]);
        }
    }

    /**
     * @param string $actionName
     * @return void
     */
    public static function deleteFormData(string $actionName): void
    {
        unset($_SESSION['formData'][$actionName]);
    }

    /**
     * @return void
     */
    public static function unsetAll(): void
    {
        unset($_SESSION['formData']);
    }
}