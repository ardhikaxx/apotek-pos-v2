<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: monospace; font-size: 11px; margin: 0; padding: 10px; }
    .center { text-align: center; }
    .line { border-top: 1px dashed #000; margin: 6px 0; }
    table { width: 100%; }
    td { padding: 1px 0; }
    .right { text-align: right; }
</style>
</head>
<body>
    <div class="center">
        <strong>APOTEK POS</strong><br>
        Jl. Kesehatan No. 1<br>
        Telp: 021-0000000
    </div>
    <div class="line"></div>
    <table>
        <tr><td>Invoice</td><td>: {{ $transaction->invoice_number }}</td></tr>
        <tr><td>Kasir</td><td>: {{ $transaction->user->name }}</td></tr>
        <tr><td>Tanggal</td><td>: {{ $transaction->transaction_date->format('d/m/Y H:i') }}</td></tr>
    </table>
    <div class="line"></div>
    @foreach($transaction->items as $item)
    <table>
        <tr><td colspan="2">{{ $item->product->name }}</td></tr>
        <tr>
            <td>{{ $item->qty }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
            <td class="right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
        </tr>
    </table>
    @endforeach
    <div class="line"></div>
    <table>
        <tr><td><strong>TOTAL</strong></td><td class="right"><strong>Rp {{ number_format($transaction->total, 0, ',', '.') }}</strong></td></tr>
        <tr><td>Bayar</td><td class="right">Rp {{ number_format($transaction->paid_amount, 0, ',', '.') }}</td></tr>
        <tr><td>Kembali</td><td class="right">Rp {{ number_format($transaction->change_amount, 0, ',', '.') }}</td></tr>
    </table>
    <div class="line"></div>
    <div class="center">Terima kasih atas kunjungan Anda</div>
</body>
</html>
