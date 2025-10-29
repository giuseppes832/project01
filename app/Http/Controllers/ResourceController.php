<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\App;

class ResourceController extends Controller
{

    public function index() {

        $resources = Resource::all();

        return view("components.resources.resources", [
            "resources" => $resources
        ]);

    }


    public function store() {

        $resource = new Resource;
        $resource->name = request()->name;
        $resource->save();

        return redirect("/resources");

    }


    public  function edit(Resource $resource) {

        $resources = Resource::all();

        return view("components.resources.resources", [
            "selectedResource" => $resource,
            "resources" => $resources
        ]);

    }

    public  function update(Resource $resource) {


        $resource->name = request()->name;
        $resource->save();

        return redirect("/resources/$resource->id");

    }

    public function delete(Resource $resource) {

        foreach ($resource->fields as $field) {

            $field->withType->delete();

            $field->delete();

        }

        $resource->delete();

        return redirect("/resources");

    }

}
