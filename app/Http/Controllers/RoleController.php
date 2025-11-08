<?php

namespace App\Http\Controllers;

use App\Models\Node;
use App\Models\Role;

class RoleController extends Controller
{


    public function index() {

        $roles = Role::all();
        $rootNodes = Node::query()->whereNull("parent_id")->get();

        return view("components.roles.roles", [
            "roles" => $roles,
            "rootNodes" => $rootNodes
        ]);

    }


    public function store() {

        request()->validate([
            "name" => "required|string|max:250|unique:roles,name"
        ]);

        $role = new Role();
        $role->name = request()->name;
        $role->save();

        return redirect("/roles");

    }

    public  function edit(Role $role) {

        $roles = Role::all();
        $rootNodes = Node::query()->whereNull("parent_id")->get();

        return view("components.roles.roles", [
            "selectedRole" => $role,
            "roles" => $roles,
            "rootNodes" => $rootNodes
        ]);

    }

    public  function update(Role $role) {

        request()->validate([
            "name" => "required|string|max:250|unique:roles,name,$role->id"
        ]);

        $role->name = request()->name;
        $role->save();

        return redirect("/roles/$role->id");

    }

    public function delete(Role $role) {

        $role->delete();

        return redirect("/roles");

    }

}
