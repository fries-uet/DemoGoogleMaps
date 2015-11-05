@extends('layouts.master')

@section('title')
    <title>Question & Answer</title>
@endsection

@section('content')
    <table>
        <thead>
        <tr>
            <th>STT</th>
            <th>Questions</th>
            <th>Answers</th>
        </tr>
        </thead>
        <tbody>
        @foreach( $questions as $index => $question)
            <tr>
                <td>{{ ($index + 1)  }}</td>
                <td>{!! $question->question !!}</td>
                <td>{!! $question->answer !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection