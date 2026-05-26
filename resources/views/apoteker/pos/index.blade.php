@extends('layouts.app')
@section('title', 'POS Kasir')
@section('page-title', 'POS / Kasir')

@push('styles')
<style>
    .product-item { cursor: pointer; }
    .product-item:hover { background: #f0f9ff; }
    #search-results { max-height: 400px; overflow-y: auto; }
</style>
@endpush

@section('content')
<div class="row g-3">
    <div class="col-md-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white fw-semibold"><i class="fa fa-search me-2 text-info"></i>Cari Produk</div>
            <div class="card-body">
                <input type="text" id="search-input" class="form-control mb-3" placeholder="Ketik nama obat...">
                <div id="search-results"></div>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white fw-semibold"><i class="fa fa-shopping-cart me-2 text-success"></i>Keranjang</div>
            <div class="card-body p-0">
                <div class="p-3 border-bottom">
                    <label class="form-label small fw-semibold">Pilih Pelanggan (Opsional)</label>
                    <select id="customer-id" class="form-select form-select-sm">
                        <option value="">-- Umum / Tanpa Nama --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="table table-sm mb-0" id="cart-table">
                    <thead class="table-light">
                        <tr><th>Produk</th><th>Qty</th><th>Subtotal</th><th></th></tr>
                    </thead>
                    <tbody id="cart-body">
                        <tr id="empty-row"><td colspan="4" class="text-center text-muted py-3">Keranjang kosong</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer bg-white">
                <div class="d-flex justify-content-between fw-bold mb-2">
                    <span>Total:</span><span id="total-display">Rp 0</span>
                </div>
                <div class="mb-2">
                    <label class="form-label">Nominal Bayar</label>
                    <input type="number" id="paid-input" class="form-control" min="0" placeholder="0">
                </div>
                <div class="d-flex justify-content-between text-success fw-semibold mb-3">
                    <span>Kembalian:</span><span id="change-display">Rp 0</span>
                </div>
                <button id="btn-checkout" class="btn btn-success w-100" disabled>
                    <i class="fa fa-check-circle me-2"></i>Proses Transaksi
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm">
        <div class="modal-content text-center">
            <div class="modal-body py-4">
                <i class="fa fa-check-circle fa-3x text-success mb-3"></i>
                <h6 class="fw-bold">Transaksi Berhasil!</h6>
                <p class="text-muted small" id="invoice-display"></p>
                <div class="d-flex gap-2 justify-content-center mt-3">
                    <a id="btn-print" href="#" target="_blank" class="btn btn-sm btn-outline-secondary">
                        <i class="fa fa-print me-1"></i>Cetak Struk
                    </a>
                    <button class="btn btn-sm btn-success" onclick="resetPos()">Transaksi Baru</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let cart = [];
let searchTimeout;
const formatRp = n => 'Rp ' + parseInt(n).toLocaleString('id-ID');

// Function to fetch and display products
function fetchProducts(q = '') {
    const el = document.getElementById('search-results');
    el.innerHTML = '<div class="text-center py-3"><div class="spinner-border spinner-border-sm text-info"></div></div>';
    
    fetch(`{{ route('apoteker.pos.search') }}?q=${encodeURIComponent(q)}`)
    .then(r => r.json())
    .then(data => {
        if (!data.length) { 
            el.innerHTML = '<p class="text-muted small">Produk tidak ditemukan.</p>'; 
            return; 
        }
        el.innerHTML = '<div class="list-group">' + data.map(p =>
            `<button type="button" class="list-group-item list-group-item-action product-item d-flex justify-content-between" onclick="addToCart(${p.id},'${p.name.replace(/'/g,"\\'")}',${p.selling_price},${p.stock},'${p.unit}')">
                <span>${p.name} <small class="text-muted">(${p.unit})</small></span>
                <span class="text-info fw-semibold">${formatRp(p.selling_price)} <small class="text-muted">stok: ${p.stock}</small></span>
            </button>`
        ).join('') + '</div>';
    })
    .catch(err => {
        console.error('Error fetching products:', err);
        el.innerHTML = '<p class="text-danger small">Gagal memuat produk. Coba lagi.</p>';
    });
}

// Initial fetch on page load
document.addEventListener('DOMContentLoaded', () => {
    fetchProducts();
});

document.getElementById('search-input').addEventListener('input', function () {
    clearTimeout(searchTimeout);
    const q = this.value.trim();
    
    searchTimeout = setTimeout(() => {
        fetchProducts(q);
    }, 300);
});

function addToCart(id, name, price, stock, unit) {
    const existing = cart.find(i => i.id === id);
    if (existing) {
        if (existing.qty >= stock) { alert('Stok tidak mencukupi!'); return; }
        existing.qty++;
        existing.subtotal = existing.qty * price;
    } else {
        cart.push({ id, name, price, stock, unit, qty: 1, subtotal: price });
    }
    renderCart();
}

function updateQty(id, qty) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    qty = parseInt(qty);
    if (qty < 1) { removeItem(id); return; }
    if (qty > item.stock) { alert('Stok tidak mencukupi!'); return; }
    item.qty = qty;
    item.subtotal = qty * item.price;
    renderCart();
}

function removeItem(id) {
    cart = cart.filter(i => i.id !== id);
    renderCart();
}

function renderCart() {
    const tbody = document.getElementById('cart-body');
    if (!cart.length) {
        tbody.innerHTML = '<tr id="empty-row"><td colspan="4" class="text-center text-muted py-3">Keranjang kosong</td></tr>';
        updateTotal(); return;
    }
    tbody.innerHTML = cart.map(item =>
        `<tr>
            <td><small>${item.name}</small></td>
            <td style="width:80px"><input type="number" class="form-control form-control-sm" value="${item.qty}" min="1" max="${item.stock}" onchange="updateQty(${item.id}, this.value)"></td>
            <td><small>${formatRp(item.subtotal)}</small></td>
            <td><button class="btn btn-sm btn-outline-danger" onclick="removeItem(${item.id})"><i class="fa fa-times"></i></button></td>
        </tr>`
    ).join('');
    updateTotal();
}

function updateTotal() {
    const total = cart.reduce((s, i) => s + i.subtotal, 0);
    document.getElementById('total-display').textContent = formatRp(total);
    const paid = parseFloat(document.getElementById('paid-input').value) || 0;
    const change = paid - total;
    document.getElementById('change-display').textContent = formatRp(change >= 0 ? change : 0);
    document.getElementById('btn-checkout').disabled = !(cart.length && paid >= total);
}

document.getElementById('paid-input').addEventListener('input', updateTotal);

document.getElementById('btn-checkout').addEventListener('click', function () {
    const paid = parseFloat(document.getElementById('paid-input').value);
    const customerId = document.getElementById('customer-id').value;
    const items = cart.map(i => ({ id: i.id, qty: i.qty }));

    fetch('{{ route('apoteker.pos.store') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ items, paid_amount: paid, customer_id: customerId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.getElementById('invoice-display').textContent = 'ID Transaksi: #' + data.transaction_id;
            document.getElementById('btn-print').href = `/apoteker/pos/${data.transaction_id}/pdf`;
            new bootstrap.Modal(document.getElementById('successModal')).show();
        }
    })
    .catch(() => alert('Terjadi kesalahan, coba lagi.'));
});

function resetPos() {
    cart = [];
    renderCart();
    document.getElementById('paid-input').value = '';
    document.getElementById('search-input').value = '';
    document.getElementById('search-results').innerHTML = '';
    bootstrap.Modal.getInstance(document.getElementById('successModal')).hide();
}
</script>
@endpush
