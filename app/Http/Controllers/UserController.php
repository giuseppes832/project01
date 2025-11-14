<?php

namespace App\Http\Controllers;

use App\Mail\OwnerInvite;
use App\Mail\UserInvite;
use App\Models\InvitedUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function index() {

        $users = User::whereHasMorph(
            'loggable',
            [InvitedUser::class]
        )->get();

        return view("components.users.users", [
            "users" => $users
        ]);

    }

    public function store() {

        request()->validate([
            "name" => "required|string|max:250",
            "email" => "required|string|max:250|unique:users,email"
        ]);

        DB::transaction(function () {

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

        });

        return redirect("/users");

    }


    public function edit(User $user) {

        $users = User::whereHasMorph(
            'loggable',
            [InvitedUser::class]
        )->get();

        return view("components.users.users", [
            "selectedUser" => $user,
            "users" => $users
        ]);

    }

    public function update(User $user) {

        request()->validate([
            "name" => "required|string|max:250",
            "email" => "required|string|max:250|unique:users,email,$user->id"
        ]);

        DB::transaction(function () use ($user) {

            $passsword = "temporanea" . 1000000 - random_int(1, 100000);

            $user->name = request()->name;
            $user->email = request()->email;
            $user->password = Hash::make($passsword);
            $user->save();

            Mail::to(request()->email)->send(new UserInvite($passsword));

            Log::info('Owner send again invite to User with a temporary password.', ['name' => request()->name, 'email' => request()->email]);

        });

        return redirect("/users/$user->id");

    }

    public function delete(User $user) {
        $user->delete();
    }











    public function ownerAccount() {
        return view("components.users.account", [
            "action" => "owner-account",
            "user" => Auth::user()
        ]);
    }

    public function invitedUserAccount() {
        return view("components.users.account", [
            "action" => "invited-user-account",
            "user" => Auth::user()
        ]);
    }

    private function updateAccount() {

        request()->validate([
            "current_password" => "required|string|max:50|current_password",
            "password" => "required|string|max:50",
            "password2" => "required|string|max:50|same:password"
        ]);

        $user = Auth::user();
        $user->password = Hash::make(request()->password);
        $user->save();

    }

    public function updateInvitedUserAccount() {

        $this->updateAccount();
        Log::info('User changes password.', ['email' => Auth::user()->email]);
        return redirect("invited-user-account");

    }

    public function updateOwnerAccount() {

        $this->updateAccount();
        Log::info('Owner changes password.', ['email' => Auth::user()->email]);
        return redirect("owner-account");

    }


}
