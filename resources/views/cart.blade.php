<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                @section('content')
                <h1 class="m-4 font-bold">Shopping Cart</h1>
                <div class="cart">
                    @if(session()->has('cart') && count(session('cart')) > 0)
            @foreach(session('cart') as $index => $cartItem)
                <div class="cart-item m-4">
                    <h2>{{ $cartItem['name'] }}</h2>
                    <p>Quantity: 
                        <input type="number" name="quantity[{{ $index }}]" value="{{ $cartItem['quantity'] }}" min="1">
                    </p>
                    <p>Price: {{ $cartItem['price'] }} €</p>
                    <!-- Add a form to remove the item from the cart -->
                    <form action="{{ route('removeFromCart', $index) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Remove from Cart</button>
                    </form>
                </div>
            @endforeach
        @else
            <p>No items in cart</p>
        @endif
                    <p class="m-4">total sum: {{ $total }} €</p>
                </div>
        </div>
    </div>
</x-app-layout>