<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/success.css') }}">
</head>

<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    <main>
        <div class="success">
            <div class="success__comment">
                <p>購入が完了しました</p>
            </div>
            <form action="/purchase/{{ $item_id }}/payment/success" method="post">
                @csrf
                <div class="form__button">
                    <button class="form__button-link" type="submit">トップページへ戻る</button>
                </div>
            </form>
        </div>
    </main>
</body>

</html>