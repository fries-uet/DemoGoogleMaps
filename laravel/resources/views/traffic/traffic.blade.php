@extends('layouts.master')

@section('title')
    <title>All traffic today</title>
@endsection

@section('content')
    <table class="table table-responsive table-hover table-condensed table-striped">
        <thead>
        <tr>
            <th class="text-center">STT</th>
            <th>Type</th>
            <th>Address</th>
            <th>Time ago</th>
        </tr>
        </thead>
        <tbody>
        @foreach($traffics as $i => $t)
            <tr class="status">
                <td class="text-center">{{ ($i + 1)  }}</td>
                <td class="type">{!! convertStatusTrafficToVietnamese($t->type) !!}</td>
                <td class="address">{!! $t->name !!}</td>
                <td class="time_ago">{!! $t->ago_text !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection