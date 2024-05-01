<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Markers') }}
        </h2>
    </x-slot>
    <div>
        @foreach($markers as $marker)
    <div>
        <h3>{{ $marker->name }}</h3>
        <p>Latitude: {{ $marker->latitude }}</p>
        <p>Longitude: {{ $marker->longitude }}</p>
        <p>Description: {{ $marker->description }}</p>

        <!-- Add edit and delete buttons -->
        <a href="{{ route('markers.edit', $marker->id) }}">Edit</a>
        
        <form action="{{ route('markers.destroy', $marker->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>
    </div>
@endforeach
    </div>
</x-app-layout>