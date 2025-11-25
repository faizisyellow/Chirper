<!DOCTYPE html>
<html lang="en" data-theme="lofi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Chirper</title>
    <link rel="preconnect" href="<https://fonts.bunny.net>">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col bg-base-200 font-sans">
<div class="container mx-auto px-4 py-8 max-w-md">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title text-2xl mb-2">Reset Password</h2>
            <p class="text-sm text-gray-500 mb-6">Enter your new password below.</p>

            @if ($errors->any())
                <div class="alert alert-error mb-4">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="form-control mb-4">
                    <label class="label">
                    <span class="label-text font-semibold">Email Address</span>
                    </label>
                         <input
                             type="email"
                             name="email"
                                      placeholder="johndoe@example.com"
                                      class="input input-bordered @error('email') input-error @enderror"
                                      required
                                      autofocus
                                  />
                                  @error('email')
                                      <label class="label">
                                          <span class="label-text-alt text-error">{{ $message }}</span>
                                      </label>
                                  @enderror
                              </div>

                <div class="form-control mb-4">
                    <label class="label">
                        <span class="label-text font-semibold">New Password</span>
                    </label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter new password"
                        class="input input-bordered @error('password') input-error @enderror"
                        required
                    />
                    @error('password')
                        <label class="label">
                            <span class="label-text-alt text-error">{{ $message }}</span>
                        </label>
                    @enderror
                </div>

                <div class="form-control mb-6">
                    <label class="label">
                        <span class="label-text font-semibold">Confirm Password</span>
                    </label>
                    <input
                        type="password"
                        name="password_confirmation"
                        placeholder="Confirm new password"
                        class="input input-bordered"
                        required
                    />
                </div>

                <div class="flex gap-2">
                    <a href="/" class="btn btn-ghost flex-1">Cancel</a>
                    <button type="submit" class="btn btn-primary flex-1">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
