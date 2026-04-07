<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/PengembalianModel.php';

// Ambil data pengembalian yang statusnya 'diajukan'
$pengembalian = PengembalianModel::getVerifikasi();
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
                    Verifikasi Pengembalian
                </h1>
                <p class="text-gray-500 text-sm mt-1">Daftar barang yang dikembalikan prajurit menunggu verifikasi</p>
            </div>
        </div>
        <!-- Info jumlah pengembalian -->
        <div class="mt-3 sm:mt-0 inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
            <span class="w-2 h-2 bg-blue-500 rounded-full mr-2"></span>
            <?= $pengembalian->num_rows ?> pengembalian menunggu
        </div>
    </div>

    <!-- Tabel Pengembalian -->
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-army/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Prajurit</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Jumlah Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Tanggal Pengembalian</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-army-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if($pengembalian->num_rows > 0): ?>
                    <?php while($row = $pengembalian->fetch_assoc()): ?>
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 rounded-full bg-army-light/20 flex items-center justify-center">
                                    <svg class="w-3 h-3 text-army" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <?= htmlspecialchars($row['prajurit']) ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            <span class="inline-flex items-center gap-1">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <?= htmlspecialchars($row['nama_barang']) ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-800">
                            <?= $row['jumlah_kembali'] ?> unit
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php 
                            $kondisi = $row['kondisi'];
                            $badgeClass = '';
                            if($kondisi == 'Baik') $badgeClass = 'bg-green-100 text-green-700';
                            elseif($kondisi == 'Rusak') $badgeClass = 'bg-red-100 text-red-700';
                            else $badgeClass = 'bg-yellow-100 text-yellow-700';
                            ?>
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= $badgeClass ?>">
                                <?= $kondisi ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="<?= htmlspecialchars($row['catatan']) ?>">
                            <?= htmlspecialchars($row['catatan'] ?: '-') ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            <?= date('d/m/Y H:i', strtotime($row['tanggal_kembali'])) ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <a href="../../controllers/PengembalianController.php?action=terima&id=<?= $row['id'] ?>" 
                               class="inline-flex items-center px-3 py-1.5 bg-army hover:bg-army-dark text-white text-xs font-medium rounded-lg transition shadow-sm"
                               onclick="return confirm('Terima pengembalian ini? Stok akan ditambahkan kembali. Jika kondisi Rusak, akan tercatat di log otomatis.')">
                                <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Terima
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Tidak ada pengembalian yang menunggu verifikasi.
                            <p class="text-sm mt-1">Semua pengembalian sudah diproses.</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>