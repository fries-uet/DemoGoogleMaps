@extends('layouts.master')

@section('title')
    <title>All traffic today</title>
@endsection

@section('css')
    <style type="text/css">
        #map {
            height: 500px;
        }
    </style>
@endsection

@section('content')
    <table class="table table-responsive table-hover table-condensed table-striped">
        <thead>
        <tr>
            <th class="text-center">STT</th>
            <th>Type</th>
            <th>Address</th>
            <th>Address report</th>
            <th>Time ago</th>
        </tr>
        </thead>
        <tbody>
        @foreach($traffics as $i => $t)
            <tr class="status">
                <td class="text-center">{{ ($i + 1)  }}</td>
                <td class="type">{!! convertStatusTrafficToVietnamese($t->type) !!}</td>
                <td class="street">{!! $t->name !!}</td>
                <td class="address_report">{!! $t->address_formatted !!}</td>
                <td class="time_ago">{!! $t->ago_text !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div id="map"></div>

@endsection

@section('script')
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQmanLwsZOg4-XmZR8XSUdJ69TGc4J-SI&callback=initMap">
    </script>
    <script>
        var map;
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 21.038993, lng: 105.783799},
                zoom: 13
            });

            addMarker();
        }

        function addMarker() {
            var congestion = '{{ url('/') }}/assets/img/congestion.png';
            var open = '{{ url('/') }}/assets/img/open.png';

            @foreach($traffics as $i => $t)
                myLatLng = {lat: {!! $t->latitude !!}, lng: {!! $t->longitude !!}};
                    @if($t->type == 'congestion')
                var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: '{!!  $t->ago_text !!} trước',
                icon: congestion
            });
                    @else
                        var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                title: '{!!  $t->ago_text !!} trước',
                icon: open
            });
            @endif
        @endforeach



        }
    </script>
@endsection