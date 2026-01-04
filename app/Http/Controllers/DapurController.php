<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DapurController extends Controller
{
public function index()
{
    // Simulasi data menu untuk dummy
    $menuPool = [
        ['name' => 'Chicken Snack Wrap', 'note' => 'Extra saos'],
        ['name' => 'Mineral Water', 'note' => 'Dingin'],
        ['name' => 'Ayam Krispy', 'note' => 'Paha bawah'],
        ['name' => 'PaNas Spesial', 'note' => 'Nasi tambah'],
        ['name' => 'Fruit Tea Lemon', 'note' => ''],
    ];

    $pesanan = [];
    for ($i = 1; $i <= 15; $i++) {
        // Random jumlah item antara 1 sampai 4
        $itemCount = rand(1, 4);
        $items = [];
        for ($j = 0; $j < $itemCount; $j++) {
            $menu = $menuPool[array_rand($menuPool)];
            $items[] = [
                'name' => $menu['name'],
                'note' => $menu['note'],
                'qty' => rand(1, 3),
                'status' => $i % 3 == 0 ? 'Selesai' : ($i % 2 == 0 ? 'Menunggu' : 'Dimasak')
            ];
        }

        $pesanan[] = [
            'kode' => 'PSN-' . str_pad($i, 3, '0', STR_PAD_LEFT),
            'customer' => ['Sahroni', 'Djarot', 'Jagoan', 'Zambek', 'Takbir', 'Dana', 'Khaled', 'Restila', 'Silavan', 'Budi', 'Andi', 'Citra', 'Eko', 'Feri', 'Gani'][$i-1],
            'meja' => $i % 2 == 0 ? 'Meja ' . ($i + 5) : null,
            'waktu' => '15:' . (10 + $i),
            'status' => $i % 3 == 0 ? 'Selesai' : ($i % 2 == 0 ? 'Menunggu' : 'Dimasak'),
            'tipe' => $i % 2 == 0 ? 'Dine In' : 'Take Away',
            'items' => $items // Menyimpan data item asli
        ];
    }

    return view('dapur.pesanan', compact('pesanan'));
}
    public function stok()
    {
        // Statistik khusus halaman stok sesuai gambar
        $statsStok = [
            ['label' => 'Total Menu', 'val' => '29', 'icon' => 'fa-box', 'active' => true],
            ['label' => 'Total Antrean', 'val' => '6', 'icon' => 'fa-arrow-trend-up', 'active' => false],
            ['label' => 'Stok Rendah', 'val' => '10', 'icon' => 'fa-triangle-exclamation', 'active' => false],
            ['label' => 'Stok Aman', 'val' => '18', 'icon' => 'fa-circle-check', 'active' => false]
        ];

        // Data Lengkap sesuai Gambar
        $stok = [
            ['kode' => 'M001', 'menu' => 'Ayam Krispy', 'kategori' => 'Makanan', 'jumlah' => 16, 'antrean' => 8, 'status' => 'Rendah'],
            ['kode' => 'M002', 'menu' => 'PaNas Spesial', 'kategori' => 'Makanan', 'jumlah' => 12, 'antrean' => 1, 'status' => 'Rendah'],
            ['kode' => 'M003', 'menu' => 'Ayam Spicy', 'kategori' => 'Makanan', 'jumlah' => 8, 'antrean' => 82, 'status' => 'Rendah'],
            ['kode' => 'M004', 'menu' => 'PaNas 1', 'kategori' => 'Makanan', 'jumlah' => 10, 'antrean' => 12, 'status' => 'Rendah'],
            ['kode' => 'M005', 'menu' => 'PaMer 7', 'kategori' => 'Makanan', 'jumlah' => 126, 'antrean' => 19, 'status' => 'Cukup'],
            ['kode' => 'M006', 'menu' => 'PaMer 5', 'kategori' => 'Makanan', 'jumlah' => 200, 'antrean' => 20, 'status' => 'Cukup'],
            ['kode' => 'M006', 'menu' => 'Chicken Snack Wrap', 'kategori' => 'Makanan', 'jumlah' => 170, 'antrean' => 8, 'status' => 'Cukup'],
            ['kode' => 'M007', 'menu' => 'MfSpicy', 'kategori' => 'Makanan', 'jumlah' => 106, 'antrean' => 10, 'status' => 'Cukup'],
            ['kode' => 'M008', 'menu' => 'Fruit Tea Lemon', 'kategori' => 'Minuman', 'jumlah' => 160, 'antrean' => 8, 'status' => 'Cukup'],
            ['kode' => 'M009', 'menu' => 'Hot Tea', 'kategori' => 'Minuman', 'jumlah' => 201, 'antrean' => 8, 'status' => 'Cukup'],
            ['kode' => 'M010', 'menu' => 'Fanta', 'kategori' => 'Minuman', 'jumlah' => 168, 'antrean' => 8, 'status' => 'Cukup'],
        ];

        return view('dapur.stok', compact('statsStok', 'stok'));
    }
}