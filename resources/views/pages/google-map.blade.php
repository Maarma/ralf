@extends('layouts.main')
@section('script')
<script>
        mapboxgl.accessToken = 'pk.eyJ1Ijoic2tpcHBlcmhvYSIsImEiOiJjazE2MjNqMjkxMTljM2luejl0aGRyOTAxIn0.Wyvywisw6bsheh7wJZcq3Q';
        var map = new mapboxgl.Map({
          container: 'map',
          style: 'mapbox://styles/mapbox/streets-v11',
          center: [22.4679529, 58.2590756], //lng,lat 10.818746, 106.629179
          zoom: 6
        });
        var test ='<?php echo $dataArray;?>';  //ta nhận dữ liệu từ Controller
        var dataMap = JSON.parse(test); //chuyển đổi nó về dạng mà Mapbox yêu cầu

        // ta tạo dòng lặp để for ra các đối tượng
        dataMap.features.forEach(function(marker) {

            //tạo thẻ div có class là market, để hồi chỉnh css cho market
            var el = document.createElement('div');
            el.className = 'marker';

            //gắn marker đó tại vị trí tọa độ
            new mapboxgl.Marker(el)
                .setLngLat(marker.geometry.coordinates)
                .setPopup(new mapboxgl.Popup({ offset: 25 }) // add popups
            .setHTML('<h3>' + marker.properties.title + '</h3><p>' + marker.properties.description + '</p>'))
                .addTo(map);
        });

    </script>
    <style>
        #map {
            width: 100%;
            height: 400px;
        }
        .marker {
            background-image: url("/assets/images/point.png");
            background-repeat:no-repeat;
            background-size:100%;
            width: 50px;
            height: 100px;
            cursor: pointer; 
        }
</style>
@endsection
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2>Google Map</h2>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
           <form action="{{route('google.map.store')}}" method="post" id="boxmap">
           @csrf
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" placeholder="Title" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="title">Description</label>
                    <input type="text" name="description" placeholder="Description" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="lat">lat</label>
                    <input type="text" name="lat" placeholder="lat" class="form-control"/>
                </div>
                <div class="form-group">
                    <label for="lng">lng</label>
                    <input type="text" name="lng" placeholder="lng" class="form-control"/>
                </div>
                <div class="form-group">
                    <input type="submit" name="submit" value="Add Map" class="btn btn-success"/>
                </div>
            </form>
        </div>
        <div class="col-md-8">
            <h2>Show google Map</h2>
            <div id="map"></div>       
        </div>
    </div>
</div>
@endsection