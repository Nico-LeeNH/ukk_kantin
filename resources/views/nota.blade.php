<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Nota Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            width: 350px;
            margin: auto;
            padding: 10px;
            color: #000;
        }
        .center {
            text-align: center;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        table {
            width: 100%;
        }
        .table-item td {
            padding: 3px 0;
        }
        .total td {
            font-weight: bold;
            padding-top: 6px;
        }
        .right {
            text-align: right;
        }
        .small {
            font-size: 12px;
        }
    </style>
</head>
<body>

    <div class="center">
        <h3 style="margin: 0;">Kantin Sekolah</h3>
        <p class="small">Malang, Sawojajar</p>
    </div>

    <div class="divider"></div>

    <table>
        <tr>
            <td class="small">Date</td>
            <td class="right small">{{ \Carbon\Carbon::parse($transaksi->tanggal)->format('M d, Y') }}</td>
        </tr>
        <tr>
            <td class="small">Cashier</td>
            <td class="right small">{{ $transaksi->Admin->nama_stan }}</td>
        </tr>
        <tr>
            <td class="small">ID</td>
            <td class="right small">ID {{ str_pad($transaksi->id, 3, '0', STR_PAD_LEFT) }}</td>
        </tr>
        <tr>
            <td class="small">Customer</td>
            <td class="right small">{{ $transaksi->siswa->nama_siswa }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    @php
        $subtotal = 0;
    $total = 0;

    foreach ($transaksi->details as $detail) {
        $originalPrice = $detail->menu->harga * $detail->qty;
        $subtotal += $originalPrice;
        $total += $detail->harga_beli;
    }

    $totalDiskon = $subtotal - $total;
    @endphp
    
    <table class="table-item">
        @foreach ($transaksi->details as $detail)
        <tr>
            <td>{{ $detail->menu->nama_makanan }} x{{ $detail->qty }}</td>
            <td class="right">Rp{{ number_format($originalPrice, 0, ',', '.') }}</td>
        </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Subtotal</td>
            <td class="right">Rp{{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Discount</td>
            <td class="right">-Rp{{ number_format($totalDiskon, 0, ',', '.') }}</td>
        </tr>
        <tr class="total">
            <td>Total</td>
            <td class="right">Rp{{ number_format($total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table>
        <tr>
            <td>Payment Method</td>
            <td class="right">Tunai</td>
        </tr>
        <tr>
            <td>Paid</td>
            <td class="right">Rp{{ number_format($total, 0, ',', '.') }}</td>
        </tr>
    </table>
    @php
    $tanggal = \Carbon\Carbon::parse($transaksi->tanggal)->setTimezone('Asia/Jakarta')->format('M d, Y');
    $waktu = \Carbon\Carbon::now('Asia/Jakarta')->format('H:i');
@endphp
    <div class="center" style="margin-top: 20px;">
        <p><strong>PAID</strong></p>
        <p class="small">{{ $tanggal }} - {{ $waktu }}</p>
        <p class="small">Thank you for your order!</p>
    </div>

</body>
</html>
