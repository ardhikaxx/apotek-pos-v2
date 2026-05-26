# 🏥 Rule Sistem POS Apotek — Laravel 12

> **Framework:** Laravel 12 | **UI:** Bootstrap 5.3 CDN + Font Awesome 6 CDN  
> **Role:** Admin & Apoteker

---

## Stack Teknologi

| Layer     | Teknologi                              |
|-----------|----------------------------------------|
| Backend   | Laravel 12 (PHP 8.3+)                  |
| Database  | MySQL 8                                |
| Frontend  | Blade + Bootstrap 5.3 CDN + FA 6 CDN  |
| PDF       | barryvdh/laravel-dompdf                |

```html
<!-- Bootstrap 5.3 CDN -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome 6 CDN -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
```

---

## Struktur Database & Relasi

> Semua tabel wajib berelasi — tidak ada tabel yang berdiri sendiri.

```
roles ──── users ──── transactions ──── transaction_items
                             │                   │
                         (kasir)             products ──── categories
```

### Tabel

#### `roles`
```sql
id           BIGINT PK
name         VARCHAR(50)   -- 'admin' | 'apoteker'
created_at   TIMESTAMP
updated_at   TIMESTAMP
```

#### `users`
```sql
id           BIGINT PK
role_id      BIGINT FK → roles.id
name         VARCHAR(100)
email        VARCHAR(150) UNIQUE
password     VARCHAR(255)
is_active    BOOLEAN DEFAULT TRUE
created_at   TIMESTAMP
updated_at   TIMESTAMP
```

#### `categories`
```sql
id           BIGINT PK
name         VARCHAR(100) UNIQUE
created_at   TIMESTAMP
updated_at   TIMESTAMP
```

#### `products`
```sql
id             BIGINT PK
category_id    BIGINT FK → categories.id
name           VARCHAR(150)
unit           VARCHAR(30)      -- tablet, strip, botol, dll
purchase_price DECIMAL(12,2)
selling_price  DECIMAL(12,2)
stock          INT DEFAULT 0
is_active      BOOLEAN DEFAULT TRUE
created_at     TIMESTAMP
updated_at     TIMESTAMP
```

#### `transactions`
```sql
id               BIGINT PK
user_id          BIGINT FK → users.id   -- kasir
invoice_number   VARCHAR(50) UNIQUE
total            DECIMAL(14,2)
paid_amount      DECIMAL(14,2)
change_amount    DECIMAL(14,2)
transaction_date DATETIME
created_at       TIMESTAMP
updated_at       TIMESTAMP
```

#### `transaction_items`
```sql
id             BIGINT PK
transaction_id BIGINT FK → transactions.id
product_id     BIGINT FK → products.id
qty            INT
unit_price     DECIMAL(12,2)
subtotal       DECIMAL(14,2)
created_at     TIMESTAMP
updated_at     TIMESTAMP
```

---

## Role & Hak Akses

### 👑 Admin

| Modul              | Akses                    |
|--------------------|--------------------------|
| Manajemen User     | CRUD (admin & apoteker)  |
| Kategori           | CRUD                     |
| Obat / Produk      | CRUD + tambah stok       |
| POS / Transaksi    | Akses penuh              |
| Laporan Penjualan  | Lihat + cetak PDF        |

### 💊 Apoteker

| Modul              | Akses                        |
|--------------------|------------------------------|
| Manajemen User     | ❌ Tidak bisa akses          |
| Kategori           | Lihat saja                   |
| Obat / Produk      | Lihat + tambah stok          |
| POS / Transaksi    | Buat transaksi baru          |
| Laporan Penjualan  | Lihat transaksi hari ini     |

---

## Modul & Fitur

### 1. Manajemen User *(Admin only)*
- Tambah, edit, nonaktifkan user
- Assign role: admin atau apoteker
- Tidak bisa hapus user yang pernah bertransaksi

### 2. Kategori *(Admin only)*
- Tambah, edit, hapus kategori
- Tidak bisa hapus jika masih ada produk

### 3. Obat / Produk *(Admin: CRUD | Apoteker: lihat + tambah stok)*
- CRUD data obat dengan kategori
- Field: nama, kategori, satuan, harga beli, harga jual, stok
- Tambah stok (form sederhana tambah qty)
- Badge warning jika stok = 0

### 4. POS / Transaksi *(Admin & Apoteker)*
- Cari produk by nama (AJAX)
- Tambah ke keranjang, update qty, hapus item
- Pembeli umum (tidak perlu data pasien)
- Input nominal bayar → kembalian otomatis
- Simpan → stok otomatis berkurang
- Cetak struk (print/PDF)
- Generate invoice: `INV-YYYYMMDD-XXXX`

### 5. Laporan Penjualan *(Admin: semua | Apoteker: hari ini)*
- List transaksi dengan filter tanggal
- Total penjualan per periode
- Detail per transaksi
- Export / cetak PDF

---

## Struktur Direktori

```
app/Http/Controllers/
├── Auth/LoginController.php
├── Admin/
│   ├── DashboardController.php
│   ├── UserController.php
│   ├── CategoryController.php
│   ├── ProductController.php
│   ├── TransactionController.php
│   └── ReportController.php
└── Apoteker/
    ├── DashboardController.php
    ├── PosController.php
    ├── ProductController.php      ← view + tambah stok
    └── ReportController.php       ← hari ini saja

app/Http/Middleware/
└── CheckRole.php

app/Models/
├── Role.php
├── User.php
├── Category.php
├── Product.php
├── Transaction.php
└── TransactionItem.php

resources/views/
├── layouts/
│   ├── app.blade.php
│   └── auth.blade.php
├── auth/login.blade.php
├── admin/
│   ├── dashboard/index.blade.php
│   ├── users/
│   ├── categories/
│   ├── products/
│   ├── transactions/
│   └── reports/
└── apoteker/
    ├── dashboard/index.blade.php
    ├── pos/index.blade.php
    ├── products/
    └── reports/
```

---

## Konvensi Kode

### Routes

```php
// routes/web.php
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', Admin\UserController::class);
    Route::resource('categories', Admin\CategoryController::class);
    Route::resource('products', Admin\ProductController::class);
    Route::resource('transactions', Admin\TransactionController::class);
    Route::get('reports', [Admin\ReportController::class, 'index'])->name('reports');
});

Route::middleware(['auth', 'role:apoteker'])->prefix('apoteker')->name('apoteker.')->group(function () {
    Route::get('pos', [Apoteker\PosController::class, 'index'])->name('pos');
    Route::post('pos', [Apoteker\PosController::class, 'store'])->name('pos.store');
    Route::resource('products', Apoteker\ProductController::class)->only(['index', 'show']);
    Route::post('products/{product}/stock', [Apoteker\ProductController::class, 'addStock'])->name('products.stock');
    Route::get('reports', [Apoteker\ReportController::class, 'index'])->name('reports');
});
```

### Middleware CheckRole

```php
// app/Http/Middleware/CheckRole.php
public function handle(Request $request, Closure $next, string $role): Response
{
    if (auth()->user()?->role->name !== $role) {
        abort(403);
    }
    return $next($request);
}
```

### Registrasi Middleware (Laravel 12)

```php
// bootstrap/app.php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias(['role' => CheckRole::class]);
})
```

### Relasi Model

```php
// User
public function role(): BelongsTo { return $this->belongsTo(Role::class); }
public function transactions(): HasMany { return $this->hasMany(Transaction::class); }

// Product
public function category(): BelongsTo { return $this->belongsTo(Category::class); }
public function transactionItems(): HasMany { return $this->hasMany(TransactionItem::class); }

// Transaction
public function user(): BelongsTo { return $this->belongsTo(User::class); }
public function items(): HasMany { return $this->hasMany(TransactionItem::class); }

// TransactionItem
public function transaction(): BelongsTo { return $this->belongsTo(Transaction::class); }
public function product(): BelongsTo { return $this->belongsTo(Product::class); }
```

---

## Aturan UI

- Setiap form wajib ada `@csrf`
- Tampilkan `session('success')` dan `session('error')` setelah aksi
- Tombol hapus wajib ada konfirmasi JS
- Tabel pakai `table-hover table-striped` Bootstrap
- Gunakan icon Font Awesome di setiap menu sidebar dan tombol aksi

### Icon per Menu

| Menu              | Icon FA                  |
|-------------------|--------------------------|
| Dashboard         | `fa-tachometer-alt`      |
| User              | `fa-users`               |
| Kategori          | `fa-tags`                |
| Obat / Produk     | `fa-pills`               |
| POS / Kasir       | `fa-cash-register`       |
| Laporan           | `fa-chart-bar`           |
| Logout            | `fa-sign-out-alt`        |

---

## Aturan Bisnis

1. Stok tidak boleh negatif — validasi sebelum simpan transaksi
2. Produk nonaktif tidak muncul di POS
3. Invoice otomatis, tidak bisa diubah manual
4. Admin tidak bisa hapus dirinya sendiri
5. Kategori tidak bisa dihapus jika masih ada produk
6. User tidak bisa dihapus jika pernah membuat transaksi (nonaktifkan saja)

---

## Seeder Default

```
Admin    → admin@apotek.com    / password
Apoteker → apoteker@apotek.com / password
```

---