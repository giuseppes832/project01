<?php

namespace App\Http\Controllers;

use App\Models\BootstrapNavbar;
use Illuminate\Support\Facades\Auth;
use App\Models\Sharing;
use App\Models\Invite;
use Illuminate\Support\Facades\Cookie;

class InviteController extends Controller
{

    public function index() {

        $sharings = Sharing::whereHasMorph(
            'sharingType',
            [Invite::class],
            function($query) {
                $query->where('email', Auth::user()->email);
            }
        )->get();

        $sharingId = Cookie::get("sharing_id");
        if ($sharingId) {

            $selected = Sharing::whereHasMorph(
                'sharingType',
                [Invite::class],
                function($query) {
                    $query->where('email', Auth::user()->email);
                }
            )->where("id", $sharingId)->first();

        }



        return view("components.invites", [
            "sharings" => $sharings,
            "selected" => $selected
        ]);
    }

    public function select(Sharing $sharing) {

        Cookie::queue("sharing_id", $sharing->id);

        $menu = BootstrapNavbar::query()->first();
        $menuNode = $menu->node;
        return redirect("/render/$menuNode->id");

    }



}
