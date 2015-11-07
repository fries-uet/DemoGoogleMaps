@extends('layouts.master')

@section('title')
    <title>Demo chat bot</title>
@endsection

@section('content')
    <h1>Chat bot demo</h1>
    <span class="hidden" id="url_ajax" data-url="{{ $api[1] }}"></span>
    <div class="input-group">
        <input type="text" class="form-control" id="text_chat" size="50">
        <span class="input-group-btn">
            <button class="btn btn-default btn-primary" type="button" id="btn_chat">Chat</button>
        </span>
    </div>
    <div style="padding-top: 20px;">
        <a style="font-weight: bold;" class="text-center" href="{{ route('bot') }}" title="List question &
            answer">List question &
            answer</a>
    </div>
    <div id="content_chat"></div>
@endsection

@section('script')
    <script src="{{ url('/') }}/assets/js/chat.js"></script>
@endsection