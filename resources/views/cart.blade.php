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
                <div>
                    @if(session()->has('cart') && count(session('cart')) > 0)
                    <div class="cart-item grid grid-row grid-cols-4 m-4 h-12 items-center">
                        @foreach(session('cart') as $index => $cartItem)
                        <div>
                            <h2 class="pb-4">{{ $cartItem['name'] }}</h2>
                        </div>
                        <div>
                            <form action="{{ route('updateCartItem', $index) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <p>
                                    Quantity:
                                    <x-text-input class="w-16" type="number" name="quantity" value="{{ $cartItem['quantity'] }}" min="1" max="99"/>
                                    <x-secondary-button type="submit">Update</x-secondary-button>
                                </p>
                            </form>
                        </div>
                        <div  class="text-center">
                            <p class="pb-4">Price: {{ $cartItem['price'] }} €</p>
                        </div>
                        <div class="text-right">
                            <form action="{{ route('removeFromCart', $index) }}" method="POST">
                                @csrf
                                @method('POST')
                                <x-danger-button class="text-right" type="submit">X</x-danger-button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="pt-16">
                    <p class="m-4 font-bold">total sum: {{ $total }} €</p>
                    <div class="m-4 font-bold flex flex-row justify-between">
                        <a href="{{ route('records') }}">
                            <x-secondary-button>Back to shopping</x-secondary-button>
                        </a>
                        <form action="{{ route('checkout.checkout') }}" method="POST">
                            @csrf
                            <x-secondary-button type="submit">
                                Checkout
                            </x-secondary-button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            @else
        <div>
            <div class="my-4 mx-6">
                <p class="my-2">No items in cart</p>
                <a href="{{ route('records') }}">
                    <x-secondary-button>
                        Back to shopping
                    </x-secondary-button>
                </a>
            </div>
        </div>
            @endif
    </div>

</x-app-layout>