<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        body{
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333333;
            font-size: 14px;
            margin: 0;
            padding: 20px;
        }

        .receipt-card {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            padding: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td {
            padding: 4px 0;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
        .divider {
            border-top: 1px solid #e5e7eb;
            margin: 18px 0;
        }

        .item-name {
            padding-top: 10px;
            padding-bottom: 2px;
        }

        .total-row td {
            padding-top: 8px;
            padding-bottom: 2px;
        }

        .badge-row td {
            padding-top: 8px;
            padding-bottom: 4px;
        }

        .badge-wrapper {
            text-align: center;
            margin-top: 22px;
        }

        badge-lunas {
            display: inline-block;
            background-color: #fef4f6;
            color: #6b7280;
            font-size: 12px;
            font-weight: bold;
            letter-spacing: 0.5px;
            padding: 5px 14px;
            border-radius: 4px;
            border: 1px solid #fef4f6;
        }
    </style>
</head>

<body>
    <div class="receipt-card">
        <table>

            <tr>
                <td>No. Pesanan</td>
                <td class="text-right">{{ $checkout['order_code'] }}</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td class="text-right">
                    {{ \Carbon\Carbon::parse($checkout['paid_date'] ?? $checkout['created_at'])->format('d/m/Y H:i:s') }}
                </td>
            </tr>

        </table>

        <div class="divider"></div>

        <table>
            @foreach ($checkout['checkoutBooks'] as $item)
                <tr>
                    <td colspan="2" class="item-name">{{ $item['book']['title'] ?? '-' }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="item-name">Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
            </tr>
            <tr class="total-row">
                <td colspan="2" class="item-name">
                    Rp {{ number_format($checkout['total_price'] ?? 0, 0, ',', '.') }}
                </td>
            </tr>

            <div class="divider"></div>

            <div class="badge-wrapper">
                <span class="badge-lunas">{{ $checkout['status'] === 'paid' ? 'LUNAS' : 'BELUM LUNAS' }}</span>
            </div>
        </table>
    </div>
</body>

</html>
