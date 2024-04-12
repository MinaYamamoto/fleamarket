<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/payment.css') }}">
</head>
<body>
    <header class="header">
        <div class="header__inner"></div>
    </header>

    <main>
        <div class="payment-title">
            <h2 class="payment-title__header">支払い方法の変更</h2>
        </div>
        <form action="/purchase/{{ $item_id }}/payment" method="post">
            @csrf
            <div class="payment">
                <div class="payment__method">
                    <label class="payment__method-item"><input type="radio" name="payment_method" value="card" checked>カード決済</label>
                    <label class="payment__method-item"><input type="radio" name="payment_method" value="konbini">コンビニ決済</label>
                    <label class="payment__method-item"><input type="radio" name="payment_method" value="bank">銀行決済</label>
                </div>
                <div class="form__button">
                    <button class="form__button-submit" type="submit">変更する</button>
                </div>
            </div>
        </form>
    </main>
</body>
</html>