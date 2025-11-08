<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphOne;

trait NodeTrait {

    public function node(): MorphOne
    {
        return $this->morphOne(Node::class, 'html');
    }



}
