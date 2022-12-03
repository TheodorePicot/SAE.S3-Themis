<?php

namespace Themis\Lib;

class PopUpMessage
{
    // Les messages sont enregistrés en session associée à la clé suivante
    private static string $cleFlash = "_messagesFlash";

    // $type parmi "success", "info", "warning" ou "danger"
    public static function add(string $type, string $message): void
    {
        // À compléter
    }

    public static function containsMessage(string $type): bool
    {
        // À compléter
    }

    // Attention : la lecture doit détruire le message
    public static function readMessage(string $type): array
    {
        // À compléter
    }

    public static function readAllMessages() : array
    {
        // À compléter
    }
}