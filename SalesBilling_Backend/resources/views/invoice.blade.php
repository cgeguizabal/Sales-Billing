<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $sale->id }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 14px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        .total { text-align: right; }
    </style>
</head>
<body>
    <h2>Invoice #{{ $sale->id }}</h2>
    <p>Customer: {{ $sale->customer->name }}</p>
    <p>Date: {{ $sale->sale_date ?? now() }}</p>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->details as $detail)
            <tr>
                <td>{{ $detail->product->name }}</td>
                <td>{{ $detail->quantity }}</td>
                <td>${{ number_format($detail->unit_price, 2) }}</td>
                <td>${{ number_format($detail->quantity * $detail->unit_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="total">Subtotal: ${{ number_format($sale->total_before_iva, 2) }}</p>
    <p class="total">IVA (13%): ${{ number_format($sale->IVA, 2) }}</p>
    <p class="total"><strong>Total: ${{ number_format($sale->total_sale, 2) }}</strong></p>
</body>
</html>
