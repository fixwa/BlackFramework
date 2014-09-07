<?php
namespace Black;

class Session
{
    const SESSION_NAMESPACE = '__BLACK__';

    public static function start()
    {
        if (session_id() == '') {
            session_start();
            if (!isset($_SESSION[self::SESSION_NAMESPACE])) {
                $_SESSION[self::SESSION_NAMESPACE] = array();
            }
        }
    }

    public static function set($name, $value)
    {
        self::start();
        $_SESSION[self::SESSION_NAMESPACE][$name] = $value;
    }

    public static function add($name, $value)
    {
        self::start();
        if (!isset($_SESSION[self::SESSION_NAMESPACE][$name])) {
            $_SESSION[self::SESSION_NAMESPACE][$name] = array();
        }
        $_SESSION[self::SESSION_NAMESPACE][$name][] = $value;
    }

    public static function isRegistered($name)
    {
        self::start();
        return isset($_SESSION[self::SESSION_NAMESPACE][$name]);
    }

    public static function getAll()
    {
        self::start();
        return $_SESSION[self::SESSION_NAMESPACE];
    }

    public static function get($name)
    {
        self::start();
        if (isset($_SESSION[self::SESSION_NAMESPACE][$name])) {
            return $_SESSION[self::SESSION_NAMESPACE][$name];
        } else {
            return null;
        }
    }

    public static function del($name)
    {
        unset($_SESSION[self::SESSION_NAMESPACE][$name]);
    }

    public static function destroy()
    {
        self::start();
        unset($_SESSION[self::SESSION_NAMESPACE]);
        session_unset();
        session_destroy();
    }
}
