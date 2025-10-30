<?php

namespace App\Policies;

use App\Models\Invite;
use App\Models\Node;
use App\Models\Sharing;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class SharingPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function select(User $user, Sharing $sharing): Response
    {
        $selected = Sharing::whereHasMorph(
            'sharingType',
            [Invite::class],
            function($query) use ($user) {
                $query->where('email', $user->email);
            }
        )->where("id", $sharing->id)->first();


        return $selected
            ? Response::allow()
            : Response::deny();
    }
}
