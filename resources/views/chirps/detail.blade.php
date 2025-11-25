<x-layout>
    <x-slot:title>
        Chirp Detail
    </x-slot:title>
     <div class="max-w-2xl mx-auto">
         <div class="card bg-base-100 shadow mt-8">
             <div class="card-body">
                 <form method="POST" action="/comments">
                     @csrf
                     <input type="hidden" name="chirp_id" value="{{ $chirp }}">
                     <div class="form-control w-full">
                         <textarea
                             name="content"
                             placeholder="What's on your mind?"
                             class="textarea textarea-bordered w-full resize-none @error('message') textarea-error @enderror"
                             rows="4"
                             maxlength="255"
                             required
                         ></textarea>

                         @error('message')
                             <div class="label">
                                 <span class="label-text-alt text-error">{{ $message }}</span>
                             </div>
                         @enderror
                     </div>

                     <div class="mt-4 flex items-center justify-end">
                         <button type="submit" class="btn btn-primary btn-sm">
                             Chirp
                         </button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
</x-layout>
