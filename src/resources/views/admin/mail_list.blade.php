@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/mail_list.css') }}">
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
<div class="mail-list">
    <div class="back__link">
        <a href="/admin" class="back__top">TOPへ戻る</a>
    </div>
    <div class="mail-list__ttl">
        <h3 class="mail-list__header">メール送信（アドレス一覧）</h3>
    </div>
    <div class="mail-list-table">
        <table class="mail-list-table__inner">
            <tr class="mail-list-table__row">
                <th class="mail-list-table__header">ユーザー</th>
                <th class="mail-list-table__header">メールアドレス</th>
            </tr>
            @foreach($users as $user)
            <tr class="mail-list-table__row">
                <td class="mail-list-table__item">{{$user->name}}</td>
                <td class="mail-list-table__item">{{$user->email}}</td>
                <td class="mail-list-table__item">
                    <div class="delete-form__button">
                        <form action="/admin/mail" method="post">
                            @csrf
                            <button class="delete-form__button-submit" type="submit">メール送信</button>
                            <input type="hidden" name="user_name" value="{{$user->name}}">
                            <input type="hidden" name="user_email" value="{{$user->email}}">
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection