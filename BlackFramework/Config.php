<?php namespace Black;

class Config
{
    public static $configs = [];
    public static $paths = [];

    /**
     * @param string $applicationBaseDir The User-Application base directory.
     */
    public static function init($applicationBaseDir)
    {
        self::initPaths($applicationBaseDir);
    }

    /**
     * Initializes all base folders.
     * @param string $applicationBaseDir The User-Application base directory.
     */
    private static function initPaths($applicationBaseDir)
    {
        $thisDir = dirname(__FILE__);

        self::$paths['framework']   = realpath($thisDir. '/');
        self::$paths['base']        = realpath($thisDir . '/../');
        self::$paths['application'] = realpath($applicationBaseDir . '/Application/');
        self::$paths['assetsBase']  = realpath($applicationBaseDir . '/Assets/');
        self::$paths['uploads']     = realpath($applicationBaseDir . '/Assets/Uploads/');
        self::$paths['config']      = realpath($applicationBaseDir . '/Application/Config/');
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
