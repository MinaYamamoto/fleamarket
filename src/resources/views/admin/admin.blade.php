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
<div class="admin__ttl">
    <h2 class="admin__header">管理者画面</h2>
</div>
<div class="admin">
    <div class="admin__menu">
        <div class="admin__link">
            <a class="admin-user__link" href="/admin/user">ユーザ削除</a>
        </div>
        <div class="admin__link">
            <a class="admin-comment__link" href="/admin/comment">コメント削除</a>
        </div>
        <div class="admin__link">
            <a class="admin-mail__link" href="/admin/maillist">メール送信</a>
        </div>
    </div>
</div>
@endsection