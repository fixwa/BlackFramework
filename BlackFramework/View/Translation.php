<?php namespace Black\View;

class Translation
{
    public static $messages = array();

    public static function setMessageLibrary($sMessageLibrary)
    {
        self::$messages = require_once $sMessageLibrary;
    }

    public static function getMessage($sMessageId)
    {
        return isset(self::$messages[$sMessageId]) ? self::$messages[$sMessageId] : $sMessageId;
    }
}
