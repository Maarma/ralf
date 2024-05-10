<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Marker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('markers.update', $marker) }}">
                        @csrf
                        @method('patch')
                            <x-input-label for="title" value="Title" />
                        <x-text-input
                        value="{{ old('title', $marker->title) }}"
                            name="title"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                            <x-input-label for="lat" value="Latitude" />
                        <x-text-input
                        value="{{ old('lat', $marker->lat) }}"
                            name="lat"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                        <x-input-error :messages="$errors->get('lat')" class="mt-2" />
                            <x-input-label for="lng" value="Longitude" />
                        <x-text-input
                        value="{{ old('lng', $marker->lng) }}"
                            name="lng"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                        <x-input-error :messages="$errors->get('lng')" class="mt-2" />
                            <x-input-label for="description" value="Description" />
                        <x-text-input
                        value="{{ old('description', $marker->description) }}"
                            name="description"
                            class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        />
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        <div class="mt-4 space-x-2">
                            <x-secondary-button>{{ __('Save') }}</x-secondary-button>
                            <x-danger-button><a href="{{ route('markers.index') }}">{{ __('Cancel') }}</a></x-danger-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
