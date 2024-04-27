@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/mail.css') }}">
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
<div class="admin">
    <h2 class="admin__header">管理者画面</h2>
</div>
<div class="mail">
    <div class="back__link">
        <a href="/admin" class="back__top">TOPへ戻る</a>
    </div>
    <div class="mail__ttl">
        <h3 class="mail__header">メール送信</h3>
    </div>
    <div class="mail__send">
        <form class="mail__form" action="/admin/mail/execute" method="post">
            @csrf
            <div class="form-group">
                <label class="form-group__label" for="name">名前（必須）</label>
                <div class="form__group-content">
                    <input type="text" class="form-group__txt" id="name" name="name" value="{{!empty(old('name')) ? old('name') : $user_name}}">
                </div>
            </div>
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
            <div class="form-group">
                <label class="form-group__label" for="email">宛先（必須）</label>
                <div class="form__group-content">
                    <input type="text" class="form-group__txt" id="email" name="email" value="{{!empty(old('email')) ? old('email') : $user_email}}">
                </div>
            </div>
            <div class="form__error">
                @error('email')
                {{ $message }}
                @enderror
            </div>
            <div class="form-group">
                <label class="form-group__label" for="subject">件名（必須）</label>
                <div class="form__group-content">
                    <input type="text" class="form-group__txt" id="subject" name="subject" value="{{old('subject')}}">
                </div>
            </div>
            <div class="form__error">
                @error('subject')
                {{ $message }}
                @enderror
            </div>
            <div class="form-group">
                <label class="form-group__label" for="txt">本文</label>
                <div class="form__group-content">
                    <textarea class="form-group__txtarea" id="txt" name="txt" rows="7">{{old('txt')}}</textarea>
                </div>
            </div>
            <div class="form__error">
                @error('body')
                {{ $message }}
                @enderror
            </div>
            <div class="form__button">
                <button class="form__button-submit" name="submit" type="submit" >送信</button>
            </div>
        </form>
    </div>
</div>
@endsection