<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;

class ChirpController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        $chirps = Chirp::with("user")->latest()->take(50)->get();

        return view("home", ["chirps" => $chirps]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("home", ["chirps" => []]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate(
            [
                "message" => "required|string|min:3|max:255",
            ],
            [
                "message.required" => "Please write something to chirp!",

                "message.max" => "Chirps must be 255 characters or less.",
            ],
        );

        $request->user()->chirps()->create($validated);

        // Redirect back to the feed
        return redirect("/")->with("success", "Chirp created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view("chirps.detail", ["chirp" => (int) $id]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        $this->authorize("update", $chirp);

        return view("chirps.edit", compact("chirp"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp)
    {
        $this->authorize("update", $chirp);

        $validated = $request->validate([
            "message" => "required|string|max:255",
        ]);

        $chirp->update($validated);

        return redirect("/")->with("success", "Chirp updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize("delete", $chirp);
        $chirp->delete();

        return redirect("/")->with("success", "Chirp deleted!");
    }
}
