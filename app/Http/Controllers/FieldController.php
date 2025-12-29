<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Field;
use App\Models\FieldTypes\TextField;
use App\Models\Nodes\HtmlTextarea;
use App\Models\Resource;
use App\Utilities\FieldTypes;
use App\Utilities\BooleanFieldTypes;
use App\Utilities\FloatFieldTypes;
use App\Utilities\HtmlNodeTypes;
use App\Utilities\IntegerFieldTypes;
use App\Utilities\StringFieldTypes;
use App\Utilities\EnumFieldTypes;
use Illuminate\Support\Facades\DB;

class FieldController extends Controller
{

    public function store(Resource $resource) {

        request()->validate([
            "name" => "required|string|max:250"
        ]);

        $field = new Field;
        $field->name = request()->name;
        $field->resource_id = $resource->id;
        $field->save();

        return redirect("/resources/$resource->id");

    }

    public  function edit(Field $field) {

        $resources = Resource::all();

        return view("components.resources.resources", [
            "selectedField" => $field,
            "resources" => $resources,
        ]);

    }


    public  function update(Field $field) {

        request()->validate([
            "name" => "required|string|max:250",
            "required" => "nullable",
            "unique" => "nullable"
        ]);

        DB::transaction(function () use ($field) {



            $field->name = request()->name;
            $field->required = (request()->required === "on") ? true : false;
            $field->unique = (request()->unique === "on") ? true : false;
            $field->save();

            if (request()->has("field_type") && request()->field_type) {
                $newFieldTypeClass = FieldTypes::getValues()[request()->field_type]["class"];
                if ($newFieldTypeClass) {
                    $field->changeWithType(FieldTypes::getValues()[request()->field_type]["class"]);
                }
            }

        });

        return redirect("/fields/$field->id");

    }

    public  function updateEnumField(Field $field) {

        // TODO validate request()->options

        if ($field->withType) {
            $field->withType->options = request()->options;
            $field->withType->save();
        }

        return redirect("/fields/$field->id");

    }

    public function delete(Field $field) {

        DB::transaction(function () use ($field) {

            foreach ($field->allValues as $value) {

                $value->withValue->delete();

                $value->delete();

            }

            foreach (HtmlNodeTypes::getValues() as $valueClass) {

                $bindedNodesRel = $field->bindedNodes($valueClass["class"]);
                if ($bindedNodesRel) {

                    $bindedNodes = $field->bindedNodes($valueClass["class"])->get();
                    foreach ($bindedNodes as $bindedNode) {



                        $bindedNode->node->delete();

                        $bindedNode->delete();

                    }
                }
            }

            if ($field->withType) {

                $field->withType->delete();

            }



            $field->delete();

        });

        $resource = $field->resource;

        return redirect("/resources/$resource->id");

    }

}
