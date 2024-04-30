@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/comment.css') }}">
<script src="https://kit.fontawesome.com/8b04c7b9b9.js" crossorigin="anonymous"></script>
@endsection

@section('header')
<div class="header-search">
    <form action="/search" class="header-search__form" method="get">
        @csrf
        <div class="header-search__inner">
            <input class="header-search__txt" name="keyword" placeholder=" なにをお探しですか？">
        </div>
    </form>
</div>
<div class="header__link">
    <div class="header__link-inner">
        <form class="form" action="/logout" method="post">
            @csrf
            <button class="header__link-logout">ログアウト</button>
        </form>
    </div>
    <div class="header__link-inner">
        <a href="/mypage" class="header__link-item">マイページ</a>
    </div>
</div>
<div class="header__listing">
    <a href="/sell" class="header__listing-link">出品</a>
</div>
@endsection

@section('content')
<div class="detail">
    <div class="detail__img">
        <div class="detail__inner">
            <img class="detail__img-item" src="{{ $item->image }}" alt="item">
        </div>
    </div>
    <div class="detail__explanation">
        <div class="detail__item">
            <h2 class="detail__ttl">{{$item->name}}</h2>
            <div class="detail__item-name">{{$item->brand_name}}</div>
        </div>
        <div class="detail__item-price">&yen;{{number_format($item->price) }}(値段)</div>
        <div class="detail__item">
            <div class="detail__flex">
                <div class="detail__item-mylist">
                    @if($item->mylist()->where('item_id', $item['id'])->where('user_id', optional(Auth::user())->id)->count() == 1)
                    <form class="mylist-form" action="/mylist/{{ $item['id'] }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="mylist-button__unbookmark">
                            <i class="fa-solid fa-star"></i>
                            @if($mylists->count())
                            <span class="counter">{{$mylists->count()}}</span>
                            @else
                            <span class="counter">0</span>
                            @endif
                        </button>
                    </form>
                    @else
                    <form class="mylist-form" action="/mylist/{{ $item['id'] }}" method="post">
                        @csrf
                        <button class="mylist-button__bookmark">
                            <i class="fa-solid fa-star"></i>
                            @if($mylists->count())
                            <span class="counter">{{$mylists->count()}}</span>
                            @else
                            <span class="counter">0</span>
                            @endif
                        </button>
                    </form>
                    @endif
                </div>
                <div class="detail__item-comment">
                    <button class="comment__button">
                        <i class="fa-regular fa-comment"></i>
                        @if($comments->count())
                        <span class="counter">{{$comments->count()}}</span>
                        @else
                        <span class="counter">0</span>
                        @endif
                    </button>
                </div>
            </div>
        </div>
        <div class="comment">
            @foreach($comments as $comment)
            @if ($comment->user_id === $comment->item->user_id && isset($comment))
            <div class="comment__seller">
                <div class="comment__seller-name">
                    <span class="seller-name">{{$comment['user']['name']}}</span>
                </div>
                @if(is_null($comment->user->profile))
                <div class="comment__img">
                    <img class="comment__user-img" src="{{$profile->profile_image}}">
                </div>
                @else
                <div class="comment__img">
                    <img class="comment__seller-img" src="{{$comment->user->profile->profile_image}}">
                </div>
                @endif
                @if (optional(auth()->user())->id === $comment->user_id)
                <form class="comment-delete__form" action="/comment/{item_id}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="comment-delete__button">
                        <button class="comment-delete__button-submit" type="submit">
                            削除する
                        </button>
                        <input type="hidden" name="id" value="{{$comment->id}}">
                    </div>
                </form>
                @endif
            </div>
            <div class="comment__content">
                <pre class="comment__content-txt">{{$comment->comment}}</pre>
            </div>
            @elseif(isset($comment))
            <div class="comment__user">
                @if(is_null($comment->user->profile))
                <div class="comment__img">
                    <img class="comment__user-img" src="{{$profile->profile_image}}">
                </div>
                @else
                <div class="comment__img">
                    <img class="comment__user-img" src="{{$comment->user->profile->profile_image}}">
                </div>
                @endif
                <div class="comment__user-name">
                    <span class="user-name">{{$comment['user']['name']}}</span>
                </div>
                @if (optional(auth()->user())->id === $comment->user_id)
                <form class="comment-delete__form" action="/comment/{item_id}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="comment-delete__button">
                        <button class="comment-delete__button-submit" type="submit">
                            削除する
                        </button>
                        <input type="hidden" name="id" value="{{$comment->id}}">
                    </div>
                </form>
                @endif
            </div>
            <div class="comment__content">
                <pre class="comment__content-txt">{{$comment->comment}}</pre>
            </div>
            @endif
            @endforeach
        </div>
        <form action="/comment/{{$item['id']}}" method="post">
            @csrf
            <div class="comment__post">
                <h2 class="comment__post-heading">商品へのコメント</h2>
                <textarea name="comment" class="comment__post-txt" cols="50" rows="8">{{old('comment')}}</textarea>
            </div>
            <div class="form__error">
                @error('comment')
                {{ $message }}
                @enderror
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">コメントを送信する</button>
                <input type="hidden" name="user_id" value="{{optional(auth()->user())->id}}">
                <input type="hidden" name="item_id" value="{{$item['id']}}">
            </div>
        </form>
    </div>
</div>
@endsection