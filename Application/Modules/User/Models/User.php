<?php namespace Application\Modules\User\Models;

class User extends \Black\Models\EntityModel
{
    public static $_table = 'users';

    private $unserializedParameters;

    public function getParameter($parameterName)
    {
        $unserializedParameters = $this->getParameters();
        return !empty($unserializedParameters->{$parameterName}) ? $unserializedParameters->{$parameterName} : null;
    }

    public function getParameters()
    {
        $this->unserializedParameters = null;
        if (empty($this->unserializedParameters) && isset($this->parameters)) {
            if (empty($this->parameters)) {
                $this->parameters = new \stdClass;
            }
            $this->unserializedParameters = unserialize($this->parameters);
        }
        return $this->unserializedParameters;
    }

    public function mergeParameters($newParameters)
    {
        $currentParameters = $this->getParameters();
        $currentParameters = json_decode(json_encode($currentParameters), true);
        $newParameters = json_decode(json_encode($newParameters), true);
        if (!is_array($currentParameters)) {
            $currentParameters = (array) $currentParameters;
        }
        $mergedParameters = array_replace_recursive($currentParameters, $newParameters);
        $mergedParameters = json_decode(json_encode($mergedParameters));

        $this->parameters = serialize($mergedParameters);
        return $this;
    }
}
