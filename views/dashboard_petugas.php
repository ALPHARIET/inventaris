<?php 
require_once '../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../config/database.php';

// Statistik
$total_barang = $conn->query("SELECT COUNT(*) as total FROM barang")->fetch_assoc()['total'];
$total_kategori = $conn->query("SELECT COUNT(*) as total FROM kategori")->fetch_assoc()['total'];
$pengajuan_menunggu = $conn->query("SELECT COUNT(*) as total FROM pengajuan WHERE status='menunggu'")->fetch_assoc()['total'];
$pengembalian_menunggu = $conn->query("SELECT COUNT(*) as total FROM pengembalian WHERE status='diajukan'")->fetch_assoc()['total'];

// 5 antrean pengajuan terbaru
$antrean = $conn->query("
    SELECT p.id, u.nama_lengkap, b.nama_barang, p.jumlah, p.tanggal_pengajuan 
    FROM pengajuan p 
    JOIN users u ON p.id_prajurit = u.id 
    JOIN barang b ON p.id_barang = b.id 
    WHERE p.status = 'menunggu' 
    ORDER BY p.tanggal_pengajuan ASC 
    LIMIT 5
");

// 5 pengembalian menunggu verifikasi terbaru
$verifikasi = $conn->query("
    SELECT p.id, u.nama_lengkap, b.nama_barang, p.jumlah_kembali, p.kondisi, p.tanggal_kembali 
    FROM pengembalian p 
    JOIN users u ON p.id_prajurit = u.id 
    JOIN barang b ON p.id_barang = b.id 
    WHERE p.status = 'diajukan' 
    ORDER BY p.tanggal_kembali ASC 
    LIMIT 5
");
?>
<?php require_once '../includes/header.php'; ?>

<div class="space-y-6">
    <!-- Header Welcome -->
    <div class="bg-gradient-to-r from-army to-army-dark rounded-xl shadow-lg p-6 text-white">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold flex items-center gap-2">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Selamat Datang, <?= htmlspecialchars($_SESSION['nama']) ?>
                </h1>
                <p class="text-green-100 mt-1">Petugas Logistik, kelola inventaris dan verifikasi permintaan prajurit.</p>
            </div>
            <div class="mt-3 md:mt-0 flex gap-2">
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Role: Petugas</span>
                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">ID: <?= $_SESSION['user_id'] ?></span>
            </div>
        </div>
    </div>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-army card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Total Barang</p>
                    <p class="text-3xl font-bold text-army"><?= $total_barang ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-army/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <a href="barang/index.php" class="text-xs text-army mt-3 inline-block hover:underline">Kelola Barang →</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-army-light card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Total Kategori</p>
                    <p class="text-3xl font-bold text-army-light"><?= $total_kategori ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-army-light/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-army-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>
                </div>
            </div>
            <a href="kategori/index.php" class="text-xs text-army-light mt-3 inline-block hover:underline">Kelola Kategori →</a>
        </div>

        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-yellow-500 card-hover transition transform hover:-translate-y-1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-gray-500 text-sm">Pengajuan Menunggu</p>
                    <p class="text-3xl font-bold text-yellow-600"><?= $pengajuan_menunggu ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <a href="pengajuan/antrean.php" class="text-xs text-yellow-600 mt-3 inline-block hover:underline">Proses Sekarang →</a>
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
            <a href="pengembalian/verifikasi.php" class="text-xs text-blue-600 mt-3 inline-block hover:underline">Verifikasi →</a>
        </div>
    </div>

    <!-- Menu Aksi Cepat -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
            <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                Menu Administrasi
            </h2>
        </div>
        <div class="p-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <a href="barang/index.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-army/20 flex items-center justify-center"><svg class="w-6 h-6 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg></div>
                <div><p class="font-semibold">Manajemen Barang</p><p class="text-sm text-gray-500">Tambah, edit, hapus barang</p></div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="kategori/index.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-army/20 flex items-center justify-center"><svg class="w-6 h-6 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg></div>
                <div><p class="font-semibold">Manajemen Kategori</p><p class="text-sm text-gray-500">Kelompokkan jenis barang</p></div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="pengajuan/antrean.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center"><svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                <div><p class="font-semibold">Antrean Pengajuan</p><p class="text-sm text-gray-500">Setujui/tolak permintaan</p></div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="pengembalian/verifikasi.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center"><svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg></div>
                <div><p class="font-semibold">Verifikasi Pengembalian</p><p class="text-sm text-gray-500">Terima & catat kondisi barang</p></div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
            <a href="laporan/rekap.php" class="flex items-center gap-4 p-4 bg-army/5 rounded-lg hover:bg-army/10 transition group">
                <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center"><svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></div>
                <div><p class="font-semibold">Laporan Komando</p><p class="text-sm text-gray-500">Rekap real-time per kategori</p></div>
                <svg class="w-5 h-5 ml-auto text-gray-400 group-hover:translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </a>
        </div>
    </div>

    <!-- Dua Kolom: Antrean & Verifikasi Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Antrean Pengajuan Terbaru -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Antrean Pengajuan Terbaru
                </h2>
                <a href="pengajuan/antrean.php" class="text-xs text-army hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php if($antrean->num_rows > 0): ?>
                    <?php while($row = $antrean->fetch_assoc()): ?>
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($row['nama_barang']) ?></p>
                                    <p class="text-sm text-gray-500">Pemohon: <?= htmlspecialchars($row['nama_lengkap']) ?> | Jumlah: <?= $row['jumlah'] ?> unit</p>
                                    <p class="text-xs text-gray-400 mt-1"><?= date('d/m/Y H:i', strtotime($row['tanggal_pengajuan'])) ?></p>
                                </div>
                                <a href="pengajuan/antrean.php" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded-full">Proses</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-400">Tidak ada antrean pengajuan</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Pengembalian Menunggu Verifikasi Terbaru -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100 flex justify-between items-center">
                <h2 class="font-semibold text-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    Pengembalian Menunggu Verifikasi
                </h2>
                <a href="pengembalian/verifikasi.php" class="text-xs text-army hover:underline">Lihat semua →</a>
            </div>
            <div class="divide-y divide-gray-100">
                <?php if($verifikasi->num_rows > 0): ?>
                    <?php while($row = $verifikasi->fetch_assoc()): ?>
                        <?php
                        $kondisi_class = '';
                        if($row['kondisi'] == 'Baik') $kondisi_class = 'bg-green-100 text-green-700';
                        elseif($row['kondisi'] == 'Rusak') $kondisi_class = 'bg-red-100 text-red-700';
                        else $kondisi_class = 'bg-yellow-100 text-yellow-700';
                        ?>
                        <div class="p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800"><?= htmlspecialchars($row['nama_barang']) ?></p>
                                    <p class="text-sm text-gray-500">Prajurit: <?= htmlspecialchars($row['nama_lengkap']) ?> | Jumlah: <?= $row['jumlah_kembali'] ?> unit</p>
                                    <div class="flex gap-2 mt-1">
                                        <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium <?= $kondisi_class ?>"><?= $row['kondisi'] ?></span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-1"><?= date('d/m/Y H:i', strtotime($row['tanggal_kembali'])) ?></p>
                                </div>
                                <a href="pengembalian/verifikasi.php" class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">Verifikasi</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="p-6 text-center text-gray-400">Tidak ada pengembalian menunggu</div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require_once '../includes/footer.php'; ?>