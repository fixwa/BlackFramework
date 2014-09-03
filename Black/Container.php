<?php
namespace Black;

use Black\Exceptions\ContainerException;

class Container
{

    protected static $registry = array();
    protected static $registrySingleInstances = array();

    /**
     * Add a new resolver to the registry array.
     * @param  string $name The id
     * @param  object $resolve Closure that creates instance
     * @return void
     */
    public static function set($name, \Closure $resolve)
    {
        static::$registry[$name] = $resolve;
    }

    public static function setSingleInstance($name, \Closure $instance)
    {
        static::$registrySingleInstances[$name] = $instance();
    }

    public static function update($name, \Closure $resolve)
    {
        if (!static::isRegistered($name) && !static::isRegisteredAsSingleInstance($name)) {
            throw new ContainerException('No service registered with key: [' . $name .']');
        }
        static::set($name, $resolve);
    }

    /**
     * Create the instance
     * @param  string $name The id
     * @return mixed
     */
    public static function get($name)
    {
        if (static::isRegistered($name)) {
            $name = static::$registry[$name];
            return $name();
        } elseif (static::isRegisteredAsSingleInstance($name)) {
            return static::$registrySingleInstances[$name];
        }

        throw new ContainerException('No service registered with key: [' . $name .']');
    }

    public static function getAllNames()
    {
        return array_keys(static::$registry);
    }

    /**
     * Determine whether the id is registered
     * @param  string $name The id
     * @return bool Whether to id exists or not
     */
    public static function isRegistered($name)
    {
        return array_key_exists($name, static::$registry);
    }

    public static function isRegisteredAsSingleInstance($name)
    {
        return array_key_exists($name, static::$registrySingleInstances);
    }


    public static function init()
    {

        $services = [
            'Black\Services\Core'
        ];

        if (!empty($services)) {
            foreach ($services as $service) {
                if (class_exists($service)) {
                    $service::init();
                }
            }
        }
    }
}
