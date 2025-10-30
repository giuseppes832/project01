<?php

namespace App\Http\Controllers;


use App\Models\BootstrapNavbar;

class AppController extends Controller
{
    public function adminApp() {
        return view("components.apps.apps");
    }

    public function ownerApp() {

        $bootstrapNavbar = BootstrapNavbar::query()->first();

        return view("components.apps.invites", [
            "node" => $bootstrapNavbar->node
        ]);
    }
}
