<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use function Symfony\Component\String\s;

class ProfileController extends Controller
{
    public function edit()
    {
        try{
            $this->data['user'] = User::findOrFail(session('user')['id']);
            $this->data['orders'] = $this->data['user']->orders()->with('orderItems.product')->latest()->get();
            return view('pages.profile', $this->data);
        }
        catch (\Exception $exception){
            return redirect()->route('home')->with('error', 'Something went wrong!');
        }
    }

    public function update(ProfileUpdateRequest $request)
    {
        try{
            $user = User::findOrFail(session('user')['id']);
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
            ]);

            session(['user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'role' => $user->role,
            ]]);

            return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');

        }
        catch (\Exception $exception){
            return redirect()->route('home')->with('error', 'Error while updating your profile!');
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try{
            $user = User::findOrFail(session('user')['id']);

            if(!password_verify($request->current_password, $user->password)){
                return redirect()->route('profile.edit')->withErrors(['current_password' => 'Your current password is incorrect!']);
            }
            $user->update([
                'password' => password_hash($request->new_password, PASSWORD_BCRYPT)
            ]);

            return redirect()->route('profile.edit')->with('success', 'Password changed successfully!');

        }
        catch (\Exception $exception){
            return redirect()->route('home')->with('error', 'Error while updating your password!');
        }
    }
}
