@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
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
@guest
<div class="header__link">
    <div class="header__link-inner">
        <a href="/login" class="header__link-item">ログイン</a>
    </div>
    <div class="header__link-inner">
        <a href="/register" class="header__link-item">会員登録</a>
    </div>
</div>
@endguest
@if (Auth::check())
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
@endif
<div class="header__listing">
    <a href="/sell" class="header__listing-link">出品</a>
</div>
@endsection

@section('content')
<div class="detail">
    <div class="img">
        <div class="img__inner">
            <img class="img__item" src="{{ $item->image }}" alt="item">
        </div>
    </div>
    <div class="detail__explanation">
        <div class="detail__item">
            <h2 class="detail__ttl">{{$item->name}}</h2>
            <div class="detail__item-name">{{$item->brand_name}}</div>
        </div>
        <div class="detail__item">
            <span class="detail__item-price">&yen;{{number_format($item->price) }}(値段)</span>
        </div>
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
                    <button class="comment__button" onclick="location.href='/comment/{{ $item['id'] }}'">
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
        <form action="/purchase/{{$item['id']}}" method="get">
            @csrf
            <div class="form__button">
                <button class="form__button-submit" type="submit">購入する</button>
            </div>
        </form>
        <div class="detail__item">
            <h2 class="detail__ttl">商品説明</h2>
            <div>
                <pre class="detail__item-explanation">{{$item->explanation}}</pre>
            </div>
        </div>
        <div class="detail__item">
            <h2 class="detail__ttl">商品の情報</h2>
            <div class="detail__flex">
                <div class="detail__label-wrapper">
                    <label class="detail__label">カテゴリー</label>
                </div>
                <div class="detail__category-tags">
                    <div>
                        <span class="detail__category-tag">{{$category->name}}</span>
                    </div>
                    <div>
                        <span class="detail__category-tag">{{$content->name}}</span>
                    </div>
                </div>
            </div>
            <div class="detail__flex">
                <div class="detail__label-wrapper">
                    <label class="detail__label">商品の状態</label>
                </div>
                <div class="detail__condition-tags">
                    <span class="detail__condition-tag">{{$item['condition']['name']}}</span>
                </div>
        </div>
    </div>
</div>
@endsection