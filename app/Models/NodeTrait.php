<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait NodeTrait {


    public $optionalParameters = [];

    public function node(): MorphOne
    {
        return $this->morphOne(Node::class, 'html');
    }

    public function addOptionalParameter($parameterName, $parameterValue) {
        $this->optionalParameters[$parameterName] = $parameterValue;
    }

    /**
     * @param array $optionalParameters
     */
    public function setOptionalParameters(array $optionalParameters): void
    {
        $this->optionalParameters = $optionalParameters;
    }

}
