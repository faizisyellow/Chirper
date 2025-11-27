<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use App\Services\Chirps\ChirpsService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ChirpController extends Controller
{
    use AuthorizesRequests;

    private ChirpsService $chirpsService;

    public function __construct(ChirpsService $chirpsService)
    {
        $this->chirpsService = $chirpsService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $chirps = $this->chirpsService->get();

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

        $this->chirpsService->create($request->user(), $validated);

        // Redirect back to the feed
        return redirect("/")->with("success", "Chirp created!");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $serializedId = (int) $id;

        $chirp = Chirp::with("comments")->find($serializedId);

        if (isset($chirp)) {
            return view("chirps.detail", [
                "chirp" => $chirp,
            ]);
        } else {
            return redirect("/");
        }
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

        $this->chirpsService->update($chirp, $validated);

        return redirect("/")->with("success", "Chirp updated!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp)
    {
        $this->authorize("delete", $chirp);
        $this->chirpsService->delete($chirp);

        return redirect("/")->with("success", "Chirp deleted!");
    }
}
