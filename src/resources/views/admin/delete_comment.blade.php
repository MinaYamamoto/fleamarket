@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/delete_comment.css') }}">
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
<div class="comment">
    <div class="comment__flex">
        <div class="back__link">
            <a href="/admin" class="back__top">TOPへ戻る</a>
        </div>
        <div class="comment__ttl">
            <h3 class="comment__header">コメント一覧</h3>
        </div>
    </div>
    @if (session('comment_message'))
    <div class="comment-delete__success">
        {{ session('comment_message') }}
    </div>
    @endif
    <div class="comment-table">
        <table class="comment-table__inner">
            <tr class="comment-table__row">
                <th class="comment-table__header">ユーザー名</th>
                <th class="comment-table__header">コメント</th>
            </tr>
            @foreach($comments as $comment)
            <tr class="comment-table__row">
                <td class="comment-table__item">{{$comment->user->name}}</td>
                <td class="comment-table__item">{{$comment->comment}}</td>
                <td class="comment-table__item">
                    <form action="/admin/comment/{{ $comment->id }}"class="delete-form" method="post">
                        @method('DELETE')
                        @csrf
                        <div class="delete-form__button">
                            <button class="delete-form__button-submit" type="submit">削除</button>
                            <input type="hidden" name="comment_id" value="{{ $comment->id }}" />
                        </div>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="pagination">
            {{$comments->links()}}
        </div>
    </div>
</div>
@endsection