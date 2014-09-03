<?php
namespace Black;

use \Black\View\FlashMessage;
use \Black\Container;

class Redirector
{
    private static $instance = null;
    public static $url;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function toUrl($url)
    {
        self::$url = $url;
        return $this;
    }

    public function toRoute($routeName, array $params = array())
    {
        $router = Container::get('router');
        $url = $router->generate($routeName, $params);
        self::$url = $url;
        return $this;
    }

    public function go()
    {
        header('Location: ' . self::$url);
        exit;
    }

    public function setMessages($message)
    {
        if (is_string($message)) {
            FlashMessage::addSuccess($message);
        } elseif (is_array($message)) {
            if (!empty($message['success'])) {
                FlashMessage::addSuccess($message['success']);
            }

            if (!empty($message['error'])) {
                FlashMessage::addError($message['error']);
            }
        }
        return $this;
    }
}
