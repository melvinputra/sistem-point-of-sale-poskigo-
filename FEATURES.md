# POSKigo - Advanced Point of Sale System

Sistem POS lengkap berbasis Laravel 11 dengan fitur notifikasi real-time, dompet digital, sistem promosi, laporan visual, dan activity logging.

## 🚀 Fitur Utama

### 1. **Sistem Notifikasi Antar Role** ✉️
- Badge notifikasi real-time di navbar admin
- Panel notifikasi di dashboard dengan filter
- Notifikasi transaksi baru dari kasir ke admin
- Alert stok rendah (< 5) otomatis
- Notifikasi request top-up dari pelanggan
- Mark as read individual & bulk
- AJAX-powered tanpa reload

### 2. **Transaksi Otomatis & Cerdas** 💰
- **Perhitungan Pajak Otomatis**: Configurable tax rate (%)
- **Diskon Voucher**: Support percentage & fixed discount
- **Perhitungan Kembalian**: Cash paid & change calculation
- **Stock Deduction**: Otomatis kurangi stok setelah transaksi
- **Low Stock Alert**: Notifikasi admin jika stok < 5
- **Activity Logging**: Track semua perubahan data
- **SweetAlert Success**: Tampilan total & kembalian cantik

### 3. **Dompet Digital "KiWallet"** 💳
- Saldo virtual untuk pelanggan
- Request top-up dengan upload bukti transfer
- Admin approve/reject dengan catatan
- History top-up dengan status tracking
- Notifikasi approval real-time

### 4. **Sistem Promosi & Voucher** 🎫
- **CRUD Lengkap**: Admin kelola promo dengan mudah
- **2 Tipe Diskon**: Percentage (%) atau Fixed (Rp)
- **Minimum Purchase**: Validasi transaksi minimal
- **Max Usage**: Batasi jumlah pemakaian
- **Usage Tracking**: Track berapa kali dipakai
- **Voucher 1x Per Customer**: Cegah duplikasi
- **Active Status Toggle**: Enable/disable promo
- **Sample Vouchers**:
  - `NEWYEAR2025` - 20% discount
  - `HEMAT50K` - Rp 50.000 off
  - `WELCOME15` - 15% discount

### 5. **Dashboard & Laporan Visual** 📊
- **Chart.js Sales Graph**: Line chart penjualan 7 hari terakhir
- **4 Stat Cards**: Total barang, users, penjualan, sales hari ini
- **Low Stock Alerts**: Warning card untuk barang stok rendah
- **Pending Top-Up Badge**: Alert untuk pending approvals
- **Export Excel**: Laporan detail dengan styling
- **Export PDF**: Laporan siap cetak dengan template
- **Filter Tanggal**: Custom range untuk laporan
- **Top 10 Items**: Barang terlaris dalam periode

### 6. **UI Modern Biru-Oranye** 🎨
- **Gradient Theme**: Biru (#1e88e5) & Oranye (#ff6f00)
- **Responsive Design**: Mobile-friendly
- **Card Hover Effects**: Smooth transitions
- **Toastr Notifications**: Auto-display success/error
- **SweetAlert Modals**: Konfirmasi dengan style
- **Font Awesome Icons**: 6.4.0 latest
- **Bootstrap 5.3**: Modern components

### 7. **Activity Logging & Security** 🔒
- **LogsActivity Trait**: Auto-track create/update/delete
- **Applied to Models**: Item, User, Promotion
- **Filter Logs**: By model, action, date
- **Detail View**: Old data vs new data comparison
- **IP & User Agent**: Track device & location
- **Pagination**: 50 records per page
- **Admin-Only Access**: Role-based middleware

## 📦 Tech Stack

- **Framework**: Laravel 11
- **Database**: MySQL (poskigo)
- **Frontend**: Bootstrap 5.3.0, jQuery 3.7.0
- **Charts**: Chart.js 4.4.0
- **Notifications**: SweetAlert2 v11, Toastr.js
- **Export**: Laravel Excel 3.1, DomPDF 3.1
- **Icons**: Font Awesome 6.4.0

## 🗂️ Struktur Database

### New Tables (7)
1. **notifications** - Sistem notifikasi
2. **wallets** - Saldo dompet digital
3. **topup_requests** - Request isi ulang saldo
4. **promotions** - Data promo/voucher
5. **voucher_usages** - Tracking pemakaian voucher
6. **activity_logs** - Log semua perubahan
7. **sales** (updated) - Tambah tax, discount, promotion columns

## 👥 Demo Accounts

```
Admin:
Email: admin@poskigo.com
Password: password

Kasir:
Email: kasir@poskigo.com
Password: password

Pelanggan:
Email: pelanggan@poskigo.com
Password: password
```

## 🚦 Quick Start

### 1. Setup Database
```bash
php artisan migrate
php artisan db:seed --class=PromotionSeeder
```

### 2. Run Server
```bash
php artisan serve
```

### 3. Access
```
http://127.0.0.1:8000
```

## 📋 Fitur Per Role

### **Admin** 👑
- Dashboard dengan Chart.js & notifications
- CRUD Barang & Kategori
- CRUD Users (Admin, Kasir, Pelanggan)
- Approve/Reject Top-Up Requests
- CRUD Promotions & Vouchers
- View Laporan Penjualan
- Export Excel & PDF
- View Activity Logs
- Terima notifikasi transaksi & stok rendah

### **Kasir** 💼
- Dashboard statistik
- Create Transaksi Penjualan
- Input kode promo & hitung diskon
- Pilih pelanggan atau umum
- View history transaksi
- CRUD Data Pelanggan
- Real-time stock checking

### **Pelanggan** 🛒
- View dashboard pribadi
- KiWallet saldo & history
- Request top-up dengan upload bukti
- View transaksi pembelian
- Browse toko (coming soon)

## 🔧 Key Files

### Controllers
- `AdminController.php` - Dashboard data aggregation
- `SaleController.php` - Transaction logic (162 lines store method)
- `WalletController.php` - Pelanggan wallet management
- `TopupRequestController.php` - Admin top-up approval
- `PromotionController.php` - Promo CRUD
- `ReportController.php` - Export Excel/PDF
- `ActivityLogController.php` - Activity logs with filter

### Models
- `Notification.php` - Methods: unreadCount(), markAsRead()
- `Wallet.php` - Methods: addBalance(), deductBalance()
- `Promotion.php` - Methods: isValid(), calculateDiscount(), incrementUsage()
- `ActivityLog.php` - Static: logActivity()

### Traits
- `LogsActivity.php` - Auto-logging untuk models

### Exports
- `SalesReportExport.php` - Excel export dengan styling

### Views
- `admin/dashboard.blade.php` - Chart.js graph + notification panel
- `admin/topup/index.blade.php` - Top-up approval table
- `admin/promotions/index.blade.php` - Promo list with CRUD
- `admin/logs/index.blade.php` - Activity logs with modal detail
- `admin/reports/pdf.blade.php` - PDF template
- `kasir/sales/create.blade.php` - Transaksi form with voucher
- `pelanggan/wallet/index.blade.php` - Wallet dashboard
- `layouts/admin.blade.php` - Notification badge navbar

## 🎯 Completed Features

✅ 7 Database Migrations  
✅ 6 Models dengan Relationships  
✅ Dependencies Installation (Excel, PDF, Chart.js)  
✅ Sistem Transaksi Otomatis (Tax, Discount, Change)  
✅ Wallet & Top-Up System  
✅ Promotion & Voucher System  
✅ Notification System UI  
✅ Dashboard dengan Chart.js  
✅ Export Reports (Excel/PDF)  
✅ UI Styling Biru-Oranye  
✅ Activity Logging Trait  

## 📊 Sample Data

### Promotions
```
NEWYEAR2025   - 20% off, min Rp 100.000
HEMAT50K      - Rp 50.000 off, min Rp 200.000
WELCOME15     - 15% off, min Rp 50.000
```

## 🔐 Security Features

- Role-based middleware (admin, kasir, pelanggan)
- CSRF protection pada semua forms
- Password hashing (bcrypt)
- XSS prevention
- SQL injection protection (Eloquent ORM)
- Activity logging dengan IP & User Agent
- Sensitive data filtering (password, tokens)

## 🌟 Highlights

1. **Auto Stock Management**: Stok otomatis berkurang setelah transaksi
2. **Real-time Notifications**: Badge counter update otomatis
3. **Visual Reports**: Chart.js interaktif dengan hover effects
4. **One-Click Export**: Download Excel/PDF langsung dari filter
5. **Smart Voucher Validation**: Check minimum purchase, max usage, expiry
6. **Activity Trail**: Track semua perubahan data dengan detail
7. **Responsive UI**: Mobile-first design dengan Bootstrap 5

## 📞 Support

Untuk bantuan atau pertanyaan:
- Email: support@poskigo.com
- Documentation: Lihat file README ini

---

**POSKigo** - Modern Point of Sale System  
© 2025 All Rights Reserved
