@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
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
<div class="index__tabs">
    <button class="tab__link" onclick="openTab(event, 'tab1')" data-tab="tab1">おすすめ</button>
    <button class="tab__link" onclick="openTab(event, 'tab2')" data-tab="tab2">マイリスト</button>
</div>
<hr>
<div class="card__list" id="tab1">
    @foreach($items as $item)
    <div class="card">
        <div class="card__item">
            <a href="/item/{{ $item->id }}"><img class="card__img" src="{{ $item->image }}" alt="item"></a>
        </div>
            @if(is_null($item->purchase))
            <div class="card__txt">
                <p class="card__txt-price">&yen;{{ number_format($item->price) }}</p>
            </div>
            @else
            <div class="card__txt">
                <p class="card__txt-soldout">SOLDOUT</p>
            </div>
            @endif
    </div>
    @endforeach
</div>
<div class="card__list" id="tab2">
    @foreach($mylists as $mylist)
    <div class="card">
        <div class="card__item">
            <a href="/item/{{$mylist->item_id}}"><img class="card__img" src="{{$mylist ['item'] ['image']}}" alt="item"></a>
        </div>
        @if(is_null($mylist->item->purchase))
        <div class="card__txt">
            <p class="card__txt-price">&yen;{{number_format($mylist->item->price) }}</p>
        </div>
        @else
        <div class="card__txt">
            <p class="card__txt-soldout">SOLDOUT</p>
        </div>
        @endif
    </div>
    @endforeach
</div>
<script src="{{ mix('js/tab.js')}}"></script>
@endsection