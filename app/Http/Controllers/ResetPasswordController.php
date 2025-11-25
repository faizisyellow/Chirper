<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $token)
    {
        return view("auth.reset-password", ["token" => $token]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            "token" => "required",
            "password" => "required|min:8|confirmed",
        ]);
        $status = Password::reset(
            $request->only(
                "email",
                "password",
                "password_confirmation",
                "token",
            ),
            function (User $user, string $password) {
                $user
                    ->forceFill(["password" => Hash::make($password)])
                    ->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            },
        );

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return $status === Password::PasswordReset
            ? redirect()->route("login")->with("status", __($status))
            : back()->withErrors(["email" => [__($status)]]);
    }
}
