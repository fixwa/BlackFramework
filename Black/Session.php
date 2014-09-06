<?php
namespace Black;

class Session
{
    const SESSION_NAMESPACE = '__BLACK__';

    public static function start()
    {
        session_start();
        if (!isset($_SESSION[self::SESSION_NAMESPACE])) {
            $_SESSION[self::SESSION_NAMESPACE] = array();
        }
    }

    public static function set($name, $value)
    {
        if (session_id() == '') {
            // session isn't started
            self::start();
        }

        $_SESSION[self::SESSION_NAMESPACE][$name] = $value;
    }

    public static function add($name, $value)
    {
        if (session_id() == '') {
            self::start();
        }
        if (!isset($_SESSION[self::SESSION_NAMESPACE][$name])) {
            $_SESSION[self::SESSION_NAMESPACE][$name] = array();
        }
        $_SESSION[self::SESSION_NAMESPACE][$name][] = $value;
    }

    public static function isRegistered($name)
    {
        return isset($_SESSION[self::SESSION_NAMESPACE][$name]);
    }

    public static function getAll()
    {
        if (session_id() == '') {
            // session isn't started
            self::start();
        }
        return $_SESSION[self::SESSION_NAMESPACE];
    }

    public static function get($name)
    {
        if (session_id() == '') {
            // session isn't started
            self::start();
        }

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
        if (session_id() == '') {
            // session isn't started
            self::start();
        }
        unset($_SESSION[self::SESSION_NAMESPACE]);
        session_unset();
        session_destroy();
    }


    public static function getUid()
    {
        $UXID = self::get('UXID');
        if (empty($UXID)) {
            $UXID = \Black\Cookie::get('UXID');
            if (empty($UXID)) {
                $UXID = uniqid();
                //30 days cookie
                \Black\Cookie::set('UXID', $UXID, '/', 2592000);
                self::set('UXID', $UXID);
            }
        }
        return $UXID;
    }
}
