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
                    <div class="cart-item grid grid-row grid-cols-4 mx-4 h-12 items-center">
                        <h2 class="pb-4">{{ $cartItem['name'] }}</h2>
                        <form action="{{ route('updateCartItem', $index) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <p>
                                Quantity:
                                <x-text-input class="w-16" type="number" name="quantity" value="{{ $cartItem['quantity'] }}" min="1" max="99"/>
                                <x-primary-button type="submit">Update</x-primary-button>
                            </p>
                        </form>
                        <p class="pb-4">Price: {{ $cartItem['price'] }} €</p>
                        <!-- Add a form to remove the item from the cart -->
                        <form action="{{ route('removeFromCart', $index) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button type="submit">X</x-danger-button>
                        </form>
                    </div>
                @endforeach
        @else
            <p>No items in cart</p>
        @endif
                    <p class="m-4 font-bold">total sum: {{ $total }} €</p>
                </div>
        </div>
    </div>
</x-app-layout>