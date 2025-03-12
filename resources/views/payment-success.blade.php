<!DOCTYPE html>
<html>
<head>
    <title>Payment Successful</title>
</head>
<body>
    <h1>Payment Successful! </h1>
    <p>Thank you for your payment, {{ $name }}!</p>
    <p>Details:</p>
    <ul>
        <li>Amount: LKR {{ number_format($amount, 2) }}</li>
        <li>Email: {{ $email }}</li>
    </ul>
    <a href="/payment">Make another payment</a>
</body>
</html>