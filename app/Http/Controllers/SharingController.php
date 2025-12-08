<?php

namespace App\Http\Controllers;

use App\Mail\OwnerInvite;
use App\Models\InvitedUser;
use App\Models\Role;
use App\Models\User;
use App\Models\Sharing;
use App\Utilities\SharingTypes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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



    private function flashOld() {

        $nodes = null;

        foreach (request()->all() as $inputName => $inputValue) {
            if (str_starts_with($inputName, "old_nodes")) {
                $nodes = $inputValue;
            }
        }

        \request()->merge([
            "nodes" => $nodes
        ]);
        \request()->flashOnly(["nodes"]);
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

                request()->flash();
                return view("components.new-sharing", [
                    "roles" => Role::all(),
                    "redirect_row_id" => request()->redirect_row_id,
                    "redirect_node_id" => request()->redirect_node_id,
                    "redirect_inputs" => request()->except(["redirect_row_id", "redirect_node_id", "new_node_id", "name", "email", "role_id", "_token", "_method"])
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

                $invite = User::query()->where("email", request()->email)->first();

                if (!$invite) {

                    $passsword = "temporanea" . 1000000 - random_int(1, 100000);

                    $user = new User();
                    $user->name = request()->name;
                    $user->email = request()->email;
                    $user->password = Hash::make($passsword);
                    $user->save();

                    $invitedUser = new InvitedUser();
                    $invitedUser->save();

                    $invitedUser->user()->save($user);

                    Mail::to(request()->email)->send(new OwnerInvite($passsword));

                    Log::info('Owner send invite to User with a temporary password.', ['name' => request()->name, 'email' => request()->email]);


                }


            });

        }

        $redirectNodeid = \request()->redirect_node_id;
        if ($redirectNodeid) {
            if (!request()->filled("redirect_row_id")) {
                $this->flashOld();
                return redirect("/render/$redirectNodeid");
            } else {
                $rowId = \request()->redirect_row_id;
                $this->flashOld();
                return redirect("/rows/$rowId");
            }
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
