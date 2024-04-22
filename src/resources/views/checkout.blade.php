<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>フリマアプリ</title>
    <link rel="stylesheet" href="{{ asset('css/checkout.css') }}">
</head>

<body>
    <div class="checkout">
        <p class="checkout__txt">決済ページへリダイレクトします。</p>
    </div>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe_public_key = "{{ config('services.stripe.stripe_public_key') }}"
        const stripe = Stripe(stripe_public_key);
        window.onload = function() {
            stripe.redirectToCheckout({
                sessionId: '{{ $session->id }}'
            }).then(function (result) {
                history.back();
            });
        }
    </script>
</body>
</html>