<?php namespace Black;

class Config
{
    public static $configs = [];
    public static $paths = [];

    public static function init()
    {
        self::initPaths();
    }

    /**
     * Initializes all base folders.
     */
    private static function initPaths()
    {
        $thisDir = dirname(__FILE__);

        self::$paths['framework']   = realpath($thisDir. '/');
        self::$paths['base']        = realpath($thisDir . '/../');
        self::$paths['application'] = realpath($thisDir . '/../Application/');
        self::$paths['assetsBase']  = realpath($thisDir . '/../Assets/');
        self::$paths['uploads']     = realpath($thisDir . '/../Assets/Uploads/');
        self::$paths['config']      = realpath($thisDir . '/../Application/Config/');
        self::$paths['routes']      = realpath($thisDir . '/../Application/Config/Routes/');
    }

    public static function get($configName = 'application')
    {
        if (empty(self::$configs[$configName])) {
            self::$configs[$configName] = include self::$paths['config'] . '/' . $configName . '.php';
        }
        return self::$configs[$configName];
    }

    public static function set($configName, $value)
    {
        return self::$configs[$configName] = $value;
    }
}
