<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Weather') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Weather in {{$weatherData['name']}}</h1>
                    @if($weatherData)
                    <img src="http://openweathermap.org/img/w/{{ $weatherData['weather'][0]['icon'] }}.png" alt="Weather Icon">
                    <p>Temperature: {{ $weatherData['main']['temp'] }}°C</p>
                    <p>Description: {{ $weatherData['weather'][0]['description'] }}</p>
                    <p>Wind speed: {{ $weatherData['wind']['speed'] }} m/s</p>
                    <!-- Display cache timestamp -->
                    <p>Measurement time: {{ $cacheTimestamp }}</p>
                    <!-- You can display other weather details as needed -->
                @else
                    <p>No weather data available.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
    
</x-app-layout>