<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Field;
use App\Models\Resource;
use App\Utilities\FieldTypes;
use App\Utilities\BooleanFieldTypes;
use App\Utilities\FloatFieldTypes;
use App\Utilities\IntegerFieldTypes;
use App\Utilities\StringFieldTypes;
use App\Utilities\EnumFieldTypes;

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
            "name" => "required|string|max:250"
        ]);

        $field->name = request()->name;
        $field->required = (request()->required==="on")?true:false;
        $field->unique = (request()->unique==="on")?true:false;
        $field->save();

        if (request()->has("field_type") && request()->field_type) {
            $field->changeWithType(FieldTypes::getValues()[request()->field_type]["class"]);
        }

        return redirect("/fields/$field->id");

    }

    public  function updateEnumField(Field $field) {

        $field->withType->options = request()->options;
        $field->withType->save();

        return redirect("/fields/$field->id");

    }

    public function delete(Field $field) {

        if ($field->with_type_type) {
            $field->withType->delete();
        }

        $field->delete();

        $resource = $field->resource;

        return redirect("/resources/$resource->id");

    }

}
