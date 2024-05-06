<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <h1>Shopping Cart:</h1>
    <div class="cart">
        @if($cartItems->isEmpty())
            <p>No items in cart!</p>
        @else
        @foreach($cartItems as $cartItem)
            <div class="cart-item">
                <h2>{{ $cartItem->name }}</h2>
                <h2>{{ $cartItem->price }}</h2>
                <!-- Display other cart item details -->
            </div>
        @endforeach
        @endif
    </div>
        </div>
    </div>
</x-app-layout>