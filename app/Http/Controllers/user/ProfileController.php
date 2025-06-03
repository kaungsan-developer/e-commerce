<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\user\ProfileRequest;
use App\Http\Requests\user\PasswordChangeRequest;

class ProfileController extends Controller
{
    public function show(User $user)
    {
        $this->authorize('view', $user);
        $user = User::with('orders', 'orders.products')->find($user->id);
        return view('user.profile', compact('user'));
    }

    public function update(ProfileRequest $request,User $user)
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        return redirect()->route('user.show', $user->id)->with('success', 'Profile updated successfully');
    }

    public function updatePassword(PasswordChangeRequest $request,User $user)
    {
        $this->authorize('update', $user);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Password updated successfully');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->delete();
        return redirect()->route('profile', $user->id)->with('success', 'Profile deleted successfully');
    }
}
