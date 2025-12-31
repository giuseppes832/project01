<?php

namespace App\Models\Nodes;

use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class HtmlTr extends Model
{
    public $parameters = [];

    use NodeTrait;

    protected $table = "html_trs";

    public function setParameters($parameters) {
        $this->parameters = $parameters;
    }

}
