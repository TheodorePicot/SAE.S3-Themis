<?php

namespace Themis\Lib;

class FormData
{
    public static function saveFormData() {
        foreach ($_POST as $item => $value) {
            $_SESSION['formData'][$item] = $value;
            var_dump($_SESSION['formData'][$item]);
        }
    }

    public static function unsetData(string $inputName) {
        $tmp = $_SESSION['formData'][$inputName];
        unset($_SESSION['formData'][$inputName]);
        return $tmp;
    }

    public static function returnAndUnset(string $inputName) {
        if (isset($_SESSION['formData'][$inputName])) {
            return self::unsetData($inputName);
        }
    }

    public static function unsetAll() {
        unset($_SESSION['formData']);
    }
}