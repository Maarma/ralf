<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Radar') }}
        </h2>
    </x-slot>

    <div>
        <p class="flex justify-center">double click to add marker</p>
        <link href="https://js.radar.com/v4.1.18/radar.css" rel="stylesheet">
        <script src="https://js.radar.com/v4.1.18/radar.min.js"></script>
        <div id="map" style="width: 100%; height: 500px;" />
        <div>
            <p id="info">
                
            </p>
        </div>
    </div>
    <div id="popupModal" class="fixed inset-0 z-50 overflow-auto bg-gray-900 bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-8 rounded-lg">
            <form id="markerForm" method="POST" action="{{ route('radar.create') }}">
            @csrf
            @method('post')
                <x-input-label for="title" value="Title" />
                <x-text-input
                    value="" required
                    name="title"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <x-input-error :messages="$errors->get('title')" class="mt-2" />
                <x-input-label for="lat" value="Latitude" />
                <x-text-input id="lat" readonly
                    value=""
                    name="lat"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <x-input-error :messages="$errors->get('lat')" class="mt-2" />
                <x-input-label for="lng" value="Longitude" />
                <x-text-input id="lng" readonly
                    value=""
                    name="lng"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <x-input-error :messages="$errors->get('lng')" class="mt-2" />
                <x-input-label for="description" value="Description" />
                <x-text-input
                    value="" required
                    name="description"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                />
                <x-input-error :messages="$errors->get('description')" class="mt-2" />
            </form>
            <div class="mt-4 space-x-2">
                <x-secondary-button type="submit" form="markerForm">{{ __('Save') }}</x-secondary-button>
                <x-danger-button onclick="hidePopupModal()">Cancel</x-danger-button>
            </div>
        </div>
    </div>

</x-app-layout>

<script type="text/javascript">

    const appKey = {!! json_encode($apiKey) !!}
    Radar.initialize(appKey);

    // create a map
    const map = Radar.ui.map({
      container: 'map',
      style: 'radar-default-v1',
      center: [25.103546459008548, 58.955730932345226], // NYC
      zoom: 7
    });

const markers = {!! json_encode($markers) !!};

markers.forEach(markerInfo => {
    const marker = Radar.ui.marker({ text: markerInfo.description })
        .setLngLat([markerInfo.lng, markerInfo.lat]) // Adjust the order of lng and lat if needed
        .addTo(map);
});

map.on('dblclick', function(e) {
    // Retrieve coordinates
    var clickedLatLng = e.lngLat;
        var lat = clickedLatLng.lat;
        var lng = clickedLatLng.lng;
        console.log('Clicked coordinates:', clickedLatLng);
        // Show the modal
        document.getElementById('popupModal').classList.remove('hidden');
        // Display pop-up form at clicked coordinates
        displayPopupModal(lat, lng);
});

    // Function to display the pop-up modal at given coordinates
    function displayPopupModal(lat, lng) {
        var latInput = document.getElementById('lat');
        var lngInput = document.getElementById('lng');

        if (latInput && lngInput) {
            latInput.value = lat;
            lngInput.value = lng;

            
        } else {
            console.error("Latitude or longitude input element not found.");
        }
    }

    // Function to hide the modal
    function hidePopupModal() {
        document.getElementById('popupModal').classList.add('hidden');
    }
</script>