<?php

namespace App\Models\Nodes;

use App\Models\NodeTrait;
use Illuminate\Database\Eloquent\Model;

class HtmlTr extends Model
{

    use NodeTrait;

    protected $table = "html_trs";

}
