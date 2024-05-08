<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1>Weather</h1>
                    @if($weatherData)
                    <p>Temperature: {{ $weatherData['main']['temp'] }}°C</p>
                    <p>Description: {{ $weatherData['weather'][0]['description'] }}</p>
                    <!-- Display cache timestamp -->
                    <p>Cache saved at: {{ $cacheTimestamp }}</p>
                    <!-- You can display other weather details as needed -->
                @else
                    <p>No weather data available.</p>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>