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
    <h2>Laporan Penjualan — Apotek POS</h2>
    <div class="sub">Periode: {{ $start }} s/d {{ $end }}</div>
    <table>
        <thead>
            <tr><th>#</th><th>Invoice</th><th>Kasir</th><th>Total</th><th>Tanggal</th></tr>
        </thead>
        <tbody>
            @foreach($transactions as $i => $tx)
            <tr>
                <td>{{ $i+1 }}</td>
                <td>{{ $tx->invoice_number }}</td>
                <td>{{ $tx->user->name }}</td>
                <td>Rp {{ number_format($tx->total, 0, ',', '.') }}</td>
                <td>{{ $tx->transaction_date->format('d/m/Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" style="text-align:right">TOTAL</td>
                <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
