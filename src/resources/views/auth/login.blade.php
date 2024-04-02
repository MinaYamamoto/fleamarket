@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="login__content">
    <div class="login__heading">
        <h2 class="login__heading-ttl">ログイン</h2>
    </div>
    <form class="login__form" action="/login" method="post">
        @csrf
        <div class="form__group-content">
            <div class="form__ttl">
                <label class="form__ttl-label">メールアドレス</label>
            </div>
            <div class="form__input">
                <input class="form__input-text" type="text" name="email" value="{{ old('email') }}">
            </div>
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__group-content">
            <div class="form__ttl">
                <label class="form__ttl-label">パスワード</label>
            </div>
            <div class="form__input">
                <input class="form__input-text" type="password" name="password">
            </div>
            <div class="form__error">
                @error('password')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">ログインする</button>
        </div>
        <div class="form__link">
            <a class="form__link__register" href="/register">会員登録はこちら</a>
        </div>
    </form>
</div>
@endsection