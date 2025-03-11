<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Form</title>
</head>
<body>
    <h1>Make a Payment</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <label for="card_number">Card Number:</label>
        <input type="text" name="card_number" id="card_number" placeholder="4242424242424242" required><br><br>

        <label for="expiry_month">Expiry Month:</label>
        <input type="text" name="expiry_month" id="expiry_month" placeholder="12" required><br><br>

        <label for="expiry_year">Expiry Year:</label>
        <input type="text" name="expiry_year" id="expiry_year" placeholder="2025" required><br><br>

        <label for="cvc">CVC:</label>
        <input type="text" name="cvc" id="cvc" placeholder="123" required><br><br>

        <button type="submit">Pay $10.00</button>
    </form>
</body>
</html>