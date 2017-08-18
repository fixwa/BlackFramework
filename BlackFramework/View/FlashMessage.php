<?php
namespace Black\View;

use \Black\Session;

class FlashMessage
{
    public static $messages = array(
        'success' => array(),
        'error' => array(),
        'info' => array(),
        'warning' => array(),
    );

    public static function addSuccess($message = '')
    {
        $message = Translation::getMessage($message);

        array_push(self::$messages['success'], $message);
        Session::set('FlashMessage_Success', self::$messages['success']);
    }


    public static function addError($message = '')
    {
        $message = Translation::getMessage($message);

        array_push(self::$messages['error'], $message);
        Session::set('FlashMessage_Error', self::$messages['error']);
    }

    public static function getSuccessMessages()
    {
        $messages = Session::get('FlashMessage_Success');
        Session::del('FlashMessage_Success');
        return $messages;
    }

    public static function getErrorMessages()
    {
        $messages = Session::get('FlashMessage_Error');
        Session::del('FlashMessage_Error');
        return $messages;
    }
}
