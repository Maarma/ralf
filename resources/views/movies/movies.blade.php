<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Movies') }}
        </h2>
    </x-slot>

    <div class="product-container">
        @foreach ($movies as $movie)
            <div class="product-card">
                <img src="{{ $movie['image'] }}" alt="{{ $movie['title'] }}" class="product-image" width="400" height="400">
                <div class="product-details">
                    <h2 class="product-name">{{ $movie['title'] }}</h2>
                    <p class="product-author">description: {{ $movie['description'] }}</p>
                    <p class="product-author font-bold">Rating: {{ $movie['movie_rating'] }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
</x-app-layout>

<style>
    .product-container {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.product-card {
    border-style: solid;
    border-color: gray;
    border-width: 2px;
    border-radius: 25px;
    width: calc(25% - 20px); /* Adjust as needed */
    margin-bottom: 20px; /* Adjust spacing between rows */
    /* Optional: Add additional styling */
}

.product-image {
    width: 100%;
    height: auto;
    padding: 20px;
    border-radius: 50px;
}
p, h2{
    margin-left: 20px;
}
h2{
    font-weight: 700;
    font-size: 20px;
}
</style>