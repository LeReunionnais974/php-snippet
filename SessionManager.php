<?php

class SessionManager
{

    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            if (!session_start()) {
                throw new RuntimeException('Impossible de démarrer la session.');
            }
        }
    }

    public static function set($key, $value)
    {
        self::validateKey($key);
        $_SESSION[$key] = $value;
    }

    public static function get($key)
    {
        self::validateKey($key);
        return $_SESSION[$key] ?? null;
    }

    public static function remove($key)
    {
        self::validateKey($key);
        unset($_SESSION[$key]);
    }

    public static function destroy()
    {
        session_unset();

        if (!session_destroy()) {
            throw new RuntimeException('Impossible de détruire la session.');
        }
    }

    private static function validateKey($key)
    {
        if (!is_string($key) || empty($key)) {
            throw new InvalidArgumentException('La clé de session ne doit pas être une chaîne de caractère vide.');
        }
    }
}
