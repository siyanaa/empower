<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{

    use ResetsPasswords;
    protected $redirectTo = RouteServiceProvider::HOME;

    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string|current_password',
            'password' => 'required|string|confirmed|min:8',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator->messages())
                ->withInput();
        }

        $user = Auth::user();
        $user->forceFill([
            'password' => Hash::make($request->input('password'))
        ])->save();
        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
