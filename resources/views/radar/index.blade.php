<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Radar') }}
        </h2>
    </x-slot>
    <link href="https://js.radar.com/v4.1.18/radar.css" rel="stylesheet">
    <script src="https://js.radar.com/v4.1.18/radar.min.js"></script>
    <div id="map" style="width: 100%; height: 500px;" />
    <div><p id="info"></p></div>
</x-app-layout>
<script type="text/javascript">
    Radar.initialize('prj_live_pk_d48531f2f7b0cb891191f7819fd060199596063d');

    // create a map
    const map = Radar.ui.map({
      container: 'map',
      style: 'radar-default-v1',
      center: [25.103546459008548, 58.955730932345226], // NYC
      zoom: 7
    });
/*
    // add a marker to the map
    const marker = Radar.ui.marker({ text: 'Kuressaare Linnus' })
      .setLngLat([22.47910733785186, 58.24740279451225])
      .addTo(map);
      */
     // Create and add markers to the map
     /*
const markers = [
    { text: 'Linnus', lngLat: [22.47910733785186, 58.24740279451225] },
    { text: 'Ametikool', lngLat: [22.483142672127826, 58.256426010099986] },
    { text: 'Nooruse kool', lngLat: [22.498307563131316, 58.248570227137044] }
];*/
const markers = {!! json_encode($markers) !!};
/*
markers.forEach(markerInfo => {
    const marker = Radar.ui.marker({ text: markerInfo.text })
        .setLngLat(markerInfo.lngLat)
        .addTo(map);
});*/
markers.forEach(markerInfo => {
    const marker = Radar.ui.marker({ text: markerInfo.description })
        .setLngLat([markerInfo.lng, markerInfo.lat]) // Adjust the order of lng and lat if needed
        .addTo(map);
});

      // Define a function to handle the click event on the map
map.on('onclick', function(e) {
    // Show a form or modal to capture marker information
    // For simplicity, let's assume you have a form with id, name, and description fields
    
    // Once the form is submitted, send an AJAX request to the Laravel backend
    $.ajax({
        url: '/radar',
        method: 'POST',
        data: {
            latitude: e.latlng.lat,
            longitude: e.latlng.lng,
            name: $('#name').val(),
            description: $('#description').val(),
            // Add other marker details here if needed
            _token: '{{ csrf_token() }}'
        },
        success: function(response) {
            // Handle success response
            // You can update the map to show the new marker
        },
        error: function(xhr, status, error) {
            // Handle error response
        }
    });
});
map.on('mousemove', function (e) {
        document.getElementById('info').innerHTML =
            // e.point is the x, y coordinates of the mousemove event relative
            // to the top-left corner of the map
            JSON.stringify(e.point) +
            '<br />' +
            // e.lngLat is the longitude, latitude geographical position of the event
            JSON.stringify(e.lngLat.wrap());
    });
</script>

</script>