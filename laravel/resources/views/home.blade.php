@extends('layouts.master');

@section('title')
    <title>Fries Maps</title>
@endsection

@section('content')
    <h1 class="title-app">Fries Maps</h1>
    <p class="description">Develop by <strong>UET - Fries</strong>.</p>

    <div class="content">
        <div class="row">
            <div class="col-md-6">
                <h2><a href="{{ route('bot') }}">Chat bot</a></h2>
            </div>
            <div class="col-md-6">
                <h2><a href="{{ route('traffic') }}">Traffic</a></h2>
            </div>
        </div>
    </div>
@endsection