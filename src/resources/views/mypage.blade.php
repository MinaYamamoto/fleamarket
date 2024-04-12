@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">
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
<div class="mypage">
    <div class="user__profile">
        <div class="user__image">
            <img class="user__img" src="{{$profile->profile_image}}">
        </div>
        <div class="user__name">
            <span>{{optional(auth()->user())->name}}</span>
        </div>
        <div class="user__link">
            <form action="/mypage/profile/{{optional(auth()->user())->id}}" method="post">
                @csrf
                <button class="user__link__profile" type="submit">プロフィールを編集</button>
            </form>
        </div>
    </div>
    <div class="mypage__tabs">
        <button class="tab__link" onclick="openTab(event, 'tab1')" data-tab="tab1">出品した商品</button>
        <button class="tab__link" onclick="openTab(event, 'tab2')" data-tab="tab2">購入した商品</button>
    </div>
    <hr>
    <div class="card__list" id="tab1">
        @foreach($items as $item)
        <div class="card">
            <div class="card__item">
                <a href="/item/{{$item->id}}"><img class="card__img" src="{{ $item->image }}" alt="item"></a>
            </div>
            <div class="card__txt">
                <p class="card__item-price">&yen;{{number_format($item->price) }}</p>
            </div>
        </div>
        @endforeach
    </div>
    <div class="card__list" id="tab2">
        @foreach($purchases as $purchase)
        <div class="card">
            <div class="card__item">
                <a href="/item/{{ $purchase->item->id }}"><img class="card__img" src="{{ $purchase->item->image }}" alt="item"></a>
            </div>
            <div class="card__txt">
                <p class="card__item-price">&yen;{{number_format($purchase->item->price) }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
<script src="{{ mix('js/tab.js')}}"></script>
@endsection