<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/PengajuanModel.php';

// Ambil data antrean (sudah diurut dari paling awal)
$antrean = PengajuanModel::getAntrean();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <!-- Header dengan tombol back -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <!-- Tombol back ke dashboard -->
            <a href="../dashboard_petugas.php" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-army/10 text-army hover:bg-army hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-army-dark flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Antrean Pengajuan
                </h1>
                <p class="text-gray-500 text-sm mt-1">Daftar permintaan barang yang menunggu persetujuan</p>
            </div>
        </div>
        <!-- Info jumlah antrean -->
        <div class="mt-3 sm:mt-0 inline-flex items-center px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-sm font-medium">
            <span class="w-2 h-2 bg-orange-500 rounded-full mr-2"></span>
            <?= $antrean->num_rows ?> pengajuan menunggu
        </div>
    </div>

    <!-- Tabel Antrean -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-army/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Pemohon</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Tanggal Pengajuan</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-army-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if($antrean->num_rows > 0): ?>
                    <?php while($row = $antrean->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-army-light/20 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <?= htmlspecialchars($row['pemohon']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="inline-flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <?= htmlspecialchars($row['nama_barang']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                            <?= $row['jumlah'] ?> unit
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('d/m/Y H:i', strtotime($row['tanggal_pengajuan'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                            <a href="../../controllers/PengajuanController.php?action=approve&id=<?= $row['id'] ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition shadow-sm"
                               onclick="return confirm('Setujui pengajuan ini? Stok akan dikurangi secara otomatis.')">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Setujui
                            </a>
                            <a href="../../controllers/PengajuanController.php?action=reject&id=<?= $row['id'] ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition shadow-sm"
                               onclick="return confirm('Tolak pengajuan ini?')">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                Tolak
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Tidak ada antrean pengajuan saat ini.
                            <p class="text-sm mt-1">Semua permintaan sudah diproses.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>