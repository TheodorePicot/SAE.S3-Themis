<?php

namespace Themis\Lib;

use Themis\Model\HTTP\Session;

class FormData
{
    public static function saveFormData(string $actionName) {
        foreach ($_POST as $item => $value) {
            $_SESSION[$actionName][$item] = $value;
            echo $item;
            var_dump($_SESSION['formData'][$actionName][$item]);
        }
    }

    public static function deleteFormData(string $actionName) {
        unset($_SESSION['formData'][$actionName]);
    }

    public static function unsetAll() {
        unset($_SESSION['formData']);
    }
}