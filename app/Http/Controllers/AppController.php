<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Models\Resource;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use App\Models\App;


class AppController extends Controller
{

    public function index() {

        $apps = App::all();

        return view("components.apps.apps", [
            "apps" => $apps
        ]);


    }


    public function store() {

        $app = new App;
        $app->name = request()->name;
        $app->save();

        return redirect("/apps");

    }


    public  function edit(App $app) {

        $apps = App::all();

        return view("components.apps.apps", [
            "selectedApp" => $app,
            "apps" => $apps
        ]);

    }

    public  function update(App $app) {

        $app->name = request()->name;
        $app->save();

        return redirect("/apps/$app->id");

    }

    public function delete(App $app) {

        $app->delete();

        return redirect("/apps");

    }

    public function invites() {

        $apps = App::all();

        return view("components.apps.invites", [
            "apps" => $apps
        ]);


    }

    public function panel() {

        $resources = Resource::all();
        $nodes = Node::all();
        $roles = Role::all();

        return view("components.apps.apps-list", [
            "resources" => $resources,
            "nodes" => $nodes,
            "roles" => $roles
        ]);
    }

}
