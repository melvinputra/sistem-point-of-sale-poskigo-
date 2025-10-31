<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default users for each role
        User::create([
            'name' => 'Admin POSKigo',
            'email' => 'admin@poskigo.com',
            'password' => Hash::make('password'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Kasir 1',
            'email' => 'kasir@poskigo.com',
            'password' => Hash::make('password'),
            'role' => 'kasir'
        ]);

        User::create([
            'name' => 'Pelanggan 1',
            'email' => 'pelanggan@poskigo.com',
            'password' => Hash::make('password'),
            'role' => 'pelanggan'
        ]);

        // Create categories
        $categories = [
            'Makanan',
            'Minuman',
            'Snack',
            'Alat Tulis',
            'Elektronik',
            'Pakaian',
            'Kesehatan'
        ];

        foreach ($categories as $categoryName) {
            Category::create(['name' => $categoryName]);
        }

        // Create items
        $items = [
            ['name' => 'Nasi Goreng', 'price' => 15000, 'stock' => 50, 'category_id' => 1, 'description' => 'Nasi goreng spesial dengan telur'],
            ['name' => 'Mie Ayam', 'price' => 12000, 'stock' => 40, 'category_id' => 1, 'description' => 'Mie ayam bakso'],
            ['name' => 'Sate Ayam', 'price' => 20000, 'stock' => 30, 'category_id' => 1, 'description' => 'Sate ayam 10 tusuk'],
            ['name' => 'Teh Botol', 'price' => 5000, 'stock' => 100, 'category_id' => 2, 'description' => 'Teh botol sosro'],
            ['name' => 'Air Mineral', 'price' => 3000, 'stock' => 150, 'category_id' => 2, 'description' => 'Air mineral kemasan'],
            ['name' => 'Kopi Susu', 'price' => 8000, 'stock' => 60, 'category_id' => 2, 'description' => 'Kopi susu hangat'],
            ['name' => 'Chitato', 'price' => 10000, 'stock' => 80, 'category_id' => 3, 'description' => 'Keripik kentang'],
            ['name' => 'Oreo', 'price' => 7000, 'stock' => 90, 'category_id' => 3, 'description' => 'Biskuit sandwich'],
            ['name' => 'Pulpen', 'price' => 2000, 'stock' => 200, 'category_id' => 4, 'description' => 'Pulpen hitam'],
            ['name' => 'Buku Tulis', 'price' => 5000, 'stock' => 100, 'category_id' => 4, 'description' => 'Buku tulis 38 lembar'],
            ['name' => 'Kabel USB', 'price' => 25000, 'stock' => 50, 'category_id' => 5, 'description' => 'Kabel USB type C'],
            ['name' => 'Earphone', 'price' => 35000, 'stock' => 40, 'category_id' => 5, 'description' => 'Earphone stereo'],
            ['name' => 'Kaos Polos', 'price' => 45000, 'stock' => 60, 'category_id' => 6, 'description' => 'Kaos cotton combed'],
            ['name' => 'Masker', 'price' => 15000, 'stock' => 120, 'category_id' => 7, 'description' => 'Masker 3 ply isi 10'],
            ['name' => 'Hand Sanitizer', 'price' => 20000, 'stock' => 80, 'category_id' => 7, 'description' => 'Hand sanitizer 100ml'],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }

        // Create customers
        $customers = [
            ['name' => 'Budi Santoso', 'phone' => '081234567890', 'address' => 'Jl. Merdeka No. 123'],
            ['name' => 'Siti Nurhaliza', 'phone' => '081234567891', 'address' => 'Jl. Sudirman No. 456'],
            ['name' => 'Ahmad Yani', 'phone' => '081234567892', 'address' => 'Jl. Gatot Subroto No. 789'],
            ['name' => 'Dewi Lestari', 'phone' => '081234567893', 'address' => 'Jl. Ahmad Yani No. 321'],
            ['name' => 'Eko Prasetyo', 'phone' => '081234567894', 'address' => 'Jl. Diponegoro No. 654'],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
