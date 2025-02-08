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
            /* margin-bottom: 10px; */
            /* padding-bottom: 20px; */
        }

        .title {
            color: #333;
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
            {{-- <h2 class="title">Faktur Penjualan</h2> --}}
            <table style="width: 100%; border-collapse: collapse;">
                <tr>
                    <th style="width: 200px;">
                        Faktur Penjualan
                    </th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th>ANGGREK / DIANA CAKE / BKL</th>
                    <th></th>
                    <th style="border: 1px solid #000;">No. Faktur</th>
                    <th style="border: 1px solid #000;">No. PO</th>
                </tr>
                <tr>
                    <th>
                        <div style="width: fit-content;">
                            CV. Arindra Mandiri
                        </div>
                    </th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th>JL. SOEPRAPTO BENGKULU</th>
                    <th></th>
                    <th style="border: 1px solid #000;">{{ $invoiceNumber }}</th>
                    <th style="border: 1px solid #000;">{{ $orderNumber }}</th>
                </tr>
            </table>
            <table style="width: 100%; border-collapse: collapse; margin-top: 2px;">
                <tr>
                    <th style="width: 200px; text-align: right;">
                        PELANGGAN:
                    </th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th>BENGKULU</th>
                    <th></th>
                    <th></th>
                    <th style="border-collapse: unset; margin-top: 20px; border: 1px solid #000;">Tgl Faktur</th>
                </tr>
                <tr>
                    <th style="width: 5px; text-align: left; border: 1px solid #000; padding: 2px;">
                        TELP: +62{{ $user->username }}
                    </th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th style="width: 117px; margin-top: 20px; border: 1px solid #000;">{{ date('d M Y') }}</th>
                </tr>
                <tr style="color: transparent">
                    <th style="width: 200px;">

                    </th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th style="width: 30px;"></th>
                    <th>ANGGREK / DIANA CAKE / BKL</th>
                    <th></th>
                    <th style="">No. Faktur</th>
                    <th style="">No. PO</th>
                </tr>
            </table>
        </div>
        <table style="width: 100%; border: 1px solid #000; margin: 0; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="border: 1px solid #000; padding: 8px;">KODE BARANG</th>
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
                        <td style="text-align: center;">{{ $item->variant->kode_barang }}</td>
                        <td style="border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
                            {{ $item->product->nama_product }} {{ $item->variant->variant }}
                        </td>
                        <td
                            style="text-align: center; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
                            {{ $item->qty }} <!-- Qty yang sudah di-update -->
                        </td>
                        <td
                            style="text-align: center; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
                            {{ number_format($item->price, 0, ',', '.') }}
                        </td>
                        <td
                            style="text-align: center; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
                            {{ number_format($item->discount, 0) }}%
                        </td>
                        <td
                            style="text-align: right; border-right: 1px solid #000; border-left: 1px solid #000; padding: 5px;">
                            {{ number_format($item->subtotal_before_discount, 0, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
                <tr style="border-top: 1px solid #000;">
                    <td style="border-left: 1px solid #FFF;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td
                        style="border-right: 1px solid #000; width: 20%; text-align: right; padding: 5px; border-left: 1px solid #000;">
                        Total Sub:</td>
                    <td style="width: 20%; text-align: right; padding: 5px;">
                        {{ number_format($totalBeforeDiscount, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #FFF;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td
                        style="border-right: 1px solid #000; text-align: right; padding: 5px; border-left: 1px solid #000;">
                        Diskon:</td>
                    <td style="text-align: right; padding: 5px;">{{ number_format($totalDiscountAmount, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border-left: 1px solid #FFF;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td
                        style="border-right: 1px solid #000; text-align: right; padding: 5px; border-left: 1px solid #000;">
                        PPN:</td>
                    <td style="text-align: right; padding: 5px;">{{ number_format($grandTotal * 0.12, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #FFF; border-left: 1px solid #FFF;"></td>
                    <td style="border-bottom: 1px solid #FFF;"></td>
                    <td style="border-bottom: 1px solid #FFF;"></td>
                    <td style="border-bottom: 1px solid #FFF;"></td>
                    <td
                        style="border-right: 1px solid #000; text-align: right; padding: 5px; border-top: 1px solid #000; border-left: 1px solid #000;">
                        <strong>Total Faktur:</strong>
                    </td>
                    <td style="text-align: right; padding: 5px; border-top: 1px solid #000;">
                        <strong>{{ number_format($grandTotal + $grandTotal * 0.12, 0, ',', '.') }}</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
