<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Markers') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('markers.create')}}"><x-primary-button>Add marker</x-primary-button></a>
        
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <ul>
        @foreach($markers as $marker)
    <div>
        <li>
            <div class="grid grid-cols-8">
        <h3 class="col-span-1">{{ $marker->title }}</h3>
        <p class="col-span-2">Lat: {{ $marker->lat }}</p>
        <p class="col-span-2">Lng: {{ $marker->lng }}</p>
        <p class="col-span-2">Desc: {{ $marker->description }}</p>

        <!-- Add edit and delete buttons -->
        <div class="col-span-1">
        <div class="flex">
        <x-primary-button><a href="{{ route('markers.edit', $marker->id) }}">Edit</a></x-primary-button>
        
        <form action="{{ route('markers.destroy', $marker->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <x-danger-button type="submit">Delete</x-danger-button>
        </div>
        </div>
        </form>
    </div>
        </li>
    </div>
@endforeach
                </ul>
            </div>
        </div>
    
    </div>
</x-app-layout>