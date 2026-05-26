<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    body { font-family: Arial, sans-serif; font-size: 11px; }
    h2 { text-align: center; margin-bottom: 4px; }
    .sub { text-align: center; color: #555; margin-bottom: 12px; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 5px 8px; }
    th { background: #f0f0f0; }
    .total-row { font-weight: bold; background: #e8f4fd; }
</style>
</head>
<body>
    <h2>Laporan Penjualan Hari Ini — Apotek POS</h2>
    <div class="sub">Tanggal: {{ $date }}</div>
    <table>
        <thead>
            <tr><th>#</th><th>Invoice</th><th>Total</th><th>Bayar</th><th>Kembali</th><th>Waktu</th></tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $tx)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $tx->invoice_number }}</td>
                <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($tx->paid_amount, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($tx->change_amount, 0, ',', '.') }}</td>
                <td>{{ $tx->transaction_date->format('H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" style="text-align:right">TOTAL</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
