@extends('layouts.master')

@section('title')
    <title>Question & Answer</title>
@endsection

@section('content')
    <h1 class="title">Question & answer</h1>
    <h3 class="text-center"><a href="{{ route('bot.chat') }}">Chat demo</a></h3>
    <div class="row">
        <div class="col-md-2 pull-right">
            <select id="filter_date" name="filter_date" class="form-control">
                <option value="all">All</option>
                <option value="today">Today</option>
            </select>
        </div>
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
            <tr class="qa" data-date="{{ date_create($question->created_at)->format('d/m/Y') }}">
                <td class="text-center">{{ ($index + 1)  }}</td>
                <td class="question">{!! $question->question !!}</td>
                <td class="answer">{!! $question->answer !!}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('script')
    <script>
        var f_today = "{{ date_create()->format('d/m/Y') }}";
    </script>
    <script src="{{ url('/') }}/assets/js/chat.js"></script>
@endsection