<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Gateway Demo</title>
</head>
<body>
    <h1>Welcome Eco mart fresh vegitable house</h1>
    <form action="{{ url('/payment') }}" method="GET">
        <button type="submit">
            Payment
        </button>
    </form>
</body>
</html>