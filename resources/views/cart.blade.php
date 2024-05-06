<x-app-layout>
    <h1>Shopping Cart</h1>
    <div class="cart">
        @foreach($cartItems as $cartItem)
            <div class="cart-item">
                <h2>{{ $cartItem->name }}</h2>
                <!-- Display other cart item details -->
            </div>
        @endforeach
    </div>
</x-app-layout>