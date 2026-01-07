<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - My Fried Chicken</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
    </style>
</head>

<body class="bg-[#F8F9FA] overflow-hidden font-sans" x-data="posSystem()">

    <div class="flex h-screen">
        <div class="flex flex-col h-screen bg-[#F3F4F6] w-full">

            @include('kasir.components.navbar')

            <div class="flex flex-1 overflow-hidden">

                @include('kasir.components.main')

                @include('kasir.components.pesanan')

            </div>
        </div>
    </div>

    @include('kasir.components.pembayaran')
    @include('kasir.components.notifikasi-tunggu')
    @include('kasir.components.input-nama')
    @include('kasir.components.pembayaran-berhasil')

    <script>
        function posSystem() {
            return {
                activeCategory: 'Best Seller',
                orderType: 'Dine In',
                showPayment: false,
                showWaitNotification: false,
                showInputDetails: false,
                showSuccess: false, 
                orderCode: 'PSN-001', // Bisa dibuat dinamis nantinya
                paymentMethod: 'Tunai', // Tambahkan ini (default Tunai)
                cashReceived: 0,        // Tambahkan ini untuk menampung input uang
                nominalOptions: [50000, 100000, 150000, 200000], // Shortcut nominal
                searchQuery: '',
                nomorMeja: '',
                namaPelanggan: '',

                categories: ['Best Seller', 'Paket', 'Makanan', 'Minuman', 'Camilan'],
                cart: [],
                menus: [
                    // --- BEST SELLER ITEMS ---
                    { id: 13, nama: 'Ayam MfD Spicy', deskripsi: 'Ayam goreng pedas MFC yang meresap dan krispy.', harga: 16000, kategori: 'Makanan', stok: 100, bestSeller: true },
                    { id: 18, nama: 'MfChicken', deskripsi: 'Fillet ayam goreng tanpa tulang khas MFC.', harga: 20000, kategori: 'Makanan', stok: 40, bestSeller: true },
                    { id: 6, nama: 'PaNas 2 with Rice', deskripsi: '2 potong Ayam MfD, 1 nasi putih, 1 minuman. Lebih kenyang!', harga: 42000, kategori: 'Paket', stok: 45, bestSeller: true },
                    { id: 19, nama: 'MfNuggets', deskripsi: 'Nugget ayam pilihan (isi 6 pcs).', harga: 22000, kategori: 'Makanan', stok: 60, bestSeller: true },
                    { id: 37, nama: 'Apple Pie', deskripsi: 'Pastry renyah dengan isian apel kayu manis hangat.', harga: 12000, kategori: 'Camilan', stok: 30, bestSeller: true },
                    { id: 38, nama: 'MfFlurry', deskripsi: 'Es krim lembut dengan pilihan topping Oreo/Choco.', harga: 15000, kategori: 'Minuman', stok: 50, bestSeller: true },

                    // --- PAKET HEBAT & PANAS ---
                    { id: 1, nama: 'Paket HeBat – Chicken Burger Deluxe', deskripsi: 'Burger ayam deluxe lengkap dengan kentang dan minuman.', harga: 35000, kategori: 'Paket', stok: 30 },
                    { id: 2, nama: 'Paket HeBat – Korean Soy Garlic Wings', deskripsi: 'Sayap ayam bumbu Korea dengan nasi dan minuman.', harga: 38000, kategori: 'Paket', stok: 25 },
                    { id: 3, nama: 'Paket HeBat – MfSpaghetti Ayam (Krispy)', deskripsi: 'Spaghetti dengan topping ayam krispy dan minuman.', harga: 32000, kategori: 'Paket', stok: 20 },
                    { id: 4, nama: 'Paket HeBat – MfSpaghetti Ayam (Spicy)', deskripsi: 'Spaghetti pedas dengan topping ayam krispy dan minuman.', harga: 32000, kategori: 'Paket', stok: 20 },
                    { id: 5, nama: 'PaNas 1', deskripsi: '1 potong Ayam MfD, 1 nasi putih, 1 minuman segar.', harga: 28000, kategori: 'Paket', stok: 50 },
                    { id: 7, nama: 'PaNas 2 with Fries', deskripsi: '2 potong Ayam MfD, Medium French Fries, 1 minuman.', harga: 45000, kategori: 'Paket', stok: 35 },
                    { id: 8, nama: 'PaNas Spesial', deskripsi: '2 potong Ayam MfD, 1 nasi putih, 1 Medium French Fries, 1 minuman.', harga: 52000, kategori: 'Paket', stok: 30 },
                    { id: 9, nama: 'PaNas Wings Korean Soy Garlic', deskripsi: 'Paket sayap ayam Korea dengan nasi dan minuman.', harga: 37000, kategori: 'Paket', stok: 9 },
                    { id: 10, nama: 'PaMer 5', deskripsi: 'Paket Meriah 5 potong ayam krispy keluarga.', harga: 85000, kategori: 'Paket', stok: 8 },
                    { id: 11, nama: 'PaMer 7', deskripsi: 'Paket Meriah 7 potong ayam krispy keluarga.', harga: 115000, kategori: 'Paket', stok: 7 },

                    // --- MAKANAN / A LA CARTE ---
                    { id: 12, nama: 'Ayam Krispy', deskripsi: '1 potong ayam goreng krispy MFC yang juicy.', harga: 16000, kategori: 'Makanan', stok: 100 },
                    { id: 14, nama: 'Korean Soy Garlic Wings (6 pcs)', deskripsi: '6 potong sayap ayam dengan saus soy garlic Korea.', harga: 33000, kategori: 'Makanan', stok: 20 },
                    { id: 15, nama: 'Chicken Burger Deluxe', deskripsi: 'Burger ayam dengan selada, tomat, dan saus spesial.', harga: 25000, kategori: 'Makanan', stok: 40 },
                    { id: 16, nama: 'Chicken Burger', deskripsi: 'Burger fillet ayam krispy klasik.', harga: 18000, kategori: 'Makanan', stok: 45 },
                    { id: 17, nama: 'MfSpicy', deskripsi: 'Ayam goreng ekstra pedas ala MFC.', harga: 17000, kategori: 'Makanan', stok: 50 },
                    { id: 20, nama: 'Chicken Snack Wrap', deskripsi: 'Tortilla isi ayam krispy dan sayuran segar.', harga: 15000, kategori: 'Makanan', stok: 35 },

                    // --- MINUMAN ---
                    { id: 21, nama: 'Fruit Tea Lemon', deskripsi: 'Teh rasa lemon yang menyegarkan.', harga: 10000, kategori: 'Minuman', stok: 80 },
                    { id: 22, nama: 'Coca Cola', deskripsi: 'Minuman karbonasi cola dingin.', harga: 12000, kategori: 'Minuman', stok: 100 },
                    { id: 23, nama: 'Sprite', deskripsi: 'Minuman karbonasi lemon-lime.', harga: 12000, kategori: 'Minuman', stok: 100 },
                    { id: 24, nama: 'Fanta', deskripsi: 'Minuman karbonasi rasa stroberi.', harga: 12000, kategori: 'Minuman', stok: 100 },
                    { id: 25, nama: 'Coca-Cola McFloat', deskripsi: 'Cola dingin dengan es krim vanila di atasnya.', harga: 15000, kategori: 'Minuman', stok: 40 },
                    { id: 26, nama: 'Fanta McFloat', deskripsi: 'Fanta stroberi dengan topping es krim.', harga: 15000, kategori: 'Minuman', stok: 40 },
                    { id: 27, nama: 'Tehbotol Sosro (Tawar)', deskripsi: 'Teh melati asli tanpa gula.', harga: 8000, kategori: 'Minuman', stok: 60 },
                    { id: 28, nama: 'Iced Milo', deskripsi: 'Minuman cokelat energi dingin.', harga: 14000, kategori: 'Minuman', stok: 70 },
                    { id: 29, nama: 'Iced Lychee Tea', deskripsi: 'Teh rasa leci dengan buah leci asli.', harga: 18000, kategori: 'Minuman', stok: 30 },
                    { id: 30, nama: 'Es Kopi Gula Aren', deskripsi: 'Kopi susu gula aren khas MFC.', harga: 15000, kategori: 'Minuman', stok: 50 },
                    { id: 31, nama: 'Es Kopi Gula Aren Jelly', deskripsi: 'Kopi gula aren dengan topping jelly kopi.', harga: 18000, kategori: 'Minuman', stok: 40 },
                    { id: 32, nama: 'Es Kopi Gula Aren Float', deskripsi: 'Kopi gula aren dengan topping es krim.', harga: 20000, kategori: 'Minuman', stok: 30 },
                    { id: 33, nama: 'Iced Coffee Jelly Float', deskripsi: 'Kopi dingin lengkap dengan jelly dan es krim.', harga: 22000, kategori: 'Minuman', stok: 25 },
                    { id: 34, nama: 'Hot Tea', deskripsi: 'Teh panas aromatik.', harga: 7000, kategori: 'Minuman', stok: 50 },
                    { id: 35, nama: 'Mineral Water (Prim-a)', deskripsi: 'Air mineral kemasan 600ml.', harga: 6000, kategori: 'Minuman', stok: 150 },
                    { id: 36, nama: 'Tehbotol Sosro Kotak', deskripsi: 'Teh kemasan kotak praktis.', harga: 7000, kategori: 'Minuman', stok: 100 }
                ],

                renderCard(p) {
                    // Tipe sajian berdasarkan kategori
                    const isFast = p.kategori === 'Minuman' || p.kategori === 'Camilan';
                    const badgeTime = isFast
                        ? `<div class="flex items-center gap-1"><svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z"></path></svg><span>Cepat</span></div>`
                        : `<div class="flex items-center gap-1"><svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg><span>Butuh Waktu</span></div>`;

                    const lowStockBadge = p.stok < 10
                        ? `
                        <div class="absolute top-3 right-3 px-2 py-1 rounded-full 
                                    text-[9px] font-bold text-white bg-[#E35D5D] 
                                    flex items-center gap-1 shadow-sm">
                            
                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" 
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v4m0 4h.01
                                    M12 2a10 10 0 100 20
                                    10 10 0 000-20z"/>
                            </svg>

                            <span>Stok Menipis</span>
                        </div>
                        `
                        : '';


                    return `
                    <div class="bg-white rounded-[32px] overflow-hidden shadow-sm border border-transparent hover:border-slate-300 transition-all flex flex-col group h-full relative">
                        <div class="relative h-40 bg-[#D9D9D9] p-4 flex items-center justify-center">
                            <div class="absolute top-3 left-3 px-3 py-1.5 rounded-full text-[10px] font-bold text-white bg-black/30 backdrop-blur-md">
                                ${badgeTime}
                            </div>
                            ${lowStockBadge}
                            <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            <button onclick="window.dispatchEvent(new CustomEvent('add-to-cart', {detail: ${p.id}}))" class="absolute bottom-3 right-3 w-10 h-10 bg-[#4F5B69] text-white rounded-full flex items-center justify-center hover:scale-110 transition-transform shadow-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h4 class="text-sm font-bold text-[#333] mb-1 line-clamp-1">${p.nama}</h4>
                            <p class="text-[10px] text-[#828282] leading-tight mb-4 flex-1 line-clamp-2">${p.deskripsi}</p>
                            <div class="flex items-center justify-between mt-auto">
                                <span class="text-base font-black text-[#333]">${this.formatPrice(p.harga)}</span>
                                <span class="text-[10px] font-bold text-[#828282]">Stok: ${p.stok}</span>
                            </div>
                        </div>
                    </div>
                `;
                },

                addToCartById(id) {
                    const product = this.menus.find(m => m.id === id);
                    if (!product) return;

                    let found = this.cart.find(i => i.id === id);
                    if (found) {
                        found.qty++;
                    } else {
                        this.cart.push({ ...product, qty: 1 });
                    }
                },

                updateQty(id, n) {
                    let i = this.cart.find(item => item.id === id);
                    if (i) {
                        i.qty += n;
                        if (i.qty <= 0) this.cart = this.cart.filter(x => x.id !== id);
                    }
                },

                // --- Getters (Computed Properties) ---
                get subtotal() { return this.cart.reduce((s, i) => s + (i.harga * i.qty), 0); },
                get tax() { return this.subtotal * 0.1; },
                get serviceFee() { return this.subtotal * 0.05; },
                get total() { return this.subtotal + this.tax + this.serviceFee; },
                get change() { return Math.max(0, this.cashReceived - this.total); },

                get filteredMenus() {
                    return this.menus.filter(m => {
                        const matchCat = this.activeCategory === 'Best Seller'
                            ? m.bestSeller === true
                            : m.kategori === this.activeCategory;
                        const matchSearch = m.nama.toLowerCase().includes(this.searchQuery.toLowerCase());
                        return matchCat && matchSearch;
                    });
                },

                // --- Logic Notifikasi (Butuh Waktu vs Cepat) ---
                get hasTimeConsumingItem() {
                    return this.cart.some(item => item.kategori === 'Makanan' || item.kategori === 'Paket');
                },

                get timeConsumingItems() {
                    return this.cart.filter(item => item.kategori === 'Makanan' || item.kategori === 'Paket');
                },

                get fastItems() {
                    return this.cart.filter(item => item.kategori !== 'Makanan' && item.kategori !== 'Paket');
                },

                // --- Workflow Pembayaran ---
                confirmPayment() {
                    // 1. Cek apakah ada item yang butuh waktu
                    const butuhWaktu = this.hasTimeConsumingItem;

                    console.log("Status Butuh Waktu:", butuhWaktu); // Cek di inspect element (F12)

                    if (butuhWaktu) {
                        // TEPAT DI SINI: Tutup modal pembayaran dulu, baru buka modal notifikasi
                        this.showPayment = false;

                        // Beri sedikit delay (opsional) agar transisi smooth
                        setTimeout(() => {
                            this.showWaitNotification = true;
                        }, 100);
                    } else {
                        // Jika hanya minuman/camilan, langsung selesai
                        this.showPayment = false;
                        alert('Transaksi Berhasil!');
                        this.cart = [];
                        this.cashReceived = 0;
                    }
                },

                // Tambahkan di dalam return posSystem()
                get lowStockItems() {
                    return this.menus.filter(m => m.stok < 10);
                },

                get lowStockCount() {
                    return this.lowStockItems.length;
                },

                // Fungsi saat klik "Ya, Tunggu" di Modal 1 (BARU)
                goToInputDetails() {
                    this.showWaitNotification = false;
                    setTimeout(() => {
                        this.showInputDetails = true;
                    }, 100);
                },

                // Fungsi saat klik "Kembali" di Modal 2 (BARU)
                backToNotification() {
                    this.showInputDetails = false;
                    setTimeout(() => {
                        this.showWaitNotification = true;
                    }, 100);
                },

                finishOrder() {
                    this.showWaitNotification = false;
                    this.showInputDetails = false;
                    
                    // Munculkan modal sukses
                    this.showSuccess = true;
                },

                closeSuccess() {
                    this.showSuccess = false;
                    // Reset Cart setelah transaksi benar-benar selesai
                    this.cart = [];
                    this.cashReceived = 0;
                    this.nomorMeja = '';
                    this.namaPelanggan = '';
                },

                printReceipt() {
                    alert('Mencetak Struk...');
                },

                completeTransaction() {
                    this.showPayment = false;
                    this.cart = [];
                    this.cashReceived = 0;
                    alert('Transaksi Berhasil!');
                },

                // --- Helpers ---
                formatPrice(v) {
                    return new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        maximumFractionDigits: 0
                    }).format(v);
                },

                init() {
                    window.addEventListener('add-to-cart', (e) => this.addToCartById(e.detail));
                }
            }
        }
    </script>
</body>

</html>