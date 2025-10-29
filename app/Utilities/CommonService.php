<?php

namespace App\Utilities;

use App\Models\Invite;
use App\Models\Sharing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CommonService
{

    public function getSharing() {

        $sharing_id = Cookie::get("sharing_id");


        $sharing = null;
        if ($sharing_id) {

            $sharing = Sharing::whereHasMorph(
                'sharingType',
                [Invite::class],
                function($query) {

                    $query->where('email', Auth::user()->email);
                }
            )->where("id", $sharing_id)->first();

        }

        return $sharing;
    }

}
