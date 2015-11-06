@extends('layouts.master');

@section('title')
    <title>Setup bot chat</title>
@endsection

@section('content')
    <h1><a href="{{ route('web.bot.setup') }}">Setup bot chat</a></h1>
    @if (isset($updated))
        @if($updated == 'error')
            <div class="alert alert-danger">
                Something went wrong!
            </div>
        @elseif($updated == 'success')
            <div class="alert alert-success">
                Updated success!
            </div>
        @endif
    @endif
    <form role="form" method="POST">
        <div class="form-group">
            <label for="bot_id">Bot</label>
            <select id="bot_id" name="bot_id" class="form-control">
                @foreach($bots as $bot)
                    @if($bot->id == $bot_id)
                        <option selected="selected" value="{{ $bot->id }}">{{ $bot->name }}</option>
                    @else
                        <option value="{{ $bot->id }}">{{ $bot->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control">
            {{ csrf_field() }}
        </div>
        <div class="form-group">
            <button class="btn btn-primary btn-block" type="submit" id="btn_submit">Save</button>
        </div>
    </form>
@endsection