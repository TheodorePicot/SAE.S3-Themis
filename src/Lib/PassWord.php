<?php

namespace Themis\Lib;

class PassWord
{
    private static string $pepper = "Lel16cjSsmAXvS+VGZGIIU";


    /**
     * Permet de hacher un mot de passe
     *
     * @param string $visiblePassword Le mot de passe visible qui va être haché
     * @return string
     */
    public static function hash(string $visiblePassword): string
    {
        $pepperedPassword = hash_hmac("sha256", $visiblePassword, PassWord::$pepper);
        return password_hash($pepperedPassword, PASSWORD_DEFAULT);
    }

    /**
     * Return true si les deux paramètres sont égaux sinon false
     *
     *
     * @param string $hashedPassword Le mot de passe déjà haché
     * @param string $visiblePassword Le mot de passe visible
     * @return bool
     */
    public static function check(string $visiblePassword, string $hashedPassword): bool
    {
        $pepperedPassword = hash_hmac("sha256", $visiblePassword, PassWord::$pepper);
        return password_verify($pepperedPassword, $hashedPassword);
    }

    /**
     * Permet de générer une chaine de caractère aléatoire
     *
     * @param int $nbCaracteres Nombre de caractères toujours égal à 22
     * @return string
     */
    public static function generateRandomString(int $nbCaracteres = 22): string
    {
        $randomBytes = random_bytes(ceil($nbCaracteres * 6 / 8));
        return substr(base64_encode($randomBytes), 0, $nbCaracteres);
    }
}
