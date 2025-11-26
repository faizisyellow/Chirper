<x-layout>
    <x-slot:title>Chirp Detail</x-slot:title>

    <div class="max-w-2xl mx-auto mt-8 px-2">
        <a href="/" class="text-sm font-medium text-primary hover:underline">
            Back
        </a>
    </div>

    <div class="max-w-2xl mx-auto mt-3 bg-white border border-base-300 rounded-lg">

        <div class="p-6">
            <x-chirp :chirp="$chirp" />
        </div>

        <div class="divider my-0">Replies</div>

        <div>
            @forelse ($chirp->comments as $comment)
                <div class="px-6 py-5 border-b border-base-300 hover:bg-base-200/40 transition">

                    <div class="flex items-start gap-3">

                        <div class="avatar">
                            <div class="size-9 rounded-full">
                                <img src="https://avatars.laravel.cloud/{{urlencode($comment->user->email)}}"
                                    alt="{{ $comment->user->name }}'s avatar" class="rounded-full" />
                            </div>
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-center">

                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-sm">
                                        {{ $comment->user->name ?? 'Anonymous' }}
                                    </span>

                                    <span class="text-xs text-base-content/50">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </span>
                                </div>

                                @can('delete', $comment)
                                    <form method="POST" action="/comments/{{ $comment->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-error text-xs hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                @endcan
                            </div>

                            <p class="text-sm mt-1.5 leading-relaxed">
                                {{ $comment->content }}
                            </p>

                        </div>

                    </div>
                </div>

            @empty
                <div class="px-6 py-10 text-center text-base-content/60 italic">
                    No replies yet.
                </div>
            @endforelse
        </div>


        <div class="p-6">
            <form method="POST" action="/comments" class="space-y-3">
                @csrf
                <input type="hidden" name="chirp_id" value="{{ $chirp->id }}">
                <textarea
                    name="content"
                    rows="3"
                    maxlength="255"
                    required
                    class="textarea textarea-bordered w-full resize-none rounded-md @error('message') textarea-error @enderror"
                    placeholder="Write a reply…"
                ></textarea>

                @error('message')
                    <p class="text-error text-sm">{{ $message }}</p>
                @enderror

                <div class="flex justify-end">
                    <button type="submit" class="btn btn-primary btn-sm rounded-full">
                        Reply
                    </button>
                </div>
            </form>
        </div>

    </div>

</x-layout>
