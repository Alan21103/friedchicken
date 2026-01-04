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
        $statsStok = [
            ['label' => 'Total Menu', 'val' => '40', 'icon' => 'fa-box'],
            ['label' => 'Total Antrean', 'val' => '68', 'icon' => 'fa-arrow-trend-up'],
            ['label' => 'Stok Rendah', 'val' => '5', 'icon' => 'fa-triangle-exclamation'],
            ['label' => 'Stok Aman', 'val' => '35', 'icon' => 'fa-circle-check']
        ];

        $stok = [
            // PAKET HEBAT
            ['kode' => 'M001', 'menu' => 'Paket HeBat – Chicken Burger Deluxe', 'kategori' => 'Makanan', 'jumlah' => 45, 'antrean' => 3, 'status' => 'Cukup'],
            ['kode' => 'M002', 'menu' => 'Paket HeBat – Korean Soy Garlic Wings', 'kategori' => 'Makanan', 'jumlah' => 38, 'antrean' => 5, 'status' => 'Cukup'],
            ['kode' => 'M003', 'menu' => 'Paket HeBat – MfSpaghetti Ayam (Krispy)', 'kategori' => 'Makanan', 'jumlah' => 52, 'antrean' => 2, 'status' => 'Cukup'],
            ['kode' => 'M004', 'menu' => 'Paket HeBat – MfSpaghetti Ayam (Spicy)', 'kategori' => 'Makanan', 'jumlah' => 48, 'antrean' => 4, 'status' => 'Cukup'],
            
            // KOREAN WINGS
            ['kode' => 'M005', 'menu' => 'Korean Soy Garlic Wings (6 pcs)', 'kategori' => 'Makanan', 'jumlah' => 32, 'antrean' => 6, 'status' => 'Cukup'],
            ['kode' => 'M006', 'menu' => 'PaNas Wings Korean Soy Garlic', 'kategori' => 'Makanan', 'jumlah' => 28, 'antrean' => 8, 'status' => 'Cukup'],
            
            // AYAM KRISPY & SPICY (BEST SELLER)
            ['kode' => 'M007', 'menu' => 'Ayam Krispy', 'kategori' => 'Makanan', 'jumlah' => 85, 'antrean' => 12, 'status' => 'Cukup'],
            ['kode' => 'M008', 'menu' => 'Ayam Spicy', 'kategori' => 'Makanan', 'jumlah' => 92, 'antrean' => 15, 'status' => 'Cukup'],
            
            // PAKET PANAS (BEST SELLER)
            ['kode' => 'M009', 'menu' => 'PaNas 1', 'kategori' => 'Makanan', 'jumlah' => 15, 'antrean' => 7, 'status' => 'Rendah'],
            ['kode' => 'M010', 'menu' => 'PaNas 2 with Fries', 'kategori' => 'Makanan', 'jumlah' => 22, 'antrean' => 9, 'status' => 'Rendah'],
            ['kode' => 'M011', 'menu' => 'PaNas 2 with Rice', 'kategori' => 'Makanan', 'jumlah' => 18, 'antrean' => 11, 'status' => 'Rendah'],
            ['kode' => 'M012', 'menu' => 'PaNas Spesial', 'kategori' => 'Makanan', 'jumlah' => 12, 'antrean' => 8, 'status' => 'Rendah'],
            
            // PAKET PAMER
            ['kode' => 'M013', 'menu' => 'PaMer 5', 'kategori' => 'Makanan', 'jumlah' => 126, 'antrean' => 4, 'status' => 'Cukup'],
            ['kode' => 'M014', 'menu' => 'PaMer 7', 'kategori' => 'Makanan', 'jumlah' => 200, 'antrean' => 5, 'status' => 'Cukup'],
            
            // BURGER
            ['kode' => 'M015', 'menu' => 'Chicken Burger Deluxe', 'kategori' => 'Makanan', 'jumlah' => 58, 'antrean' => 6, 'status' => 'Cukup'],
            ['kode' => 'M016', 'menu' => 'Chicken Burger', 'kategori' => 'Makanan', 'jumlah' => 64, 'antrean' => 5, 'status' => 'Cukup'],
            
            // MF SERIES (BEST SELLER)
            ['kode' => 'M017', 'menu' => 'MfSpicy', 'kategori' => 'Makanan', 'jumlah' => 106, 'antrean' => 10, 'status' => 'Cukup'],
            ['kode' => 'M018', 'menu' => 'MfChicken', 'kategori' => 'Makanan', 'jumlah' => 98, 'antrean' => 13, 'status' => 'Cukup'],
            ['kode' => 'M019', 'menu' => 'MfNuggets', 'kategori' => 'Makanan', 'jumlah' => 142, 'antrean' => 9, 'status' => 'Cukup'],
            ['kode' => 'M020', 'menu' => 'Chicken Snack Wrap', 'kategori' => 'Makanan', 'jumlah' => 8, 'antrean' => 2, 'status' => 'Rendah'],
            
            // MINUMAN - FRUIT TEA
            ['kode' => 'D001', 'menu' => 'Fruit Tea Lemon', 'kategori' => 'Minuman', 'jumlah' => 160, 'antrean' => 8, 'status' => 'Cukup'],
            ['kode' => 'D002', 'menu' => 'Fruit Tea Blackcurrant', 'kategori' => 'Minuman', 'jumlah' => 145, 'antrean' => 6, 'status' => 'Cukup'],
            
            // MINUMAN - SODA
            ['kode' => 'D003', 'menu' => 'Coca Cola', 'kategori' => 'Minuman', 'jumlah' => 188, 'antrean' => 10, 'status' => 'Cukup'],
            ['kode' => 'D004', 'menu' => 'Sprite', 'kategori' => 'Minuman', 'jumlah' => 175, 'antrean' => 7, 'status' => 'Cukup'],
            ['kode' => 'D005', 'menu' => 'Fanta', 'kategori' => 'Minuman', 'jumlah' => 168, 'antrean' => 9, 'status' => 'Cukup'],
            
            // MINUMAN - MCFLOAT
            ['kode' => 'D006', 'menu' => 'Coca-Cola McFloat', 'kategori' => 'Minuman', 'jumlah' => 72, 'antrean' => 5, 'status' => 'Cukup'],
            ['kode' => 'D007', 'menu' => 'Fanta McFloat', 'kategori' => 'Minuman', 'jumlah' => 68, 'antrean' => 4, 'status' => 'Cukup'],
            
            // MINUMAN - TEH
            ['kode' => 'D008', 'menu' => 'Tehbotol Sosro (tawar)', 'kategori' => 'Minuman', 'jumlah' => 210, 'antrean' => 6, 'status' => 'Cukup'],
            ['kode' => 'D009', 'menu' => 'Tehbotol Sosro Kotak', 'kategori' => 'Minuman', 'jumlah' => 195, 'antrean' => 5, 'status' => 'Cukup'],
            ['kode' => 'D010', 'menu' => 'Hot Tea', 'kategori' => 'Minuman', 'jumlah' => 201, 'antrean' => 3, 'status' => 'Cukup'],
            ['kode' => 'D011', 'menu' => 'Iced Lychee Tea', 'kategori' => 'Minuman', 'jumlah' => 88, 'antrean' => 7, 'status' => 'Cukup'],
            
            // MINUMAN - KOPI
            ['kode' => 'D012', 'menu' => 'Es Kopi Gula Aren', 'kategori' => 'Minuman', 'jumlah' => 92, 'antrean' => 8, 'status' => 'Cukup'],
            ['kode' => 'D013', 'menu' => 'Es Kopi Gula Aren Jelly', 'kategori' => 'Minuman', 'jumlah' => 78, 'antrean' => 6, 'status' => 'Cukup'],
            ['kode' => 'D014', 'menu' => 'Es Kopi Gula Aren Float', 'kategori' => 'Minuman', 'jumlah' => 65, 'antrean' => 4, 'status' => 'Cukup'],
            ['kode' => 'D015', 'menu' => 'Es Kopi Gula Aren Jelly Float', 'kategori' => 'Minuman', 'jumlah' => 58, 'antrean' => 3, 'status' => 'Cukup'],
            ['kode' => 'D016', 'menu' => 'Iced Coffee Jelly Float', 'kategori' => 'Minuman', 'jumlah' => 70, 'antrean' => 5, 'status' => 'Cukup'],
            ['kode' => 'D017', 'menu' => 'Iced Coffee Float', 'kategori' => 'Minuman', 'jumlah' => 82, 'antrean' => 6, 'status' => 'Cukup'],
            ['kode' => 'D018', 'menu' => 'Iced Coffee Jelly', 'kategori' => 'Minuman', 'jumlah' => 76, 'antrean' => 4, 'status' => 'Cukup'],
            
            // MINUMAN - LAINNYA
            ['kode' => 'D019', 'menu' => 'Iced Milo', 'kategori' => 'Minuman', 'jumlah' => 110, 'antrean' => 9, 'status' => 'Cukup'],
            ['kode' => 'D020', 'menu' => 'Mineral Water (Prim-a)', 'kategori' => 'Minuman', 'jumlah' => 250, 'antrean' => 12, 'status' => 'Cukup'],
        ];

        return view('dapur.stok', compact('statsStok', 'stok'));
    }
}