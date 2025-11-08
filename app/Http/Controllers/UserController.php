<?php

namespace App\Http\Controllers;

use App\Models\InvitedUser;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

        $user = new User();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make(request()->password);
        $user->save();

        $invitedUser = new InvitedUser();
        $invitedUser->save();

        $invitedUser->user()->save($user);

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

        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make(request()->password);
        $user->save();

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

        $userId = Auth::user()->id;

        request()->validate([
            "name" => "required|string|max:250",
            "email" => "required|string|max:250|unique:users,email,$userId",
            "current_password" => "required|string|max:50|current_password",
            "password" => "required|string|max:50",
            "password2" => "required|string|max:50|same:password"
        ]);

        $user = Auth::user();
        $user->name = request()->name;
        $user->email = request()->email;
        $user->password = Hash::make(request()->password);
        $user->save();

    }

    public function updateInvitedUserAccount() {

        $this->updateAccount();
        return redirect("invited-user-account");

    }

    public function updateOwnerAccount() {

        $this->updateAccount();
        return redirect("owner-account");

    }


}
