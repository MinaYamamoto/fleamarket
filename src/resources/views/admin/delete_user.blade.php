@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/delete_user.css') }}">
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
<div class="user">
    <div class="user__flex">
        <div class="back__link">
            <a href="/admin" class="back__top">TOPへ戻る</a>
        </div>
        <div class="user__ttl">
            <h3 class="user__header">ユーザー一覧</h3>
        </div>
    </div>
    @if (session('user_message'))
    <div class="user-delete__success">
        {{ session('user_message') }}
    </div>
    @endif
    <div class="user-table">
        <table class="user-table__inner">
            <tr class="user-table__row">
                <th class="user-table__header">ユーザー</th>
                <th class="user-table__header">メールアドレス</th>
            </tr>
            @foreach($users as $user)
            <tr class="user-table__row">
                <td class="user-table__item">{{$user->name}}</td>
                <td class="user-table__item">{{$user->email}}</td>
                <td class="user-table__item">
                    <form action="/admin/user/{{ $user->id }}" class="delete-form" method="post">
                        @method('DELETE')
                        @csrf
                        <div class="delete-form__button">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                            <input type="hidden" name="user_id" value="{{ $user->id }}" />
                        </div>
                    </form>
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