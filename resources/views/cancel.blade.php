<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checkout') }}
            </h2>
        </x-slot>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="m-6">
                        <h1 class="font-bold">Checkout canceled</h1>
                        <p class="my-2">
                            Forgot to add something to your cart? Shop around then come back to pay!
                        </p>
                    </div>
                    <div class="my-4 mx-6">
                    <a href="{{ route('records') }}"><x-secondary-button>Back to shopping</x-secondary-button></a>
                </div>
                </div>
            </div>
        </div>
    </x-app-layout>