<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 

// Ambil data dari VIEW laporan_rekap
$laporan = $conn->query("SELECT * FROM laporan_rekap");

// Hitung total untuk persentase (jika perlu)
$total_keseluruhan = 0;
$data_laporan = [];
while($row = $laporan->fetch_assoc()) {
    $data_laporan[] = $row;
    $total_keseluruhan += $row['total_barang_keluar'];
}
// Reset pointer jika diperlukan (tidak perlu karena sudah diarray)
?>
<?php require_once '../../includes/header.php'; ?>

<div class="space-y-6">
    <!-- Header dengan tombol back -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100 bg-gray-50/50">
            <div class="flex items-center gap-3">
                <a href="../dashboard_petugas.php" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-army/10 text-army hover:bg-army hover:text-white transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-army-dark flex items-center gap-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Laporan Rekapitulasi Barang Keluar
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Data real-time pergerakan aset berdasarkan kategori</p>
                </div>
            </div>
            <div class="mt-3 sm:mt-0 inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                <span class="w-2 h-2 bg-green-500 rounded-full mr-2"></span>
                Real-time
            </div>
        </div>
    </div>

    <!-- Card Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-army">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Barang Keluar</p>
                    <p class="text-2xl font-bold text-army-dark"><?= array_sum(array_column($data_laporan, 'total_barang_keluar')) ?> unit</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-army/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-army-light">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Jenis Kategori</p>
                    <p class="text-2xl font-bold text-army-dark"><?= count($data_laporan) ?></p>
                </div>
                <div class="w-10 h-10 rounded-full bg-army-light/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-army-light" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-5 border-l-4 border-green-600">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total Transaksi</p>
                    <p class="text-2xl font-bold text-army-dark"><?= array_sum(array_column($data_laporan, 'jumlah_transaksi')) ?> kali</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Laporan + Progress Bar -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="px-6 py-4 bg-gray-50/50 border-b border-gray-100">
            <h2 class="font-semibold text-gray-700">Detail per Kategori</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-army/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Jumlah Transaksi</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Total Barang Keluar</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Persentase</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php if(!empty($data_laporan)): ?>
                        <?php foreach($data_laporan as $row): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                <span class="inline-flex items-center gap-1.5">
                                    <span class="w-2 h-2 bg-army rounded-full"></span>
                                    <?= htmlspecialchars($row['nama_kategori']) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                <?= $row['jumlah_transaksi'] ?> x
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                                <?= $row['total_barang_keluar'] ?> unit
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm w-64">
                                <div class="flex items-center gap-3">
                                    <div class="flex-1 bg-gray-200 rounded-full h-2">
                                        <div class="bg-army h-2 rounded-full" style="width: <?= $row['persentase'] ?>%"></div>
                                    </div>
                                    <span class="text-sm font-medium text-gray-600"><?= round($row['persentase'], 1) ?>%</span>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Belum ada data pengajuan yang disetujui.
                                <p class="text-sm mt-1">Laporan akan muncul setelah ada transaksi barang keluar.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Catatan Kaki -->
    <div class="text-xs text-gray-400 text-center">
        <p>Data diambil secara real-time dari database. Perubahan stok dan pengajuan akan langsung tercermin.</p>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>