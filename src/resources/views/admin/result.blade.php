@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/result.css') }}">
@endsection

@section('header')
<div class="header__link">
    <div class="header__link-inner">
        <form class="form" action="/logout" method="post">
            @csrf
            <button class="header__link-logout">ログアウト</button>
        </form>
    </div>
</div>
@endsection

@section('content')
<div class="result__content">
    <div class="result__msg">
        <p class="msg__txt">メールは送信されました</p>
    </div>
    <div class="form__button">
        <a class="form__button-submit" href="/admin" type="submit">戻る</a>
    </div>
</div>
@endsection