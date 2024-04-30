@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endsection

@section('content')
<div class="register__content">
    <div class="register__heading">
        <h2 class="register__heading-ttl">会員登録</h2>
    </div>
    <form class="register__form" action="/register" method="post">
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
            <button class="form__button-submit" type="submit">登録する</button>
            <input type="hidden" name="name" value="未登録">
            <input type="hidden" name="role" value="user">
        </div>
    </form>
    <div class="form__link">
        <a class="form__link__register" href="/login">ログインはこちら</a>
    </div>
</div>
@endsection