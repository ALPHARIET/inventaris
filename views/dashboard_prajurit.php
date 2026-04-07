<?php 
require_once '../includes/auth.php'; 
if(!isPrajurit()) die("Akses ditolak"); 
require_once '../config/database.php';

// Ambil statistik untuk prajurit yang sedang login
$id_prajurit = $_SESSION['user_id'];

// Jumlah pengajuan yang masih menunggu
$result = $conn->query("SELECT COUNT(*) as total FROM pengajuan WHERE id_prajurit = $id_prajurit AND status = 'menunggu'");
$menunggu = $result->fetch_assoc()['total'];

// Jumlah pengajuan yang disetujui
$result = $conn->query("SELECT COUNT(*) as total FROM pengajuan WHERE id_prajurit = $id_prajurit AND status = 'disetujui'");
$disetujui = $result->fetch_assoc()['total'];

// Jumlah pengajuan yang ditolak
$result = $conn->query("SELECT COUNT(*) as total FROM pengajuan WHERE id_prajurit = $id_prajurit AND status = 'ditolak'");
$ditolak = $result->fetch_assoc()['total'];

// Jumlah pengembalian yang masih menunggu verifikasi
$result = $conn->query("SELECT COUNT(*) as total FROM pengembalian WHERE id_prajurit = $id_prajurit AND status = 'diajukan'");
$pengembalian_menunggu = $result->fetch_assoc()['total'];

// Ambil 5 pengajuan terakhir
$riwayat_pengajuan = $conn->query("
    SELECT p.id, b.nama_barang, p.jumlah, p.status, p.tanggal_pengajuan 
    FROM pengajuan p 
    JOIN barang b ON p.id_barang = b.id 
    WHERE p.id_prajurit = $id_prajurit 
    ORDER BY p.tanggal_pengajuan DESC 
    LIMIT 5
");

// Ambil 5 pengembalian terakhir
$riwayat_pengembalian = $conn->query("
    SELECT p.id, b.nama_barang, p.jumlah_kembali, p.kondisi, p.status, p.tanggal_kembali 
    FROM pengembalian p 
    JOIN barang b ON p.id_barang = b.id 
    WHERE p.id_prajurit = $id_prajurit 
    ORDER BY p.tanggal_kembali DESC 
    LIMIT 5
");
?>
<?php require_once '../includes/header.php'; ?>

<div class="space-y-6">
    <!-- Selamat Datang dengan efek gradasi -->
    <div class="bg-gradient-to-r from-army to-army-dark rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold flex items-center gap-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>
                </h1>
                <p class="text-green-100 mt-1">Prajurit TNI, kelola permintaan dan pengembalian barang dengan mudah.</p>
            </div>
            <div class="mt-3 md:mt-0 flex gap-2">
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Role: Prajurit</span>
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">ID: <?= $_SESSION['user_id'] ?></span>
            </div>
        </div>
    </div>

    <!-- Kartu Statistik Interaktif -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-yellow-500 card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pengajuan Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-600"><?= $menunggu ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <a href="pengajuan/daftar.php?filter=menunggu" class="text-xs text-yellow-600 mt-3 inline-block hover:underline">Lihat detail →</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-green-500 card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pengajuan Disetujui</p>
                    <p class="text-3xl font-bold text-green-600"><?= $disetujui ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <a href="pengajuan/daftar.php?filter=disetujui" class="text-xs text-green-600 mt-3 inline-block hover:underline">Lihat detail →</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-red-500 card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pengajuan Ditolak</p>
                    <p class="text-3xl font-bold text-red-600"><?= $ditolak ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </div>
            </div>
            <a href="pengajuan/daftar.php?filter=ditolak" class="text-xs text-red-600 mt-3 inline-block hover:underline">Lihat detail →</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-blue-500 card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pengembalian Menunggu</p>
                    <p class="text-3xl font-bold text-blue-600"><?= $pengembalian_menunggu ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
            </div>
            <a href="pengembalian/riwayat.php?filter=menunggu" class="text-xs text-blue-600 mt-3 inline-block hover:underline">Lihat detail →</a>
        </div>
    </div>

    <!-- Menu Aksi Cepat -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
            <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Aksi Cepat
            </h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="pengajuan/buat.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-army/20 flex items-center justify-center group-hover:bg-army/30">
                    <svg class="w-6 h-6 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Buat Pengajuan Baru</p>
                    <p class="text-sm text-gray-500">Ajukan permintaan barang yang diperlukan</p>
                </div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="pengembalian/buat.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-army/20 flex items-center justify-center group-hover:bg-army/30">
                    <svg class="w-6 h-6 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Pengembalian Barang</p>
                    <p class="text-sm text-gray-500">Kembalikan barang setelah selesai digunakan</p>
                </div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="pengajuan/daftar.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-army/20 flex items-center justify-center group-hover:bg-army/30">
                    <svg class="w-6 h-6 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Riwayat Pengajuan</p>
                    <p class="text-sm text-gray-500">Lihat status permintaan barang Anda</p>
                </div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="pengembalian/riwayat.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-army/20 flex items-center justify-center group-hover:bg-army/30">
                    <svg class="w-6 h-6 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Riwayat Pengembalian</p>
                    <p class="text-sm text-gray-500">Lihat verifikasi pengembalian barang</p>
                </div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Riwayat Terbaru (Pengajuan & Pengembalian) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pengajuan Terbaru -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Pengajuan Terbaru
                </h2>
                <a href="pengajuan/daftar.php" class="text-xs text-army hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php if($riwayat_pengajuan->num_rows > 0): ?>
                    <?php while($row = $riwayat_pengajuan->fetch_assoc()): ?>
                        <?php
                        $status_class = '';
                        $status_text = '';
                        if($row['status'] == 'menunggu') { $status_class = 'bg-yellow-100 text-yellow-700'; $status_text = 'Menunggu'; }
                        elseif($row['status'] == 'disetujui') { $status_class = 'bg-green-100 text-green-700'; $status_text = 'Disetujui'; }
                        else { $status_class = 'bg-red-100 text-red-700'; $status_text = 'Ditolak'; }
                        ?>
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($row['nama_barang']) ?></p>
                                    <p class="text-sm text-gray-500">Jumlah: <?= $row['jumlah'] ?> unit</p>
                                    <p class="text-xs text-gray-400 mt-1"><?= date('d/m/Y H:i', strtotime($row['tanggal_pengajuan'])) ?></p>
                                </div>
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium <?= $status_class ?>"><?= $status_text ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-400">Belum ada pengajuan</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pengembalian Terbaru -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Pengembalian Terbaru
                </h2>
                <a href="pengembalian/riwayat.php" class="text-xs text-army hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php if($riwayat_pengembalian->num_rows > 0): ?>
                    <?php while($row = $riwayat_pengembalian->fetch_assoc()): ?>
                        <?php
                        $status_class = $row['status'] == 'diajukan' ? 'bg-yellow-100 text-yellow-700' : 'bg-green-100 text-green-700';
                        $status_text = $row['status'] == 'diajukan' ? 'Menunggu' : 'Diterima';
                        $kondisi_class = '';
                        if($row['kondisi'] == 'Baik') $kondisi_class = 'bg-green-100 text-green-700';
                        elseif($row['kondisi'] == 'Rusak') $kondisi_class = 'bg-red-100 text-red-700';
                        else $kondisi_class = 'bg-yellow-100 text-yellow-700';
                        ?>
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($row['nama_barang']) ?></p>
                                    <p class="text-sm text-gray-500">Jumlah: <?= $row['jumlah_kembali'] ?> unit</p>
                                    <div class="flex gap-2 mt-1">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium <?= $kondisi_class ?>"><?= $row['kondisi'] ?></span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1"><?= date('d/m/Y H:i', strtotime($row['tanggal_kembali'])) ?></p>
                                </div>
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium <?= $status_class ?>"><?= $status_text ?></span>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-400">Belum ada pengembalian</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>