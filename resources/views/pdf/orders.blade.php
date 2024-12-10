<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order №{{ $order->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            width: 30%; /* Set width for the left column */
        }

        td {
            width: 70%; /* Set width for the right column */
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
<h1>Order Information №{{ $order->id }}</h1>
<h2>Example row: Testing English text display</h2>

<table>
    <tr>
        <th>ID</th>
        <td>{{ $order->id ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Full Name</th>
        <td>{{ $order->name ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Email</th>
        <td>{{ $order->email ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Phone</th>
        <td>{{ $order->phone_number ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Address</th>
        <td>{{ $order->address ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Delivery Type</th>
        <td>{{ $order->delivery_type_id ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Payment Type</th>
        <td>{{ $order->payment_type_id ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Customer Comment</th>
        <td>{{ $order->customer_comment ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Manager Comment</th>
        <td>{{ $order->manager_comment ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Status</th>
        <td>{{ $order->status ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Total Price</th>
        <td>{{ $order->total_price ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Individual</th>
        <td>{{ $order->is_fiz ? 'Yes' : 'No' }}</td>
    </tr>
    <tr>
        <th>Created At</th>
        <td>{{ $order->created_at ?? 'No data' }}</td>
    </tr>
    <tr>
        <th>Updated At</th>
        <td>{{ $order->updated_at ?? 'No data' }}</td>
    </tr>
</table>
</body>
</html>
