<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Markers') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">    
            <a href="{{ route('markers.create')}}">
                <x-secondary-button>
                    Add marker
                </x-secondary-button>
            </a>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <ul>
                    @foreach($markers as $marker)
                    <div>
                        <li>
                            <div class="grid grid-cols-8 space-y-1">
                                <h3 class="col-span-1">{{ $marker->title }}</h3>
                                <p class="col-span-2">Lat: {{ $marker->lat }}</p>
                                <p class="col-span-2">Lng: {{ $marker->lng }}</p>
                                <p class="col-span-2">Desc: {{ $marker->description }}</p>

                                <div class="col-span-1">
                                    <div class="flex space-x-1">
                                        <x-secondary-button>
                                            <a href="{{ route('markers.edit', $marker->id) }}">
                                                Edit
                                            </a>
                                        </x-secondary-button>
                                
                                        <form action="{{ route('markers.destroy', $marker->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit">Delete</x-danger-button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </div>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

</x-app-layout>