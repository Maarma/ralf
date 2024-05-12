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
                    <p class="font-bold text-xl"  id="hoverText">Minumum effort, maximum result!</p>
                </div>
                <div id="dos"></div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
    // Get the <p> element
    var paragraph = document.getElementById("hoverText");
    
    // Define the new text
    var newText = "I work really hard for my epic fails!";
    
    // Add event listener for mouseover
    paragraph.addEventListener("mouseover", function() {
      // Change the text content
      paragraph.textContent = newText;
    });
    
    // Add event listener for mouseout (to revert back)
    paragraph.addEventListener("mouseout", function() {
      // Change the text content back to original
      paragraph.textContent = "Minumum effort, maximum result!";
    });
    </script>
