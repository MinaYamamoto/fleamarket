    @extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('header')
<div class="header__search">
    <form class="search-form" method="get">
        @csrf
        <div class="search-form__inner">
            <input class="search-form__txt" placeholder=" なにをお探しですか？">
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
<div class="purchase">
    <div class="detail">
        <div class="detail__flex">
            <div class="img">
                <div class="img__inner">
                    <img class="img__item"  src="{{ $item->image }}" alt="item">
                </div>
            </div>
            <div class="detail__explanation">
                <div class="detail__item">
                    <span class="detail__item-name">商品名</span>
                </div>
                <div class="detail__item">
                    <span class="detail__item-price">&yen;{{number_format($item->price) }}</span>
                </div>
            </div>
        </div>
        <div class="pay__flex">
            <div class="pay__ttl">
                <h2 class="pay__heading">支払い方法</h2>
            </div>
            <div class="pay__link">
                <a class="pay-change__link" href="#">変更する</a>
            </div>
        </div>
        <div class="address__flex">
            <div class="address__ttl">
                <h2 class="address__heading">配送先</h2>
            </div>
            <div class="address__link">
                <form action="/purchase/address/{{optional(auth()->user())->id}}" method="post">
                    @csrf
                    <button class="address-change__link" type="submit">変更する</button>
                </form>
            </div>
        </div>
        <div class="shipping-address">
            <p class="shipping-address__post-code">{{$post_code}}</p>
            <p class="shipping-address__address">{{$profile->address}}</p>
            <p class="shipping-address__building">{{$profile->building}}</p>
        </div>
    </div>
    <div class="pay">
        <div class="line">
        <div class="pay__detail">
            <div class="pay__detail-item">
                <div class="pay__detail-ttl">
                    <label class="pay__detail-label">商品代金</label>
                </div>
                <div class="item__price">
                    <span>&yen;{{number_format($item->price) }}</span>
                </div>
            </div>
        </div>
        <div class="pay__detail">
            <div class="pay__detail-item">
                <div class="pay__detail-ttl">
                    <label class="pay__detail-label">支払い金額</label>
                </div>
                <div class="pay__price">
                    <span>&yen;{{number_format($item->price) }}</span>
                </div>
            </div>
        </div>
        <div class="pay__detail">
            <div class="pay__detail-item">
                <div class="pay__detail-ttl">
                    <label class="pay__detail-label">支払い方法</label>
                </div>
                <div class="method__payment">
                    <span>コンビニ</span>
                </div>
            </div>
        </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">購入する</button>
        </div>
    </div>
</div>
@endsection