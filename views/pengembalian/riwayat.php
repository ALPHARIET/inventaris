<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPrajurit()) die("Akses ditolak"); 
require_once '../../models/PengembalianModel.php';

$id_prajurit = $_SESSION['user_id'];
$riwayat = PengembalianModel::getByPrajurit($id_prajurit);
?>
<?php require_once '../../includes/header.php'; ?>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <!-- Tombol back ke dashboard prajurit -->
            <a href="../dashboard_prajurit.php" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-army/10 text-army hover:bg-army hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-army-dark flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Riwayat Pengembalian Saya
                </h1>
                <p class="text-gray-500 text-sm mt-1">Daftar barang yang pernah dikembalikan beserta status verifikasi</p>
            </div>
        </div>
        <a href="buat.php" class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-army hover:bg-army-dark text-white text-sm font-medium rounded-lg transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Pengembalian Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-army/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Jumlah Kembali</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Kondisi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Catatan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Tanggal Pengembalian</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Status Verifikasi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if($riwayat->num_rows > 0): ?>
                    <?php while($row = $riwayat->fetch_assoc()): ?>
                        <?php
                        $status = $row['status'];
                        $badgeClass = '';
                        if($status == 'diajukan') $badgeClass = 'bg-yellow-100 text-yellow-700';
                        else $badgeClass = 'bg-green-100 text-green-700';
                        
                        $kondisi = $row['kondisi'];
                        $kondisiClass = '';
                        if($kondisi == 'Baik') $kondisiClass = 'bg-green-100 text-green-700';
                        elseif($kondisi == 'Rusak') $kondisiClass = 'bg-red-100 text-red-700';
                        else $kondisiClass = 'bg-yellow-100 text-yellow-700';
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['jumlah_kembali'] ?> unit</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $kondisiClass ?>">
                                    <?= $kondisi ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate" title="<?= htmlspecialchars($row['catatan']) ?>">
                                <?= htmlspecialchars($row['catatan'] ?: '-') ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= date('d/m/Y H:i', strtotime($row['tanggal_kembali'])) ?>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badgeClass ?>">
                                    <?= $status == 'diajukan' ? 'Menunggu Verifikasi' : 'Diterima' ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Belum ada riwayat pengembalian. Silakan ajukan pengembalian jika ada barang yang sudah digunakan.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>