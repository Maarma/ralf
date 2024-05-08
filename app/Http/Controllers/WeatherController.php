<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherController extends Controller
{
    public function getWeather()
    {
        // Check if weather data is cached
        if (Cache::has('cached_weather_data')) {
            
            // If cached, retrieve data from cache and pass it to the view
            $weatherData = Cache::get('cached_weather_data');
            $cacheTimestamp = Cache::get('cached_weather_data_timestamp');
            return view('weather', ['weatherData' => $weatherData, 'cacheTimestamp' => $cacheTimestamp]);
        }

        //  OpenWeather API key
        $apiKey = config('services.weather.key');
        
        // Create a new Guzzle client instance
        $client = new Client();

        // API endpoint URL with your desired location and units (e.g., London, Metric units)
        $apiUrl = "http://api.openweathermap.org/data/2.5/weather?q=London&units=metric&appid={$apiKey}";

        try {
            // Make a GET request to the OpenWeather API
            $response = $client->get($apiUrl);

            // Get the response body as an array
            $data = json_decode($response->getBody(), true);
            // Cache the weather data and timestamp for 15 minutes
            $cacheTimestamp = now();
            Cache::put('cached_weather_data', $data, now()->addMinutes(15));
            Cache::put('cached_weather_data_timestamp', $cacheTimestamp, now()->addMinutes(15));
            
            // Pass the weather data and cache timestamp to the view
            return view('weather', ['weatherData' => $data, 'cacheTimestamp' => $cacheTimestamp]);
        } catch (\Exception $e) {
            // Handle any errors that occur during the API request
            return view('api_error', ['error' => $e->getMessage()]);
        }
    }
}