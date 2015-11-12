@extends('layouts.master')

@section('title')
    <title>Maps</title>
@endsection

@section('css')
    <style type="text/css">
        #map {
            height: 500px;
        }
    </style>
@endsection

@section('content')
    <div id="map"></div>
@endsection

@section('script')
    <script src="{{ url('/') }}/assets/js/maps.js"></script>
    <script async defer
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBQmanLwsZOg4-XmZR8XSUdJ69TGc4J-SI&callback=initMap">
    </script>
@endsection
