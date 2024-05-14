<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chirp') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('chirps.store') }}">
                        @csrf
                        <textarea
                            name="message"
                            placeholder="{{ __('What\'s on your mind?') }}"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        >{{ old('message') }}</textarea>
                        <x-input-error :messages="$errors->get('message')" class="mt-2" />
                        <x-secondary-button  type="submit" class="mt-4">{{ __('Chirp') }}</x-secondary-button>
                    </form>
                    <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                        @foreach ($chirps as $chirp)
                        <div class="p-6 flex space-x-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                            </svg>
                    
                            <div class="flex-1">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <span class="text-gray-800">
                                            {{ $chirp->user->name }}
                                        </span>
                                        <small class="ml-2 text-sm text-gray-600">
                                            {{ $chirp->created_at->setTimezone('Europe/Tallinn')->format('Y-m-d H:i:s') }}
                                        </small>
                                        @unless ($chirp->created_at->eq($chirp->updated_at))
                                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                        @endunless
                                    </div>
                                    @if ($chirp->user->is(auth()->user()))
                                        <x-dropdown>
                                            <x-slot name="trigger">
                                                <button>
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                    </svg>
                                                </button>
                                            </x-slot>
                                            <x-slot name="content">
                                                <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                                    {{ __('Edit') }}
                                                </x-dropdown-link>
                                                <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </x-dropdown-link>
                                                </form>
                                            </x-slot>
                                        </x-dropdown>
                                    @endif
                                </div>
                                <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    
                                {{-- Display comments --}}
                                @if ($chirp->comments()->exists())
                                <div class="mt-4">
                                    @foreach ($chirp->comments as $comment)
                                    <div class="bg-slate-100 shadow-sm rounded-lg p-2 my-2">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <span class="text-gray-800">{{ $comment->user->name }}</span>
                                                <small class="ml-2 text-sm text-gray-600">{{ $comment->created_at }}</small>
                                            </div>
                                                @if ($chirp->user->is(auth()->user()) && (auth()->user()->isAdmin))
                                                    <x-dropdown>
                                                        <x-slot name="trigger">
                                                            <button>
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                                </svg>
                                                            </button>
                                                        </x-slot>
                                                        <x-slot name="content">
                                                            <form id="delete-comment-form-{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <x-dropdown-link :href="route('comments.destroy', $comment)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                                    {{ __('Delete') }}
                                                                </x-dropdown-link>
                                                            </form>
                                                        </x-slot>
                                                    </x-dropdown>
                                                @endif
                                            </div>
                                            <p class="mt-2 text-lg text-gray-900">
                                                {{ $comment->comment }}
                                            </p>
                                        </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="italic text-sm pt-2">
                                    No comments yet.
                                </p>
                                @endif
                    
                                {{-- Form to add new comment --}}
                                <form action="{{ route('chirps.comments.store', $chirp) }}" method="POST">
                                    @csrf
                                    <div class="mt-2">
                                        <input type="text" name="comment" class="border-gray-300 rounded-md w-full" placeholder="Add a comment...">
                                        <div class="flex justify-end">
                                            <x-secondary-button type="submit" class="mt-2">{{ __('Comment') }}</x-secondary-button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @endforeach      
            
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>