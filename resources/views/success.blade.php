<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
<h1>Payment Successful</h1>
<p>Your payment was successful for order ID: {{ $orderId }}</p>
<p>Status: {{ ucfirst($status) }}</p>
<p>Amount: {{ $amount }} {{ $currency }}</p>
<p>Buyer Email: {{ $email }}</p>
</body>
</html>
