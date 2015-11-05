@extends('layouts.master')

@section('title')
    <title>Question & Answer</title>
@endsection

@section('content')
    <h1>Question & answer</h1>
    <table class="table table-responsive table-hover table-condensed table-striped">
        <thead>
        <tr>
            <th class="text-center">STT</th>
            <th>Questions</th>
            <th>Answers</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $questions as $index => $question)
            <tr>
                <td class="text-center">{{ ($index + 1)  }}</td>
                <td>{!! $question->question !!}</td>
                <td>{!! $question->answer !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection