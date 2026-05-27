@extends('layouts.app')
@section('title', 'POS Kasir')
@section('page-title', 'Point of Sale (Kasir)')

@push('styles')
<style>
    #cart-table td { vertical-align: middle; border-bottom: 1px solid #f1f5f9; }
    .product-item { 
        cursor: pointer; 
        border: 1px solid #f1f5f9; 
        border-radius: 12px; 
        padding: 1rem; 
        transition: all 0.2s; 
        background: #fff;
    }
    .product-item:hover { 
        border-color: #10b981; 
        background: #ecfdf5; 
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }
    #search-results { 
        max-height: 550px; 
        overflow-y: auto; 
        padding: 0.5rem;
    }
    #search-results::-webkit-scrollbar { width: 6px; }
    #search-results::-webkit-scrollbar-thumb { background: #e2e8f0; border-radius: 10px; }
    
    .cart-item-name { font-weight: 600; color: #1e293b; font-size: 0.875rem; }
    .cart-item-price { color: #64748b; font-size: 0.75rem; }
    
    .checkout-box {
        background: #f8fafc;
        border-radius: 16px;
        padding: 1.5rem;
    }
    
    .qty-input {
        width: 60px;
        border-radius: 8px;
        text-align: center;
        border: 1px solid #e2e8f0;
        font-weight: 600;
    }
</style>
@endpush

@section('content')
<div class="row g-4">
    <!-- Pencarian Produk -->
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center">
                    <div class="bg-soft-emerald p-2 rounded-3 me-3" style="background-color: #ecfdf5;">
                        <i class="fa fa-search text-emerald" style="color: #10b981;"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Cari Produk</h5>
                </div>
            </div>
            <div class="card-body p-4">
                <div class="input-group mb-4 shadow-sm" style="border-radius: 12px; overflow: hidden;">
                    <span class="input-group-text border-0 bg-white ps-3"><i class="fa fa-search text-muted"></i></span>
                    <input type="text" id="search-input" class="form-control border-0 py-3" placeholder="Ketik nama obat atau kategori...">
                </div>
                <div id="search-results" class="row g-3">
                    <!-- Produk muncul di sini via JS -->
                </div>
            </div>
        </div>
    </div>

    <!-- Keranjang -->
    <div class="col-lg-5">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-2 rounded-3 me-3">
                        <i class="fa fa-shopping-cart text-primary"></i>
                    </div>
                    <h5 class="mb-0 fw-bold">Ringkasan Pesanan</h5>
                </div>
            </div>
            <div class="card-body p-0 d-flex flex-column">
                <div class="p-4 border-bottom bg-light bg-opacity-50">
                    <label class="form-label small fw-bold text-secondary text-uppercase mb-2">Pelanggan</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="fa fa-user text-muted"></i></span>
                        <select id="customer-id" class="form-select border-start-0">
                            <option value="">-- Umum / Tanpa Nama --</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="flex-grow-1 overflow-auto" style="max-height: 350px;">
                    <div class="table-responsive">
                        <table class="table mb-0" id="cart-table">
                            <tbody id="cart-body">
                                <tr id="empty-row">
                                    <td class="text-center py-5">
                                        <div class="mb-3 opacity-25"><i class="fa fa-shopping-basket fa-3x"></i></div>
                                        <p class="text-muted small mb-0">Keranjang masih kosong</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="p-4 bg-white border-top mt-auto">
                    <div class="checkout-box">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="text-muted">Total Pembayaran</span>
                            <span id="total-display" class="fs-3 fw-bold text-emerald" style="color: #10b981;">Rp 0</span>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-secondary text-uppercase">Nominal Bayar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 fw-bold">Rp</span>
                                <input type="number" id="paid-input" class="form-control border-start-0 ps-0 fw-bold fs-5" min="0" placeholder="0">
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mb-4 p-2 rounded-3 bg-white border border-dashed">
                            <span class="small text-muted">Kembalian</span>
                            <span id="change-display" class="fw-bold text-dark">Rp 0</span>
                        </div>
                        
                        <button id="btn-checkout" class="btn btn-primary w-100 py-3 shadow-emerald border-0" disabled style="background-color: #10b981; border-radius: 12px; font-weight: 700;">
                            <i class="fa fa-check-circle me-2"></i> SELESAI & CETAK STRUK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Sukses -->
<div class="modal fade" id="successModal" tabindex="-1" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px;">
            <div class="modal-body py-5 text-center">
                <div class="bg-soft-emerald d-inline-flex p-4 rounded-circle mb-4" style="background-color: #ecfdf5;">
                    <i class="fa fa-check-circle fa-4x" style="color: #10b981;"></i>
                </div>
                <h4 class="fw-bold mb-2">Transaksi Berhasil!</h4>
                <p class="text-muted small mb-4" id="invoice-display"></p>
                
                <div class="d-grid gap-2">
                    <a id="btn-print" href="#" target="_blank" class="btn btn-primary py-2 border-0" style="background-color: #10b981; border-radius: 10px;">
                        <i class="fa fa-print me-2"></i> Cetak Struk
                    </a>
                    <button class="btn btn-light py-2" onclick="resetPos()" style="border-radius: 10px;">
                        Transaksi Baru
                    </button>
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

function fetchProducts(q = '') {
    const el = document.getElementById('search-results');
    el.innerHTML = '<div class="col-12 text-center py-5"><div class="spinner-border text-emerald" style="color:#10b981"></div></div>';
    
    fetch(`{{ route('apoteker.pos.search') }}?q=${encodeURIComponent(q)}`, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.json())
    .then(data => {
        if (!data.length) { 
            el.innerHTML = '<div class="col-12 text-center py-5"><p class="text-muted">Produk tidak ditemukan.</p></div>'; 
            return; 
        }
        el.innerHTML = data.map(p =>
            `<div class="col-md-6 col-xl-4">
                <div class="product-item" onclick="addToCart(${p.id},'${p.name.replace(/'/g,"\\'")}',${p.selling_price},${p.stock},'${p.unit}')">
                    <div class="fw-bold text-dark mb-1 text-truncate">${p.name}</div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-emerald fw-bold small" style="color:#059669">${formatRp(p.selling_price)}</span>
                        <span class="badge ${p.stock <= 5 ? 'bg-danger' : 'bg-light text-muted'} small" style="font-size: 0.65rem;">Stok: ${p.stock}</span>
                    </div>
                </div>
            </div>`
        ).join('');
    })
    .catch(err => {
        el.innerHTML = '<div class="col-12 text-center py-5"><p class="text-danger">Gagal memuat produk.</p></div>';
    });
}

document.addEventListener('DOMContentLoaded', () => fetchProducts());

document.getElementById('search-input').addEventListener('input', function () {
    clearTimeout(searchTimeout);
    const q = this.value.trim();
    searchTimeout = setTimeout(() => fetchProducts(q), 300);
});

function addToCart(id, name, price, stock, unit) {
    const existing = cart.find(i => i.id === id);
    if (existing) {
        if (existing.qty >= stock) { alert('Stok tidak mencukupi!'); return; }
        existing.qty++;
        existing.subtotal = existing.qty * price;
    } else {
        if (stock < 1) { alert('Stok habis!'); return; }
        cart.push({ id, name, price, stock, unit, qty: 1, subtotal: price });
    }
    renderCart();
}

function updateQty(id, qty) {
    const item = cart.find(i => i.id === id);
    if (!item) return;
    qty = parseInt(qty);
    if (isNaN(qty) || qty < 1) { removeItem(id); return; }
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
        tbody.innerHTML = '<tr id="empty-row"><td class="text-center py-5"><div class="mb-3 opacity-25"><i class="fa fa-shopping-basket fa-3x"></i></div><p class="text-muted small mb-0">Keranjang masih kosong</p></td></tr>';
        updateTotal();
        return;
    }
    tbody.innerHTML = cart.map(item =>
        `<tr class="px-4">
            <td class="ps-4">
                <div class="cart-item-name text-truncate" style="max-width: 180px;">${item.name}</div>
                <div class="cart-item-price">${formatRp(item.price)} / ${item.unit}</div>
            </td>
            <td>
                <input type="number" class="qty-input" value="${item.qty}" min="1" max="${item.stock}" onchange="updateQty(${item.id}, this.value)">
            </td>
            <td class="text-end fw-bold text-dark">
                ${formatRp(item.subtotal)}
            </td>
            <td class="pe-4 text-end">
                <button class="btn btn-sm btn-light text-danger border-0" onclick="removeItem(${item.id})"><i class="fa fa-trash-alt"></i></button>
            </td>
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

    this.disabled = true;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span> PROSES...';

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
        } else {
            alert(data.message || 'Transaksi gagal.');
            this.disabled = false;
            this.innerHTML = '<i class="fa fa-check-circle me-2"></i> SELESAI & CETAK STRUK';
        }
    })
    .catch(() => {
        alert('Terjadi kesalahan jaringan.');
        this.disabled = false;
        this.innerHTML = '<i class="fa fa-check-circle me-2"></i> SELESAI & CETAK STRUK';
    });
});

function resetPos() {
    cart = [];
    renderCart();
    document.getElementById('paid-input').value = '';
    document.getElementById('search-input').value = '';
    fetchProducts();
    const modal = bootstrap.Modal.getInstance(document.getElementById('successModal'));
    if (modal) modal.hide();
    
    document.getElementById('btn-checkout').innerHTML = '<i class="fa fa-check-circle me-2"></i> SELESAI & CETAK STRUK';
}
</script>
@endpush
