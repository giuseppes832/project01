<?php

namespace App\Http\Controllers;

use App\Models\App;
use Illuminate\Http\Request;
use App\Models\Sharing;
use App\Utilities\SharingTypes;

class SharingController extends Controller
{

    public function index() {

        $sharings = Sharing::all();
        return view("components.sharings.sharings", [
            "sharings" => $sharings
        ]);

    }


    public function store() {

        $sharing = new Sharing;
        $sharing->name = request()->name;
        $sharing->save();

        return redirect("/sharings/$sharing->id");

    }

    public  function edit(Sharing $sharing) {

        $sharings = Sharing::all();
        return view("components.sharings.sharings", [
            "selectedSharing" => $sharing,
            "sharings" => $sharings
        ]);

    }

    public  function update(Sharing $sharing) {


        $sharing->name = request()->name;
        $sharing->role_id = request()->role_id;
        $sharing->save();

        $sharing->changeSharingType(SharingTypes::$values[request()->sharing_type]["class"]);

        return redirect("/sharings/$sharing->id");

    }

    public  function update2(Sharing $sharing) {

        $sharing->sharingType->email = request()->email;
        $sharing->sharingType->save();

        return redirect("/sharings/$sharing->id");

    }


    public function delete(Sharing $sharing) {


        if ($sharing->sharingType) {
            $sharing->sharingType->delete();
        }

        $sharing->delete();

        return redirect("/sharings");

    }

}
