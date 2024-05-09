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
                                <x-primary-button type="submit">Update</x-primary-button>
                            </p>
                        </form>
                    </div>
                    <div  class="text-center">
                        <p class="pb-4">Price: {{ $cartItem['price'] }} €</p>
                    </div>
                    <div class="text-right">
                        <form action="{{ route('checkout.checkout') }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <x-danger-button class="text-right" type="submit">X</x-danger-button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="pt-16">
                <p class="m-4 font-bold">total sum: {{ $total }} €</p>
                <div class="m-4 font-bold flex flex-row justify-between">
                    <a href="{{ route('records') }}"><x-secondary-button>Back to shopping</x-secondary-button></a>
                    <x-primary-button id="checkout-button">Checkout</x-primary-button>
                </div>
            </div>
        </div>
        </div>
            @else
        <div>
            <p>No items in cart</p>
        </div>
            @endif
    </div>
</x-app-layout>

<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var checkoutButton = document.getElementById('checkout-button');

    checkoutButton.addEventListener('click', function() {
        // Call your backend to create a checkout session and retrieve the session ID
        fetch('/checkout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                total: 1000 // Replace with the total amount in cents
            })
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(session) {
            // Redirect to Stripe checkout
            stripe.redirectToCheckout({
                sessionId: session.id
            }).then(function(result) {
                // Handle any errors
                console.error(result.error.message);
            });
        });
    });
</script>