@extends('layouts.master')

@section('title')
    <title>Question & Answer</title>
@endsection

@section('content')
    <h1>Question & answer</h1>
    <h3 class="text-center"><a href="{{ route('web.bot.chat') }}">Chat demo</a></h3>
    <div class="row">
        <div class="col-md-2 pull-right">
            <select id="filter" name="filter" class="form-control">
                <option value="all">All</option>
                <option value="no">No answer</option>
            </select>
        </div>
    </div>
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
            <tr class="qa">
                <td class="text-center">{{ ($index + 1)  }}</td>
                <td class="question">{!! $question->question !!}</td>
                <td class="answer">{!! $question->answer !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script src="{{ url('/') }}/assets/js/chat.js"></script>
@endsection