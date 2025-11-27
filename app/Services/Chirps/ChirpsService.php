<?php

namespace App\Services\Chirps;

use App\Models\Chirp;
use Illuminate\Database\Eloquent\Collection;

class ChirpsService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function get(): Collection|null
    {
        $chirps = Chirp::with("user")->latest()->take(50)->get();
        return $chirps;
    }

    public function create(mixed $user, mixed $newChirp)
    {
        $user()->chirps()->create($newChirp);
    }

    public function update(Chirp $chirp, mixed $data)
    {
        $chirp->update($data);
    }

    public function delete(Chirp $chirp)
    {
        $chirp->delete();
    }
}
