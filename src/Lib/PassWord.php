<?php

namespace Themis\Lib;

class PassWord
{
    private static string $pepper = "Lel16cjSsmAXvS+VGZGIIU";

    public static function hash(string $visiblePassword): string
    {
        $pepperedPassword = hash_hmac("sha256", $visiblePassword, PassWord::$pepper);
        return password_hash($pepperedPassword, PASSWORD_DEFAULT);
    }

    public static function check(string $visiblePassword, string $hashedPassword): bool
    {
        $pepperedPassword = hash_hmac("sha256", $visiblePassword, PassWord::$pepper);
        return password_verify($pepperedPassword, $hashedPassword);
    }

    public static function generateRandomString(int $nbCaracteres = 22): string
    {
        $randomBytes = random_bytes(ceil($nbCaracteres * 6 / 8));
        return substr(base64_encode($randomBytes), 0, $nbCaracteres);
    }
}
