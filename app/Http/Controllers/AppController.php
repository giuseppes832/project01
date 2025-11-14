<?php

namespace App\Http\Controllers;


use App\Mail\OwnerInvite;
use App\Models\Nodes\BootstrapNavbar;
use App\Models\Owner;
use App\Models\User;
use Brick\Math\Exception\MathException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
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

        $node = null;
        if ($bootstrapNavbar) {
           $node =  $bootstrapNavbar->node;
        }

        return view("components.apps.invites", [
            "node" => $node
        ]);
    }

    public function sendOwnerInvite() {

        request()->validate([
            "email" => "required|string|max:250"
        ]);

        DB::transaction(function() {

            $user = User::query()->whereHasMorph("loggable", [Owner::class])->first();

            $passsword = "temporanea" . 1000000 - random_int(1, 100000);
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

            Log::info('Admin send invite to Owner with a temporary password.', ['email' => request()->email]);

        });

        return redirect("/apps/app");
    }

}
