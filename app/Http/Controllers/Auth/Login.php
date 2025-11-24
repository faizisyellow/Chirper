<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            "email" => "required|email",
            "password" => "required",
        ]);

        // Attempt to log in
        if (Auth::attempt($validated, $request->boolean("remember"))) {
            // Regenerate session for security
            $request->session()->regenerate();

            return redirect()->intended("/")->with("success", "welcome back!");
        }

        // If login fails, redirect back with error
        return back()
            ->withErrors([
                "email" => "The provided credentials do not match our records.",
            ])
            ->onlyInput("email");
    }
}
