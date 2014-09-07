<?php namespace Black;

class Request
{
    public static $route;
    public static $router;

    public function getSelfUrl()
    {
        return self::$router->generate(self::$route['name'], self::$route['params']);
    }

    public function getParam($param)
    {
        $paramValue = !empty(self::$route['params'][$param]) ? self::$route['params'][$param] : '';
        if (empty($paramValue)) {
            $paramValue = !empty($_POST[$param]) ? $_POST[$param] : '';
        }
        if (empty($paramValue)) {
            $paramValue = !empty($_GET[$param]) ? $_GET[$param] : '';
        }
        return $paramValue;
    }

    public function getParams()
    {
        return !empty(self::$route['params']) ? self::$route['params'] : null;
    }

    public function getPostData($key = null)
    {
        //$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (is_null($key)) {
            return $_POST;
        } else {
            return $_POST[$key];
        }

    }

    public function getSanitizedPostData($key = null)
    {
        //$_GET   = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);
        $_POST  = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        if (is_null($key)) {
            return $_POST;
        } else {
            return $_POST[$key];
        }

    }

    /**
     * Based on the getRealIP method
     */
    public static function getIp()
    {
        if (!empty( $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty( $_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}
