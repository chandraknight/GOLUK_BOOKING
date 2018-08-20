<form action="{{route('stripePayment')}}"  method="POST">
    {{csrf_field()}}
    <input type="hidden" name="id" value="{{ $booking->id }}">
    <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_PUB_KEY') }}"
            data-amount="{{$invoice->amount}}"
            data-name="TRAVEL.COM"
            data-description="Pay for your bookings"
            data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
            data-locale="auto"
            data-currency="usd">
    </script>

</form>