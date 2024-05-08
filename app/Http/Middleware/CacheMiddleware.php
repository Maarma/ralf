<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class CacheMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $key = $request->url(); // Using the URL as the cache key

        // Check if the response is already cached
        if (Cache::has($key)) {
            return response(Cache::get($key)); // Wrap cached content in a Response object
        }

        // If not cached, proceed with the request and cache the response
        $response = $next($request);

        // Store the response in cache for 15 minutes (900 seconds)
        Cache::put($key, $response->getContent(), 900);

        return $response;
    }
}
