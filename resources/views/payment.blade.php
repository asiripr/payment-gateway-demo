<!DOCTYPE html>
<html lang="en">
<head>
    <!-- ... existing head content ... -->
</head>
<body>
    <h1>Make a Payment</h1>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <form action="{{ route('payment.process') }}" method="POST">
        @csrf
        <div>
            <label for="name">Full Name:</label>
            <input type="text" name="name" id="name" required value="{{ old('name') }}">
        </div>
        
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required value="{{ old('email') }}">
        </div>
        
        <div>
            <label for="amount">Amount (LKR):</label>
            <input type="number" name="amount" id="amount" min="1" step="0.01" required value="{{ old('amount') }}">
        </div>

        <button type="submit">Pay Now</button>
    </form>
</body>
</html>