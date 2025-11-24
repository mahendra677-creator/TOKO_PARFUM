<?php
// ======================================================================
// 1. INICIALISASI PHP & PENGATURAN SESSION
// ======================================================================
session_start();

// Inisialisasi Keranjang jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// ======================================================================
// 2. DATA MOCK (SIMULASI DATABASE berdasarkan parfum.sql)
// ======================================================================
$products = [
    [ 
        'parfum_id' => 1, 
        'nama_parfum' => 'Midnight Bloom', 
        'nama_merek' => 'Aroma Lux',
        'nama_aroma' => 'Floral', 
        'ukuran_ml' => 100, 
        'harga' => 1250000, 
        'stok' => 50, 
        'deskripsi' => 'Aroma bunga malam yang misterius dan mewah, cocok untuk acara malam.',
        'image_url' => 'https://tse1.mm.bing.net/th/id/OIP.aa3l6Km4BxX8NFM-I04NawHaHa?pid=Api&h=220&P=0' 
    ],
    [ 
        'parfum_id' => 2, 
        'nama_parfum' => 'Ocean Breeze', 
        'nama_merek' => 'Scent Co.',
        'nama_aroma' => 'Fresh', 
        'ukuran_ml' => 120, 
        'harga' => 550000, 
        'stok' => 80, 
        'deskripsi' => 'Kesegaran seperti angin laut yang bersih dan menyegarkan, ideal untuk harian.',
        'image_url' => 'https://tse3.mm.bing.net/th/id/OIP.6G-L8_StOiZ0KkWBDguowgHaHa?pid=Api&h=220&P=0'
    ],
    [ 
        'parfum_id' => 3, 
        'nama_parfum' => 'Citrus Zest', 
        'nama_merek' => 'Fresh Essence',
        'nama_aroma' => 'Citrus', 
        'ukuran_ml' => 75, 
        'harga' => 780000, 
        'stok' => 30, 
        'deskripsi' => 'Aroma jeruk yang cerah dan energik, pembangkit semangat di pagi hari.',
        'image_url' => 'https://tse3.mm.bing.net/th/id/OIP.n-l2KjK8AXtpH0O8R6iVYAHaHa?pid=Api&h=220&P=0'
    ],
    [ 
        'parfum_id' => 4, 
        'nama_parfum' => 'Leather Nights', 
        'nama_merek' => 'Classico',
        'nama_aroma' => 'Woody', 
        'ukuran_ml' => 90, 
        'harga' => 1800000, 
        'stok' => 15, 
        'deskripsi' => 'Kombinasi kulit dan kayu yang maskulin dan berkarakter, sangat elegan.',
        'image_url' => 'https://tse2.mm.bing.net/th/id/OIP.pVd9Qs37oyMwdbhC-mYXUwHaHa?pid=Api&h=220&P=0'
    ],
    
];

$payment_methods = [
    1 => 'Transfer Bank BCA',
    2 => 'Kartu Kredit Visa',
    3 => 'E-Wallet GoPay',
];

$shipping_cost = 25000;
$shipping_service = 'JNE Reguler';


// ======================================================================
// 3. FUNGSI BISNIS & BANTUAN
// ======================================================================

/**
 * Format angka ke Rupiah.
 * @param int|float $number
 * @return string
 */
function formatRupiah($number) {
    return 'Rp ' . number_format($number, 0, ',', '.');
}

/**
 * Mendapatkan produk berdasarkan ID.
 * @param int $id
 * @param array $products
 * @return array|null
 */
function getProductById($id, $products) {
    foreach ($products as $product) {
        if ($product['parfum_id'] == $id) {
            return $product;
        }
    }
    return null;
}

/**
 * Menghitung ringkasan keranjang.
 * @param array $cart
 * @param array $products
 * @param int $shipping_cost
 * @return array
 */
function getCartSummary($cart, $products, $shipping_cost) {
    $subtotal = 0;
    $total_items = 0;
    
    foreach ($cart as $parfum_id => $quantity) {
        $product = getProductById($parfum_id, $products);
        if ($product) {
            $subtotal += $product['harga'] * $quantity;
            $total_items += $quantity;
        }
    }

    $total_akhir = $subtotal > 0 ? $subtotal + $shipping_cost : 0;

    return [
        'subtotal' => $subtotal,
        'total_items' => $total_items,
        'total_akhir' => $total_akhir,
        'shipping_cost' => $subtotal > 0 ? $shipping_cost : 0,
    ];
}

$cart_summary = getCartSummary($_SESSION['cart'], $products, $shipping_cost);


// ======================================================================
// 4. LOGIKA HANDLER (PENGOLAHAN REQUEST)
// ======================================================================

$notification = ['message' => '', 'type' => ''];
$view = isset($_GET['view']) ? $_GET['view'] : 'home';

// Aksi Keranjang
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    // Fungsi alert kustom
    function set_notification($message, $type) {
        global $notification;
        $notification = ['message' => $message, 'type' => $type];
    }
    
    // Tambah ke Keranjang
    if ($_POST['action'] === 'add_to_cart' && isset($_POST['parfum_id'])) {
        $id = (int)$_POST['parfum_id'];
        $product = getProductById($id, $products);

        if ($product) {
            if (isset($_SESSION['cart'][$id])) {
                $_SESSION['cart'][$id]++;
            } else {
                $_SESSION['cart'][$id] = 1;
            }
            set_notification($product['nama_parfum'] . ' ditambahkan ke keranjang.', 'success');
        }
    }

    // Update Jumlah Keranjang
    if ($_POST['action'] === 'update_cart' && isset($_POST['parfum_id'], $_POST['quantity'])) {
        $id = (int)$_POST['parfum_id'];
        $quantity = (int)$_POST['quantity'];
        $product = getProductById($id, $products);
        
        if ($product) {
            if ($quantity > 0) {
                $_SESSION['cart'][$id] = $quantity;
                set_notification('Jumlah ' . $product['nama_parfum'] . ' diperbarui.', 'success');
            } else {
                unset($_SESSION['cart'][$id]);
                set_notification($product['nama_parfum'] . ' dihapus dari keranjang.', 'warning');
            }
        }
        $view = 'cart'; // Tetap di halaman keranjang
    }

    // Checkout (Simulasi Transaksi)
    if ($_POST['action'] === 'process_checkout') {
        if ($cart_summary['subtotal'] > 0) {
            // Lakukan simulasi penyimpanan ke database
            $order_data = [
                'tanggal_pesanan' => date('Y-m-d H:i:s'),
                'total_akhir' => $cart_summary['total_akhir'],
                'nama_pelanggan' => filter_input(INPUT_POST, 'nama_lengkap', FILTER_SANITIZE_STRING),
                'alamat' => filter_input(INPUT_POST, 'alamat_pengiriman', FILTER_SANITIZE_STRING),
                'metode_pembayaran' => $payment_methods[(int)filter_input(INPUT_POST, 'metode_pembayaran_id', FILTER_SANITIZE_NUMBER_INT)],
                'items' => [],
            ];
            
            foreach ($_SESSION['cart'] as $parfum_id => $quantity) {
                $product = getProductById($parfum_id, $products);
                if ($product) {
                    $order_data['items'][] = [
                        'nama_parfum' => $product['nama_parfum'],
                        'quantity' => $quantity,
                        'harga_saat_beli' => $product['harga'],
                    ];
                }
            }

            // SIMULASI: Data transaksi order_data akan disimpan ke file/database nyata di lingkungan produksi.
            // Setelah berhasil, kosongkan keranjang:
            $_SESSION['cart'] = [];
            
            // Atur view ke halaman sukses
            $view = 'success';
            set_notification('Pesanan Anda berhasil diproses!', 'success');
        } else {
            set_notification('Keranjang kosong, tidak dapat memproses pesanan.', 'error');
            $view = 'cart';
        }
    }
    
    // Perbarui ringkasan setelah aksi
    $cart_summary = getCartSummary($_SESSION['cart'], $products, $shipping_cost);
}


// ======================================================================
// 5. STRUKTUR HTML & TAMPILAN
// ======================================================================
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aroma Eksklusif - Toko Parfum Online</title>
    <!-- Memuat Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f7f7;
        }
        .parfum-primary { background-color: #4f46e5; }
        .parfum-primary-text { color: #4f46e5; }
        .parfum-secondary { background-color: #e0e7ff; }
        .parfum-card:hover .product-image {
            transform: scale(1.05) rotate(-3deg);
            transition: transform 0.3s ease-in-out;
        }
    </style>
</head>
<body>

    <!-- Header & Navigasi -->
    <header class="bg-white shadow-lg sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="?view=home" class="text-3xl font-bold text-gray-800 tracking-wider">
                <span class="parfum-primary-text">Aroma</span> Eksklusif
            </a>

            <!-- Navigasi & Keranjang -->
            <nav class="flex items-center space-x-6">
                <a href="?view=home" class="text-gray-600 hover:text-indigo-600 font-medium transition duration-150 hidden sm:block">Beranda</a>
                
                <a href="?view=cart" class="relative p-2 rounded-full bg-indigo-50 hover:bg-indigo-100 transition duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-gray-700"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.82a2 2 0 0 0 1.95-1.58L23 10H7"/></svg>
                    <?php if ($cart_summary['total_items'] > 0): ?>
                        <span class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full">
                            <?php echo $cart_summary['total_items']; ?>
                        </span>
                    <?php endif; ?>
                </a>
            </nav>
        </div>
    </header>

    <!-- Notification Modal -->
    <div id="custom-alert" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 p-4" onclick="closeAlert()">
        <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm w-full transform transition-all duration-300 scale-95" onclick="event.stopPropagation()">
            <h3 class="text-xl font-bold mb-3 flex items-center text-indigo-600">
                Notifikasi
            </h3>
            <p id="alert-message" class="text-gray-700 mb-4"></p>
            <button onclick="closeAlert()" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded-lg">
                OK
            </button>
        </div>
    </div>
    
    <!-- Konten Utama -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <?php 
        // Tampilkan notifikasi jika ada
        if (!empty($notification['message'])): 
            // Inisialisasi notifikasi dengan JavaScript
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    alertCustom('" . addslashes($notification['message']) . "', '" . $notification['type'] . "');
                });
            </script>";
        endif; 
        ?>

        <?php 
        // ----------------------------------------------------
        // 6. RENDER VIEW SESUAI VARIABEL $view
        // ----------------------------------------------------
        
        if ($view === 'home'): ?>

            <!-- Hero Section -->
            <section class="parfum-primary text-white py-16 sm:py-24 rounded-2xl shadow-xl mb-10">
                <div class="flex flex-col md:flex-row items-center justify-between px-6">
                    <div class="md:w-1/2 text-center md:text-left mb-10 md:mb-0">
                        <h1 class="text-4xl sm:text-6xl font-extrabold leading-tight mb-4">
                            Wewangian yang <span class="text-indigo-200">Menyihir</span>.
                        </h1>
                        <p class="text-lg sm:text-xl text-gray-300 mb-8">
                            Temukan koleksi parfum terbaik, hanya untuk Anda. Pengiriman cepat, jaminan original.
                        </p>
                        <a href="#produk" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 transform hover:scale-105">
                            Telusuri Katalog
                        </a>
                    </div>
                    <div class="md:w-1/2 flex justify-center">
                        <div class="relative w-64 h-80 sm:w-80 sm:h-96 bg-gray-700 rounded-xl shadow-2xl overflow-hidden flex items-center justify-center border-4 border-indigo-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="text-indigo-400 opacity-80"><path d="M14 9V5a3 3 0 0 0-3-3l-4 9v11h11.28a2 2 0 0 0 2-1.76l1.5-9A2 2 0 0 0 14 9z"/></svg>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Product Grid Section -->
            <section id="produk" class="py-10">
                <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-12">Produk Unggulan</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                    
                    <?php foreach ($products as $product): ?>
                        <div class="parfum-card bg-white p-6 rounded-xl shadow-lg hover:shadow-2xl transition duration-300 flex flex-col items-center text-center border border-gray-100">
                            <div class="overflow-hidden mb-4 w-40 h-40 product-image">
                                <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['nama_parfum']; ?>" class="w-full h-full object-cover rounded-lg">
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-1"><?php echo $product['nama_parfum']; ?></h3>
                            <p class="text-sm text-gray-500 mb-3"><?php echo $product['nama_merek']; ?> - <?php echo $product['ukuran_ml']; ?>ml</p>
                            <p class="text-3xl font-extrabold parfum-primary-text mb-4"><?php echo formatRupiah($product['harga']); ?></p>
                            
                            <form method="POST" action="?view=home">
                                <input type="hidden" name="action" value="add_to_cart">
                                <input type="hidden" name="parfum_id" value="<?php echo $product['parfum_id']; ?>">
                                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-3 px-6 rounded-full transition duration-300 shadow-md flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M5 20h14M17 10h-2M10 10h-2M8 12V8M19 12h-2M12 19V5M10 19V5M8 19V5M19 19V5"/></svg>
                                    Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>

                </div>
            </section>

        <?php elseif ($view === 'cart'): ?>
            
            <!-- Halaman Keranjang -->
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-3 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-3 parfum-primary-text"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.82a2 2 0 0 0 1.95-1.58L23 10H7"/></svg>
                Keranjang Belanja Anda
            </h2>
            
            <?php if ($cart_summary['total_items'] === 0): ?>
                <div class="text-center py-10 border border-dashed border-gray-300 rounded-lg bg-gray-50">
                    <p class="text-xl text-gray-600 mb-4">Keranjang Anda masih kosong.</p>
                    <a href="?view=home" class="text-indigo-600 hover:text-indigo-800 font-semibold flex items-center mx-auto w-fit">
                        &larr; Lanjut Berbelanja
                    </a>
                </div>
            <?php else: ?>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Item List -->
                    <div class="lg:col-span-2 space-y-4">
                        <?php 
                        $current_cart_items = [];
                        foreach ($_SESSION['cart'] as $parfum_id => $quantity) {
                            $product = getProductById($parfum_id, $products);
                            if ($product) {
                                $current_cart_items[] = ['product' => $product, 'quantity' => $quantity];
                            }
                        }
                        ?>

                        <?php foreach ($current_cart_items as $item): ?>
                            <div class="flex flex-col sm:flex-row items-center p-4 bg-white rounded-xl shadow-md border border-gray-100">
                                <img src="<?php echo $item['product']['image_url']; ?>" alt="<?php echo $item['product']['nama_parfum']; ?>" class="w-16 h-16 object-contain rounded-md mr-4 bg-gray-50 p-1 mb-4 sm:mb-0" />
                                
                                <div class="flex-grow text-center sm:text-left">
                                    <p class="font-bold text-gray-800"><?php echo $item['product']['nama_parfum']; ?></p>
                                    <p class="text-sm text-gray-500"><?php echo formatRupiah($item['product']['harga']); ?></p>
                                </div>
                                
                                <form method="POST" action="?view=cart" class="flex items-center space-x-2 mt-4 sm:mt-0">
                                    <input type="hidden" name="action" value="update_cart">
                                    <input type="hidden" name="parfum_id" value="<?php echo $item['product']['parfum_id']; ?>">
                                    
                                    <!-- Tombol Kurang -->
                                    <button 
                                        type="submit" 
                                        name="quantity" 
                                        value="<?php echo max(0, $item['quantity'] - 1); ?>" 
                                        class="p-1 border border-gray-300 rounded-full hover:bg-gray-200 transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/></svg>
                                    </button>
                                    
                                    <span class="font-semibold w-6 text-center"><?php echo $item['quantity']; ?></span>
                                    
                                    <!-- Tombol Tambah -->
                                    <button 
                                        type="submit" 
                                        name="quantity" 
                                        value="<?php echo $item['quantity'] + 1; ?>" 
                                        class="p-1 border border-gray-300 rounded-full hover:bg-gray-200 transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
                                    </button>

                                    <!-- Tombol Hapus (Set quantity ke 0) -->
                                    <button 
                                        type="submit" 
                                        name="quantity" 
                                        value="0" 
                                        title="Hapus item"
                                        class="p-1 ml-2 text-red-500 hover:text-red-700 transition"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                    </button>
                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- Ringkasan Belanja -->
                    <div class="lg:col-span-1 parfum-secondary p-6 rounded-xl shadow-lg h-fit sticky top-20">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-indigo-300 pb-2">Ringkasan Pesanan</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between text-gray-700">
                                <span>Subtotal (<?php echo $cart_summary['total_items']; ?> item)</span>
                                <span class="font-semibold"><?php echo formatRupiah($cart_summary['subtotal']); ?></span>
                            </div>
                            <div class="flex justify-between text-gray-700">
                                <span>Biaya Pengiriman (<?php echo $shipping_service; ?>)</span>
                                <span class="font-semibold"><?php echo formatRupiah($cart_summary['shipping_cost']); ?></span>
                            </div>
                            <div class="flex justify-between font-extrabold text-2xl pt-4 border-t border-indigo-400">
                                <span>Total Akhir</span>
                                <span class="parfum-primary-text"><?php echo formatRupiah($cart_summary['total_akhir']); ?></span>
                            </div>
                        </div>

                        <a href="?view=checkout" class="mt-6 w-full block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-xl">
                            Lanjut ke Checkout
                        </a>
                        <a href="?view=home" class="mt-3 w-full block text-center text-indigo-600 border border-indigo-600 hover:bg-indigo-50 font-semibold py-3 rounded-lg transition duration-300">
                            &larr; Lanjut Berbelanja
                        </a>
                    </div>
                </div>
            <?php endif; ?>

        <?php elseif ($view === 'checkout'): ?>
            
            <!-- Halaman Checkout -->
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6 border-b pb-3">Checkout & Pembayaran</h2>

            <form method="POST" action="?view=checkout" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <input type="hidden" name="action" value="process_checkout">

                <!-- Kolom Kiri: Detail Pengiriman & Pembayaran -->
                <div>
                    <h3 class="text-xl font-bold mb-4 text-gray-700">1. Detail Pengiriman</h3>
                    
                    <div class="space-y-4">
                        <label class="block">
                            <span class="text-gray-700 font-medium">Nama Lengkap</span>
                            <input type="text" name="nama_lengkap" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required />
                        </label>
                        <label class="block">
                            <span class="text-gray-700 font-medium">Nomor Telepon</span>
                            <input type="text" name="nomor_telepon" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" required />
                        </label>
                        <label class="block">
                            <span class="text-gray-700 font-medium">Alamat Lengkap Pengiriman</span>
                            <textarea name="alamat_pengiriman" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm p-3 focus:ring-indigo-500 focus:border-indigo-500" rows="3" required></textarea>
                        </label>
                    </div>

                    <h3 class="text-xl font-bold mb-4 mt-8 text-gray-700">2. Metode Pembayaran</h3>
                    <div class="space-y-3">
                        <?php foreach ($payment_methods as $id => $name): ?>
                            <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                                <input 
                                    type="radio" 
                                    name="metode_pembayaran_id" 
                                    value="<?php echo $id; ?>" 
                                    class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500"
                                    <?php echo $id === 1 ? 'checked' : ''; ?>
                                    required
                                />
                                <span class="ml-3 text-gray-700 font-medium"><?php echo $name; ?></span>
                            </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Kolom Kanan: Ringkasan & Total -->
                <div class="parfum-secondary p-6 rounded-xl shadow-lg h-fit sticky top-20">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 border-b border-indigo-300 pb-2">Ringkasan Tagihan</h3>
                    
                    <div class="space-y-3 mb-6">
                        <?php foreach ($_SESSION['cart'] as $parfum_id => $quantity): ?>
                            <?php 
                            $product = getProductById($parfum_id, $products);
                            if ($product):
                            ?>
                                <div class="flex justify-between text-sm text-gray-700">
                                    <span><?php echo $product['nama_parfum']; ?> (<?php echo $quantity; ?>x)</span>
                                    <span><?php echo formatRupiah($product['harga'] * $quantity); ?></span>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="space-y-3 pt-4 border-t border-indigo-300">
                        <div class="flex justify-between text-gray-700">
                            <span>Subtotal Produk</span>
                            <span class="font-semibold"><?php echo formatRupiah($cart_summary['subtotal']); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-700">
                            <span>Biaya Pengiriman</span>
                            <span class="font-semibold"><?php echo formatRupiah($cart_summary['shipping_cost']); ?></span>
                        </div>
                        <div class="flex justify-between font-extrabold text-2xl pt-4 border-t border-indigo-400">
                            <span>TOTAL AKHIR</span>
                            <span class="parfum-primary-text"><?php echo formatRupiah($cart_summary['total_akhir']); ?></span>
                        </div>
                    </div>

                    <button 
                        type="submit"
                        class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-300 shadow-xl flex items-center justify-center"
                    >
                        Proses Pesanan & Bayar
                    </button>
                    <a href="?view=cart" class="mt-3 w-full block text-center text-indigo-600 border border-indigo-600 hover:bg-indigo-50 font-semibold py-3 rounded-lg transition duration-300">
                        &larr; Kembali ke Keranjang
                    </a>
                </div>
            </form>

        <?php elseif ($view === 'success'): ?>

            <!-- Halaman Sukses Transaksi -->
            <div class="max-w-md mx-auto p-8 text-center bg-white rounded-xl shadow-2xl mt-16 border-t-4 border-indigo-600">
                <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="parfum-primary-text mx-auto mb-6"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
                <h2 class="text-3xl font-extrabold text-gray-900 mb-4">Pesanan Selesai!</h2>
                <p class="text-gray-600 mb-6">
                    Terima kasih atas pesanan Anda. Kami telah memproses pesanan Anda dan akan segera mengirimkannya.
                </p>
                <p class="text-sm text-gray-500 mb-8">
                    Silakan cek email Anda untuk detail transaksi lengkap dan informasi pelacakan pengiriman.
                </p>
                <a href="?view=home" class="w-full inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-300">
                    Kembali ke Beranda
                </a>
            </div>

        <?php endif; ?>

    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white text-center py-6 mt-12">
        <p class="text-sm text-gray-400">&copy; <?php echo date('Y'); ?> Aroma Eksklusif. Hak Cipta Dilindungi.</p>
    </footer>

    <!-- JavaScript untuk Alert Kustom -->
    <script>
        const customAlert = document.getElementById('custom-alert');
        const alertMessage = document.getElementById('alert-message');

        function alertCustom(message, type = 'success') {
            alertMessage.textContent = message;
            
            // Set style berdasarkan type
            const header = customAlert.querySelector('h3');
            header.className = 'text-xl font-bold mb-3 flex items-center';

            if (type === 'success') {
                header.classList.add('text-green-600');
            } else if (type === 'warning') {
                header.classList.add('text-yellow-600');
            } else if (type === 'error') {
                header.classList.add('text-red-600');
            } else {
                header.classList.add('text-indigo-600');
            }

            customAlert.classList.remove('hidden');
            customAlert.classList.add('flex');
            
            // Animasi scale-in
            customAlert.querySelector('div').classList.remove('scale-95');
            customAlert.querySelector('div').classList.add('scale-100');

            // Auto-close setelah 4 detik (opsional)
            setTimeout(closeAlert, 4000); 
        }

        function closeAlert() {
            // Animasi scale-out
            customAlert.querySelector('div').classList.remove('scale-100');
            customAlert.querySelector('div').classList.add('scale-95');
            
            // Tunggu sebentar sebelum disembunyikan
            setTimeout(() => {
                customAlert.classList.remove('flex');
                customAlert.classList.add('hidden');
            }, 300); 
        }
    </script>
</body>
</html>