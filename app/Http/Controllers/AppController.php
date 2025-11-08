<?php

namespace App\Http\Controllers;


use App\Mail\OwnerInvite;
use App\Models\Nodes\BootstrapNavbar;
use App\Models\Owner;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AppController extends Controller
{
    public function adminApp() {

        $owner = User::query()->whereHasMorph("loggable", [Owner::class])->first();

        return view("components.apps.apps", [
            "owner" => $owner
        ]);
    }

    public function ownerApp() {

        $bootstrapNavbar = BootstrapNavbar::query()->first();

        return view("components.apps.invites", [
            "node" => $bootstrapNavbar->node
        ]);
    }

    public function sendOwnerInvite() {

        request()->validate([
            "email" => "required|string|max:250"
        ]);

        $user = User::query()->whereHasMorph("loggable", [Owner::class])->first();

        $passsword = "234";
        if (!$user) {
            $user = new User();
            $user->name = request()->email;
            $user->email = request()->email;

            $user->password = Hash::make($passsword);
            $user->save();

            $owner = new Owner();
            $owner->save();
            $owner->user()->save($user);
        } else {

            $user->name = request()->email;
            $user->email = request()->email;

            $user->password = Hash::make($passsword);
            $user->save();

        }



        Mail::to(request()->email)->send(new OwnerInvite($passsword));

        return redirect("/apps/app");
    }

}
