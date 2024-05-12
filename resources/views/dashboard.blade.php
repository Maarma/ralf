<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
                <div class="p-6">
                    <p class="font-bold text-xl"  id="hoverText">
                        Minumum effort, maximum result!
                    </p>
                </div>
                <div class="m-6">
                    <p>Please use Your personal discound code:</p>
                    <p class="font-bold">ten pesos</p>
                    <p>to get 10€ off from orders</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    
    let paragraph = document.getElementById("hoverText");
    let newText = "I work really hard for my epic fails!";
    
    paragraph.addEventListener("mouseover", function()
    {
        paragraph.textContent = newText;
    });
    
    paragraph.addEventListener("mouseout", function() 
    {
        paragraph.textContent = "Minumum effort, maximum result!";
    });
    </script>
