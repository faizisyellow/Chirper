<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Chirper</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-base-200 font-sans">
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex items-center justify-between mb-6">
                <h2 class="card-title text-2xl">Profile Information</h2>
                <a href="/" class="btn btn-ghost btn-sm">
                    Back
                </a>
            </div>

            <div class="flex justify-center mb-6">
                <div class="avatar placeholder">
                    <div class="bg-neutral text-neutral-content rounded-full w-24">
                        @if(isset($user))
                        <img src="https://avatars.laravel.cloud/{{ urlencode($user->email) }}"
                            alt="{{$user->name }}'s avatar" class="rounded-full" />
                        @else
                        <img src="https://avatars.laravel.cloud/f61123d5-0b27-434c-a4ae-c653c7fc9ed6?vibe=stealth"
                            alt="Anonymous User" class="rounded-full" />
                        @endif
                    </div>
                </div>
            </div>

            <div class="space-y-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1">Username</h3>
                    <p class="text-lg">{{ $user->name ?? 'Anonymous User' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-500 uppercase mb-1">Email</h3>
                    <p class="text-lg">{{ $user->email ?? 'Anonymous User' }}</p>
                </div>
            </div>

            <div class="card-actions justify-end mt-6">
                <button class="btn btn-primary" onclick="forgot_password_modal.showModal()">
                    Forgot Password
                </button>
            </div>
        </div>
    </div>
</div>

<dialog id="forgot_password_modal" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Reset Password</h3>
        <p class="text-sm text-gray-500 mb-4">Enter your email address and we'll send you a link to reset your password.</p>

        <form method="POST" action="/request-reset-password">
            @csrf
            <div class="form-control">
                <label class="label">
                    <span class="label-text">Email Address</span>
                </label>
                <input type="email" name="email" placeholder="Enter your email" class="input input-bordered" required />
            </div>

            <div class="modal-action">
                <button type="button" class="btn" onclick="forgot_password_modal.close()">Cancel</button>
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop">
        <button>close</button>
    </form>
</dialog>
</body>
</html>
