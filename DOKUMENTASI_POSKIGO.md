# POSKigo - Sistem Point of Sales

POSKigo adalah aplikasi web Sistem Point of Sales (POS) modern untuk toko retail yang dibangun dengan Laravel 11. Aplikasi ini memiliki 3 role utama: **Admin**, **Kasir**, dan **Pelanggan**.

## 🚀 Fitur Utama

### 👨‍💼 Admin
- **Dashboard** dengan statistik lengkap (total barang, user, penjualan, transaksi)
- **CRUD Data Barang** dengan kategori dan manajemen stok
- **Manajemen User** untuk kasir dan pelanggan
- **Laporan Penjualan** dengan filter tanggal:
  - Total penjualan dan transaksi
  - Barang terlaris
  - Kasir terbaik
  - Grafik penjualan harian

### 💰 Kasir
- **Dashboard Kasir** dengan penjualan hari ini
- **Transaksi Penjualan** dengan interface dinamis:
  - Input barang dengan autocomplete
  - Hitung otomatis subtotal dan grand total
  - Pilih pelanggan atau umum
  - Validasi stok otomatis
- **Manajemen Pelanggan Baru**
- **Riwayat Transaksi** kasir
- **Laporan Penjualan** pribadi

### 🛒 Pelanggan
- **Dashboard** dengan transaksi terbaru
- **Belanja Online** (opsional)
- **Riwayat Transaksi** lengkap
- **View Produk** dengan detail harga dan stok

## 📋 Struktur Database

### Tabel Utama:
- `users` - User dengan role (admin/kasir/pelanggan)
- `items` - Data barang/produk
- `categories` - Kategori barang
- `sales` - Transaksi penjualan
- `sale_items` - Detail item per transaksi
- `customers` - Data pelanggan
- `transactions` - Transaksi online pelanggan
- `reports` - Data laporan

## 🛠️ Teknologi

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Bootstrap 5 + Font Awesome 6
- **Template**: SB Admin 5 (Admin), Custom Bootstrap (Kasir & Pelanggan)

## 📦 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- Laravel 11

### Langkah Instalasi

1. **Project sudah ada di** `c:\laragon\www\poskigo`

2. **Install Dependencies** (jika belum)
```bash
cd c:\laragon\www\poskigo
composer install
```

3. **Setup Environment**
File `.env` sudah dikonfigurasi dengan:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=poskigo
DB_USERNAME=root
DB_PASSWORD=
```

4. **Database sudah dibuat**: `poskigo`

5. **Migrations & Seeders sudah dijalankan**

6. **Jalankan Server**
```bash
php artisan serve
```

7. **Akses Aplikasi**
Buka browser: `http://127.0.0.1:8000`

## 👤 Akun Demo

Setelah menjalankan seeder, Anda dapat login dengan akun berikut:

### Admin
- **Email**: admin@poskigo.com
- **Password**: password
- **URL**: http://127.0.0.1:8000/login?role=admin

### Kasir
- **Email**: kasir@poskigo.com
- **Password**: password
- **URL**: http://127.0.0.1:8000/login?role=kasir

### Pelanggan
- **Email**: pelanggan@poskigo.com
- **Password**: password
- **URL**: http://127.0.0.1:8000/login?role=pelanggan

## 📂 Struktur Project

```
poskigo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/
│   │   │   │   ├── AdminController.php      # Dashboard admin
│   │   │   │   ├── ItemController.php       # CRUD barang
│   │   │   │   ├── UserController.php       # CRUD user
│   │   │   │   └── ReportController.php     # Laporan penjualan
│   │   │   ├── Kasir/
│   │   │   │   ├── KasirController.php      # Dashboard kasir
│   │   │   │   ├── SaleController.php       # Transaksi penjualan
│   │   │   │   └── CustomerController.php   # CRUD pelanggan
│   │   │   ├── Pelanggan/
│   │   │   │   └── PelangganController.php  # Dashboard & shop
│   │   │   ├── AuthController.php           # Login & Register
│   │   │   └── LandingController.php        # Landing page
│   │   └── Middleware/
│   │       └── RoleMiddleware.php           # Role-based access
│   └── Models/
│       ├── User.php
│       ├── Item.php
│       ├── Category.php
│       ├── Sale.php
│       ├── SaleItem.php
│       ├── Customer.php
│       ├── Report.php
│       └── Transaction.php
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2025_10_24_005228_create_categories_table.php
│   │   ├── 2025_10_24_005241_create_items_table.php
│   │   ├── 2025_10_24_005249_create_customers_table.php
│   │   ├── 2025_10_24_005257_create_sales_table.php
│   │   ├── 2025_10_24_005304_create_sale_items_table.php
│   │   ├── 2025_10_24_005318_create_reports_table.php
│   │   └── 2025_10_24_005329_create_transactions_table.php
│   └── seeders/
│       └── DatabaseSeeder.php               # Data dummy
├── resources/
│   └── views/
│       ├── layouts/
│       │   ├── admin.blade.php              # Layout admin
│       │   ├── kasir.blade.php              # Layout kasir
│       │   └── pelanggan.blade.php          # Layout pelanggan
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── items/
│       │   ├── users/
│       │   └── reports/
│       ├── kasir/
│       │   ├── dashboard.blade.php
│       │   ├── sales/
│       │   └── customers/
│       ├── pelanggan/
│       │   ├── dashboard.blade.php
│       │   ├── shop.blade.php
│       │   └── transactions.blade.php
│       ├── auth/
│       │   ├── login.blade.php
│       │   └── register.blade.php
│       └── landing.blade.php
└── routes/
    └── web.php
```

## 🎨 Routing Structure

### Public Routes
- `/` - Landing Page
- `/login?role={admin|kasir|pelanggan}` - Login per role
- `/register?role=pelanggan` - Register pelanggan

### Admin Routes (middleware: auth, role:admin)
- `/admin/dashboard` - Dashboard admin
- `/admin/items` - CRUD barang (resource)
- `/admin/users` - CRUD user (resource)
- `/admin/reports` - Laporan penjualan

### Kasir Routes (middleware: auth, role:kasir)
- `/kasir/dashboard` - Dashboard kasir
- `/kasir/sales` - Transaksi penjualan
- `/kasir/customers` - CRUD pelanggan (resource)

### Pelanggan Routes (middleware: auth, role:pelanggan)
- `/pelanggan/dashboard` - Dashboard pelanggan
- `/pelanggan/shop` - Belanja online
- `/pelanggan/transactions` - Riwayat transaksi

## 🔐 Middleware

**RoleMiddleware** (`app/Http/Middleware/RoleMiddleware.php`)
- Mengecek autentikasi user
- Validasi role user sesuai dengan route
- Redirect ke /login jika belum login
- Abort 403 jika role tidak sesuai

Registrasi di `bootstrap/app.php`:
```php
$middleware->alias([
    'role' => \App\Http\Middleware\RoleMiddleware::class,
]);
```

## 💾 Database Schema

### users
- id, name, email, password, role, remember_token, timestamps

### categories
- id, name, timestamps

### items
- id, name, price, stock, category_id, description, timestamps

### customers
- id, name, phone, address, timestamps

### sales
- id, user_id (kasir), customer_id, total_amount, timestamps

### sale_items
- id, sale_id, item_id, quantity, price, subtotal, timestamps

### reports
- id, type, data (json), generated_at, timestamps

### transactions
- id, customer_id, total, status, timestamps

## 💡 Fitur Tambahan

✅ **Validasi Form** - Semua input divalidasi server-side
✅ **Alert Notifikasi** - Success/error dengan Bootstrap alerts
✅ **Pagination** - Untuk semua list data
✅ **Responsive Design** - Mobile-friendly dengan Bootstrap 5
✅ **Real-time Calculation** - Hitung otomatis subtotal & grand total
✅ **Stok Management** - Update stok otomatis saat transaksi
✅ **Filter Laporan** - Filter by date range
✅ **Dashboard Statistik** - Real-time data

## 🎯 Flow Aplikasi

### Login Flow
1. User memilih role di landing page
2. Redirect ke `/login?role={role}`
3. Input email & password
4. Validasi credentials & role
5. Redirect ke dashboard sesuai role

### Transaksi Penjualan (Kasir)
1. Kasir masuk ke `/kasir/sales/create`
2. Pilih pelanggan (opsional)
3. Tambah barang dengan qty
4. Sistem hitung subtotal & total otomatis
5. Validasi stok
6. Submit transaksi
7. Stok barang berkurang otomatis
8. Data tersimpan di `sales` & `sale_items`

### Laporan Admin
1. Admin akses `/admin/reports`
2. Filter by date range
3. Sistem query:
   - Total penjualan & transaksi
   - Barang terlaris (GROUP BY item_id)
   - Kasir terbaik (GROUP BY user_id)
   - Penjualan harian
4. Tampilkan dalam tabel & chart

## 🔄 Relasi Database (Eloquent)

### User Model
```php
- hasMany(Sale::class) // User sebagai kasir
```

### Category Model
```php
- hasMany(Item::class)
```

### Item Model
```php
- belongsTo(Category::class)
- hasMany(SaleItem::class)
```

### Customer Model
```php
- hasMany(Sale::class)
- hasMany(Transaction::class)
```

### Sale Model
```php
- belongsTo(User::class)      // Kasir
- belongsTo(Customer::class)
- hasMany(SaleItem::class)
```

### SaleItem Model
```php
- belongsTo(Sale::class)
- belongsTo(Item::class)
```

### Transaction Model
```php
- belongsTo(Customer::class)
```

## 📝 Catatan Penting

1. **Session Driver**: Menggunakan database (tabel `sessions`)
2. **Password Hashing**: Bcrypt dengan rounds=12
3. **CSRF Protection**: Aktif untuk semua POST requests
4. **Timezone**: Asia/Jakarta (set di config/app.php jika perlu)
5. **Locale**: Indonesia/English

## 🚨 Troubleshooting

### Jika ada error "SQLSTATE[HY000] [1049] Unknown database"
```bash
mysql -u root -e "CREATE DATABASE poskigo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### Jika migrations belum jalan
```bash
php artisan migrate:fresh --seed
```

### Clear cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
```

## 📧 Support

Project ini dibuat untuk keperluan demo dan pembelajaran sistem POS dengan Laravel 11.

---

**POSKigo** - Sistem Kasir Cerdas dan Mudah Digunakan 🚀

*Developed with ❤️ using Laravel 11 & Bootstrap 5*
