<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

pest()->use(RefreshDatabase::class);

test("failed reset password because not login", function () {
    $response = $this->post("/request-reset-password");

    $response->assertRedirect("login");
});

test("successfully reset password", function () {
    $user = User::factory()->create([
        "name" => "lizzy mcalpine",
        "email" => "lizzy@example.com",
        "password" => bcrypt("password"),
    ]);

    $token = Password::createToken($user);

    $response = $this->actingAs($user)
        ->from("/reset-password/$token")
        ->post("/reset-password", [
            "token" => $token,
            "email" => "lizzy@example.com",
            "password" => "lizzyisthegoddestofsadness",
            "password_confirmation" => "lizzyisthegoddestofsadness",
        ]);

    $response->assertRedirect("login");

    expect(
        Hash::check("lizzyisthegoddestofsadness", $user->fresh()->password),
    )->toBeTrue();
});

test("can not reset password with the previous password", function () {
    $user = User::factory()->create([
        "name" => "lizzy mcalpine",
        "email" => "lizzy@example.com",
        "password" => bcrypt("lizzyisthegoddestofsadness"),
    ]);

    $token = Password::createToken($user);

    $response = $this->actingAs($user)
        ->from("/reset-password/$token")
        ->post("/reset-password", [
            "token" => $token,
            "email" => "lizzy@example.com",
            "password" => "lizzyisthegoddestofsadness",
            "password_confirmation" => "lizzyisthegoddestofsadness",
        ]);

    $response->assertRedirect("/reset-password/$token");
    $response->assertSessionHas(
        "invalid",
        "password can not the same with the current password",
    );
});

test("failed because reset someone else's password", function () {
    User::factory()->create([
        "name" => "joni mitchel",
        "email" => "jmitchel@example.com",
        "password" => bcrypt("password"),
    ]);

    $user = User::factory()->create([
        "name" => "lizzy mcalpine",
        "email" => "lizzy@example.com",
        "password" => bcrypt("password"),
    ]);

    $token = Password::createToken($user);

    $response = $this->actingAs($user)
        ->from("/reset-password/$token")
        ->post("/reset-password", [
            "token" => $token,
            "email" => "jmitchel@example.com",
            "password" => "lizzyisthegoddestofsadness",
            "password_confirmation" => "lizzyisthegoddestofsadness",
        ]);

    $response->assertRedirect("/reset-password/$token");
});
