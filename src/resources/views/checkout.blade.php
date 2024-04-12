<p>決済ページへリダイレクトします。</p>
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripe_public_key = "{{ config('services.stripe.stripe_public_key') }}"
    const stripe = Stripe(stripe_public_key);
    window.onload = function() {
        stripe.redirectToCheckout({
            sessionId: '{{ $session->id }}'
        }).then(function (result) {
            window.location.href = 'http://localhost/index'
        });
    }
</script>