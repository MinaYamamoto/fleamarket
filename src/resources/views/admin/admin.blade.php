@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}">
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
<div class="admin-tab">
    <button class="tab__button" onclick="openTab(event, 'tab1')" data-tab="tab1">ユーザー</button>
    <button class="tab__button" onclick="openTab(event, 'tab2')" data-tab="tab2">コメント</button>
    <button class="tab__button" onclick="openTab(event, 'tab3')" data-tab="tab3">メール</button>
</div>
<hr>
<div class="tab__link" id="tab1">
    <div class="user">
        <h3 class="user__header">ユーザー一覧</h3>
    </div>
    <div class="user-table">
        <table class="user-table__inner">
            <tr class="user-table__row">
                <th class="user-table__header">ユーザー</th>
                <th class="user-table__header">メールアドレス</th>
            </tr>
            <tr class="user-table__row">
                <td class="user-table__item">ユーザ名</td>
                <td class="user-table__item">ex@example.com</td>
                <td class="user-table__item">
                    <form class="delete-form">
                        <div class="delete-form__button">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="tab__link" id="tab2">
    <div class="comment">
        <h3 class="comment__header">コメント一覧</h3>
    </div>
    <div class="comment-table">
        <table class="comment-table__inner">
            <tr class="comment-table__row">
                <th class="comment-table__header">ユーザー名</th>
                <th class="comment-table__header">コメント</th>
            </tr>
            <tr class="comment-table__row">
                <td class="comment-table__item">ユーザ名</td>
                <td class="comment-table__item">コメント内容出力１２３４５６７８９０１２３４５６７８９０１２３４５６７８９０１２３４５６７８９０１２３４５６７８９０</td>
                <td class="comment-table__item">
                    <form class="delete-form">
                        <div class="delete-form__button">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>
<div class="tab__link" id="tab3">
    <div class="mail">
        <h3 class="mail__header">メール送信</h3>
    </div>
    <div class="mail__send">
        <form class="mail__form" action="/admin/mail/confirm" method="post">
            @csrf
            <div class="form-group">
                <label class="form-group__label" for="name">名前（必須）</label>
                <div class="form__group-content">
                    <input type="text" class="form-group__txt" id="name" name="name" value="{{old('name')}}">
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
                    <input type="text" class="form-group__txt" id="email" name="email" value="{{old('email')}}">
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
                <button class="form__button-submit" name="submit" type="submit" >
                    送信
                </button>
            </div>
        </form>
    </div>
</div>
<script src="{{ mix('js/admintab.js')}}"></script>
@endsection