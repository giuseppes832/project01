<?php

namespace App\Http\Controllers;

use App\Models\BootstrapNavbar;
use App\Models\Node;
use Illuminate\Http\Request;
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

        $selected = Sharing::whereHasMorph(
            'sharingType',
            [Invite::class],
            function($query) {
                $query->where('email', Auth::user()->email);
            }
        )->where("id", Cookie::get("sharing_id"))->first();

        return view("components.invites", [
            "sharings" => $sharings,
            "selected" => $selected
        ]);
    }

    public function select(Sharing $sharing) {

        Cookie::queue("sharing_id", $sharing->id);

        $menu = BootstrapNavbar::query()->first();

        return redirect("/render/$menu->id");

    }

    public function start() {

        $bootstrapNavbar = BootstrapNavbar::query()->first();

        return view("components.apps.invites", [
            "node" => $bootstrapNavbar->node
        ]);
    }

}
