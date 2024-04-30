@extends('layouts.app')

@section('stylesheet')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endsection

@section('header')
<div class="header-search">
    <form class="header-search__form" action="/search" method="get">
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
<div class="profile">
    <div class="profile__ttl">
        <h2 class="profile__heading">プロフィール設定</h2>
    </div>
    <form action="/mypage/profile/{{optional(auth()->user())->id}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <div class="form-group__img">
            <div class="form-group__content-img">
                <img id="profileImage" class="profile__img" src="{{optional(auth()->user())->profile->profile_image}}" alt="プロフィール画像"></img>
            </div>
            <div class="img__button">
                <label for="file-input" class="profile__file-input">画像を選択する</label>
                <input type="file" id="file-input" name="profile_image" class="profile__file" value="{{ Session::get('pforile_image') }}"/>
            </div>
            <div class="form__error">
                @error('profile_image')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__ttl">
                <label class="form-group__label">ユーザ名</label>
            </div>
            <div class="form-group__content">
                <input type="txt" class="form-group__txt" name="name" value="{{optional(auth()->user())->name}}"/>
            </div>
            <div class="form__error">
                @error('name')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__ttl">
                <label class="form-group__label">郵便番号</label>
            </div>
            <div class="form-group__content">
                @if(optional(auth()->user())->profile)
                <input type="txt" class="form-group__txt" name="post_code" value="{{$profile->post_code}}"/>
                @else
                <input type="txt" class="form-group__txt" name="post_code" value="{{old('post_code')}}"/>
                @endif
            </div>
            <div class="form__error">
                @error('post_code')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__ttl">
                <label class="form-group__label">住所</label>
            </div>
            <div class="form-group__content">
                @if(optional(auth()->user())->profile)
                <input type="txt" class="form-group__txt" name="address" value="{{$profile->address}}"/>
                @else
                <input type="txt" class="form-group__txt" name="address" value="{{old('address')}}"/>
                @endif
            </div>
            <div class="form__error">
                @error('address')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class="form-group__ttl">
                <label class="form-group__label">建物名</label>
            </div>
            <div class="form-group__content">
                @if(optional(auth()->user())->profile)
                <input type="txt" class="form-group__txt" name="building" value="{{$profile->building}}"/>
                @else
                <input type="txt" class="form-group__txt" name="building" value="{{old('building')}}"/>
                @endif
            </div>
            <div class="form__error">
                @error('building')
                {{ $message }}
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="form__button-submit" type="submit">更新する</button>
            <input type="hidden" name="user_id" value="{{optional(auth()->user())->id}}"/>
            <input type="hidden" name="profile_id" value="{{$profile->id}}"/>
        </div>
    </form>
</div>
<script src="{{ mix('js/profileimg.js')}}"></script>
@endsection