<?php

namespace App\Http\Controllers;

use App\Models\App;
use App\Models\Node;
use App\Models\Nodes\HtmlSharingSelect;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Sharing;
use App\Utilities\SharingTypes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class SharingController extends Controller
{

    public function index() {

        $sharings = Sharing::all();
        return view("components.sharings.sharings", [
            "sharings" => $sharings
        ]);

    }


    public function store() {

        request()->validate([
            "name" => "required|string|max:250|unique:sharings,name"
        ]);

        $sharing = new Sharing;
        $sharing->name = request()->name;
        $sharing->save();

        return redirect("/sharings");

    }

    public function store2() {


        if (!\request()->back) {

            $rules = [
                "name" => "required|string|max:250",
                "email" => "required|string|max:250",
                "role_id" => "required"
            ];

            $validator = Validator::make(request()->all(), $rules);

            if ($validator->fails()) {

                return view("components.new-sharing", [
                    "roles" => Role::all(),
                    "redirect_node_id" => request()->redirect_node_id,
                    "redirect_inputs" => request()->except(["redirect_node_id", "new_node_id", "email", "role_id", "_token"])
                ])
                ->withErrors($validator);

            }

            DB::transaction(function () {

                $sharing = new Sharing;
                $sharing->name = request()->name;
                $sharing->role_id = request()->role_id;
                $sharing->save();

                $newSharingTypeClass = SharingTypes::getValues()["INVITED_USER"]["class"];
                if ($newSharingTypeClass) {
                    $sharing->changeSharingType($newSharingTypeClass);
                    $sharing->sharingType->email = request()->email;
                    $sharing->sharingType->save();
                }

            });

        }

        $redirectNodeid = \request()->redirect_node_id;
        if ($redirectNodeid) {
            \request()->flash();
            return redirect("/render/$redirectNodeid");
        } else {

            // Fallback redirect
            return redirect("/sharings");
        }



    }

    public  function edit(Sharing $sharing) {

        $sharings = Sharing::all();
        return view("components.sharings.sharings", [
            "selectedSharing" => $sharing,
            "sharings" => $sharings
        ]);

    }

    public  function update(Sharing $sharing) {

        request()->validate([
            "name" => "required|string|max:250|unique:sharings,name,$sharing->id"
        ]);

        DB::transaction(function () use ($sharing) {

            $sharing->name = request()->name;
            $sharing->role_id = request()->role_id;
            $sharing->save();

            if (request()->has("sharing_type") && request()->sharing_type) {
                $newSharingTypeClass = SharingTypes::getValues()[request()->sharing_type]["class"];
                if ($newSharingTypeClass) {
                    $sharing->changeSharingType($newSharingTypeClass);
                }
            }

        });

        return redirect("/sharings/$sharing->id");

    }

    public  function update2(Sharing $sharing) {

        // TODO validate

        if ($sharing->sharingType) {
            $sharing->sharingType->email = request()->email;
            $sharing->sharingType->save();
        }

        return redirect("/sharings/$sharing->id");

    }


    public function delete(Sharing $sharing) {

        DB::transaction(function () use ($sharing) {

            if ($sharing->sharingType) {
                $sharing->sharingType->delete();
            }

            $sharing->delete();

        });

        return redirect("/sharings");

    }

}
