<?php
// classes/Session.php
namespace App\Classes;

class Session
{
    public static function start()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function get($key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    public static function isLoggedIn()
    {
        return !empty($_SESSION['user_id']) || !empty($_SESSION['useronline']) || !empty($_SESSION['agent_online']);
    }

    public static function getUser()
    {
        if (!empty($_SESSION['user_id'])) {
            return [
                'id' => $_SESSION['user_id'],
                'name' => $_SESSION['user_name'] ?? null,
                'type' => $_SESSION['user_type'] ?? null
            ];
        }

        if (!empty($_SESSION['useronline'])) {
            return [
                'id' => $_SESSION['useronline'],
                'name' => $_SESSION['user_name'] ?? null,
                'type' => 'tenant'
            ];
        }

        if (!empty($_SESSION['agent_online'])) {
            return [
                'id' => $_SESSION['agent_online'],
                'name' => $_SESSION['agent_name'] ?? null,
                'type' => 'agent'
            ];
        }

        return [
            'id' => null,
            'name' => null,
            'type' => null
        ];
    }
}