<?php namespace Black;

use \Black\Exceptions\MissingValidatorRuleException;

class Validator
{
    protected $rules = [];
    private $data = [];
    private $passed = [];
    private $failed = [];
    private $errors = [];

    public static $errorMessages = [
        'required' => '%s is required.',
        'minLength' => '%s needs to be at least %s characters long.',
        'maxLength' => '%s needs to be %s characters maximum.',
        'email' => '%s is not a valid email address.',
    ];

    public function passes($data)
    {
        $this->data = $data;

        //@todo Reduce complexity & add resillency.
        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule => $params) {
                $ret = $this->{$rule}($data[$field], $params);
                if ($ret) {
                    $this->passed[$field][] = $rule;
                } else {
                    $message = !empty($this->{$rule . 'ErrorMessage'})
                        ? $this->{$rule . 'ErrorMessage'}
                        : self::$errorMessages[$rule];
                    $this->errors[] = sprintf($message, ucfirst($field), $params);
                    $this->failed[$field][] = $rule;
                }
            }
        }
        return empty($this->failed);
    }

    public function getFailures()
    {
        return $this->failed;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function required($value, $isRequired)
    {
        $ret = true;
        if ($isRequired) {
            $ret = !empty($value);
        }
        return $ret;
    }

    /**
     * Check that the value is a minimum length
     */
    public function minLength($value, $length)
    {
        if (!is_string($value) && ! is_int($value)) {
            return false;
        }
        if (!is_int($length) && ! ctype_digit($length)) {
            throw new \InvalidArgumentException('The length must be an integer');
        }
        return mb_strlen($value) >= $length;
    }

    /**
     * Check that the value is a maximum length
     */
    public function maxLength($value, $length)
    {
        if (!is_string($value) && !is_int($value)) {
            return false;
        }
        if (!is_int($length) && !ctype_digit($length)) {
            throw new \InvalidArgumentException('The length must be an integer');
        }
        return mb_strlen($value) <= $length;
    }

    public function bool(&$value)
    {
        $trueValues = array('true', 't', 'yes', 'y', 'on', '1');
        $falseValues = array('false', 'f', 'no', 'n', 'off', '0');

        if (in_array($value, $trueValues)) {
            $value = '1';
            return true;
        } elseif (in_array($value, $falseValues)) {
            $value = '0';
            return true;
        }

        return false;
    }

    /**
     * Check that the input is a valid date.
     */
    public function date($value)
    {
        if (!is_string($value)) {
            return false;
        }
        return strtotime($value) !== false;
    }

    /**
     * Check that the input is a valid email address.
     */
    public function email($value)
    {
        return !! filter_var($value, FILTER_VALIDATE_EMAIL);
    }

    /**
     * Check that the value is in the param array
     * If value is an array, it'll compute array diff.
     */
    public function in($value, array $param)
    {
        if (is_array($value)) {
            $ret = array_diff($value, $param);
            return empty($ret);
        }

        return in_array($value, $param);
    }

    /**
     * Check that value is a key of the param array.
     * If value is an array, it'll compute array diff.
     */
    public function inKeys($value, array $param)
    {
        if (is_array($value)) {
            $ret = array_diff($value, array_keys($param));
            return empty($ret);
        }

        if (!is_string($value) && ! is_int($value)) {
            return false;
        }

        return array_key_exists($value, $param);
    }

    /**
     * Check the value against a regexp.
     *
     * @param $value mixed
     * @param $regexp string Regular expression
     * @return bool
     */
    public function regexp($value, $regexp)
    {
        if (!$regexp) {
            throw new \InvalidArgumentException('The regular expression cannot be empty');
        }

        return !! filter_var($value, FILTER_VALIDATE_REGEXP, array(
            'options' => array('regexp' => $regexp)
        ));
    }

    /**
     * Validates the format: HH:MM
     */
    public function time($value)
    {
        if (!is_string($value)) {
            return false;
        }

        $h = substr($value, 0, 2);
        $m = substr($value, 3, 2);

        return (isset($value[2]) && $value[2] == ':' && is_numeric($h) && $h < 24 && is_numeric($m) && $m < 60);
    }

    public function url(&$value)
    {
        if (!is_string($value)) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }

    public function numeric($value)
    {
        return is_numeric($value);
    }

    public function maxValue($value, $param)
    {
        return $value <= $param;
    }

    public function minValue($value, $param)
    {
        return $value >= $param;
    }

    public function isArray($value)
    {
        return is_array($value);
    }

    public function isString($value)
    {
        return is_string($value);
    }

    public function isEmpty($value)
    {
        return $value === null || (is_array($value) && empty($value)) || (is_string($value) && trim($value) === '');
    }
}
