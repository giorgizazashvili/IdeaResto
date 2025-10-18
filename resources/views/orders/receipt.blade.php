<!DOCTYPE html>
<html lang="ka">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ანგარიში #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }

        .receipt {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #333;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .info-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding: 15px;
            background: #f9f9f9;
            border-radius: 5px;
        }

        .info-block {
            flex: 1;
        }

        .info-block h3 {
            font-size: 14px;
            color: #666;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-block p {
            font-size: 16px;
            color: #333;
            margin-bottom: 5px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .items-table thead {
            background: #333;
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        .items-table tbody tr:hover {
            background: #f9f9f9;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .totals {
            margin-left: auto;
            width: 300px;
            border-top: 2px solid #333;
            padding-top: 15px;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            font-size: 16px;
        }

        .total-row.grand-total {
            font-size: 20px;
            font-weight: bold;
            color: #333;
            border-top: 2px solid #333;
            padding-top: 15px;
            margin-top: 10px;
        }

        .payment-status {
            margin: 20px 0;
            padding: 15px;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
        }

        .payment-status.paid {
            background: #d4edda;
            color: #155724;
            border: 2px solid #c3e6cb;
        }

        .payment-status.unpaid {
            background: #f8d7da;
            color: #721c24;
            border: 2px solid #f5c6cb;
        }

        .payment-status.partial {
            background: #fff3cd;
            color: #856404;
            border: 2px solid #ffeaa7;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
            color: #666;
            font-size: 14px;
        }

        .notes {
            background: #fff8dc;
            padding: 15px;
            border-left: 4px solid #ffa500;
            margin: 20px 0;
        }

        .notes h3 {
            margin-bottom: 10px;
            color: #333;
        }

        @media print {
            body {
                background: white;
                padding: 0;
            }

            .receipt {
                box-shadow: none;
                padding: 20px;
            }

            .no-print {
                display: none;
            }
        }

        .print-button {
            background: #333;
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            margin: 20px auto;
            display: block;
        }

        .print-button:hover {
            background: #555;
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="header">
            <h1>რესტორნის ანგარიში</h1>
            <p>ანგარიში #{{ $order->id }}</p>
            <p>თარიღი: {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="info-section">
            <div class="info-block">
                <h3>მაგიდა</h3>
                <p><strong>{{ $order->table->name }}</strong></p>
                <p>{{ $order->table->capacity }} ადგილი</p>
            </div>

            <div class="info-block">
                <h3>მომსახურე</h3>
                <p>{{ $order->user ? $order->user->name : 'არ არის მითითებული' }}</p>
            </div>

            <div class="info-block">
                <h3>სტატუსი</h3>
                <p>{{ \App\Models\Order::getStatuses()[$order->status] ?? $order->status }}</p>
            </div>
        </div>

        @if($order->notes)
        <div class="notes">
            <h3>შენიშვნები:</h3>
            <p>{{ $order->notes }}</p>
        </div>
        @endif

        <table class="items-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>კერძი</th>
                    <th class="text-center">რაოდენობა</th>
                    <th class="text-right">ფასი</th>
                    <th class="text-right">ჯამი</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->dish->name }}</strong>
                        @if($item->notes)
                        <br><small style="color: #666;">{{ $item->notes }}</small>
                        @endif
                    </td>
                    <td class="text-center">{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->price, 2) }} ₾</td>
                    <td class="text-right"><strong>{{ number_format($item->subtotal, 2) }} ₾</strong></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="totals">
            <div class="total-row grand-total">
                <span>სულ გადასახდელი:</span>
                <span>{{ number_format($order->total_amount, 2) }} ₾</span>
            </div>

            @if($order->paid_amount > 0)
            <div class="total-row">
                <span>გადახდილი:</span>
                <span>{{ number_format($order->paid_amount, 2) }} ₾</span>
            </div>
            <div class="total-row">
                <span>დარჩენილი:</span>
                <span>{{ number_format($order->total_amount - $order->paid_amount, 2) }} ₾</span>
            </div>
            @endif
        </div>

        <div class="payment-status {{ $order->payment_status }}">
            @php
                $paymentStatuses = \App\Models\Order::getPaymentStatuses();
                $statusText = $paymentStatuses[$order->payment_status] ?? $order->payment_status;
            @endphp

            @if($order->payment_status === 'paid')
                ✓ {{ strtoupper($statusText) }}
            @elseif($order->payment_status === 'unpaid')
                ⚠ {{ strtoupper($statusText) }}
            @else
                ◐ {{ strtoupper($statusText) }}
            @endif
        </div>

        <div class="footer">
            <p>მადლობა ჩვენი რესტორნის არჩევისთვის!</p>
            <p>მოგვმართეთ ხელახლა</p>
        </div>
    </div>

    <button class="print-button no-print" onclick="window.print()">ბეჭდვა</button>

    <script>
        // ავტომატური ბეჭდვა (არჩევითი)
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
