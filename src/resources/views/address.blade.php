<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/address.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    <main>
        <div class="address-title">
            <h2 class="address-title__header">住所の変更</h2>
        </div>
        <form action="/purchase/address/{{optional(auth()->user())->id}}" method="post">
            @method('PATCH')
            @csrf
            <div class="address-item__inner">
                <div class="address-item">
                    <h3 class="address-item__header">郵便番号</h3>
                    <div class="change-address">
                        <input class="change-address__txt" type="txt" name="post_code" value="{{$profile->post_code}}">
                    </div>
                    <div class="form__error">
                        @error('post_code')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="address-item">
                    <h3 class="address-item__header">住所</h3>
                    <div class="change-address">
                        <input class="change-address__txt" type="txt" name="address" value="{{$profile->address}}">
                    </div>
                    <div class="form__error">
                        @error('address')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="address-item">
                    <h3 class="address-item__header">建物名</h3>
                    <div class="change-address">
                        <input class="change-address__txt" type="txt" name="building" value="{{$profile->building}}">
                    </div>
                    <div class="form__error">
                        @error('building')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">更新する</button>
                    <input type="hidden" name="id" value="{{$profile->id}}">
                </div>
            </div>
        </form>
    </main>
</body>
</html>