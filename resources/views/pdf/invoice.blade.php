<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Belanja</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }

        body {
            margin: 20px;
        }

        .invoice {
            margin: 0 auto;
        }

        .header {
            margin-bottom: 30px;
            padding-bottom: 20px;
        }

        .title {
            color: #333;
            margin-bottom: 15px;
            font-size: 24px;
        }

        .info-text-header-left {
            margin: 5px 0;
            color: #666;
        }

        .info-text-header-right {
            text-align: right;
            color: #666;
        }

        .header-table {
            width: 100%;
        }

        @media print {}
    </style>
</head>

<body>
    <div class="invoice">
        <div class="header">
            <h2 class="title">Faktur Penjualan</h2>
            <table class="header-table">
                <tr>
                    <td class="info-text-header-left">PELANGGAN: {{ strtoupper($user->name) }}</td>
                </tr>
                <tr>
                    <td class="info-text-header-left">TELP: +62{{ $user->username }}</td>
                </tr>
                <tr>
                    <td class="info-text-header-left">Tgl Faktur: {{ date('d M y', strtotime($cart->created_at)) }}</td>
                </tr>
            </table>
        </div>
        <table style="width: 100%; border: 1px solid #000; margin: 0; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; padding: 8px;">NAMA BARANG</th>
                    <th style="border: 1px solid #000; padding: 8px;">QTY</th>
                    <th style="border: 1px solid #000; padding: 8px;">Harga</th>
                    <th style="border: 1px solid #000; padding: 8px;">Diskon</th>
                    <th style="border: 1px solid #000; padding: 8px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($details as $item)
    <tr>
        <td style="border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
            {{ $item->product->nama_product }} {{ $item->variant->variant }}
        </td>
        <td style="text-align: center; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
            {{ $item->qty }} <!-- Qty yang sudah di-update -->
        </td>
        <td style="text-align: right; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
            {{ number_format($item->price, 0, ',', '.') }}
        </td>
        <td style="text-align: center; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
            {{ number_format($item->discount, 0) }}%
        </td>
        <td style="text-align: right; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
            {{ number_format($item->subtotal_after_discount, 0, ',', '.') }}
        </td>
    </tr>
@endforeach
                <tr style="border-top: 1px solid #000;">
                    <td style="border-left: 1px solid #FFF;"></td>
                    <td></td>
                    <td></td>
                    <td style="border-right: 1px solid #000; width: 20%; text-align: right; padding: 5px; border-left: 1px solid #000;">Total Sub:</td>
                    <td style="width: 20%; text-align: right; padding: 5px;">
                        {{ number_format($grandTotal, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #FFF;"></td>
                    <td></td>
                    <td></td>
                    <td style="border-right: 1px solid #000; text-align: right; padding: 5px; border-left: 1px solid #000;">Diskon:</td>
                    <td style="text-align: right; padding: 5px;">{{ number_format($grandTotal * 0.02, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #FFF;"></td>
                    <td></td>
                    <td></td>
                    <td style="border-right: 1px solid #000; text-align: right; padding: 5px; border-left: 1px solid #000;">PPN:</td>
                    <td style="text-align: right; padding: 5px;">{{ number_format($grandTotal * 0.12, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #FFF; border-left: 1px solid #FFF;"></td>
                    <td style="border-bottom: 1px solid #FFF;"></td>
                    <td style="border-bottom: 1px solid #FFF;"></td>
                    <td style="border-right: 1px solid #000; text-align: right; padding: 5px; border-top: 1px solid #000; border-left: 1px solid #000;">
                        <strong>Total Faktur:</strong>
                    </td>
                    <td style="text-align: right; padding: 5px; border-top: 1px solid #000;">
                        <strong>{{ number_format($grandTotal + $grandTotal * 0.12 - $grandTotal * 0.02, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
