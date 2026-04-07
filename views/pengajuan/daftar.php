<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPrajurit()) die("Akses ditolak"); 
require_once '../../models/PengajuanModel.php';

$id_prajurit = $_SESSION['user_id'];
$riwayat = PengajuanModel::getByPrajurit($id_prajurit);
?>
<?php require_once '../../includes/header.php'; ?>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="flex items-center gap-3">
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
                    Riwayat Pengajuan Saya
                </h1>
                <p class="text-gray-500 text-sm mt-1">Status permintaan barang yang telah diajukan</p>
            </div>
        </div>
        <a href="buat.php" class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-army hover:bg-army-dark text-white text-sm font-medium rounded-lg transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Pengajuan Baru
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-army/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Barang</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Jumlah</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Tanggal Pengajuan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Tanggal Disetujui</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php if($riwayat->num_rows > 0): ?>
                    <?php while($row = $riwayat->fetch_assoc()): ?>
                        <?php
                        $status = $row['status'];
                        $badgeClass = '';
                        if($status == 'menunggu') $badgeClass = 'bg-yellow-100 text-yellow-700';
                        elseif($status == 'disetujui') $badgeClass = 'bg-green-100 text-green-700';
                        else $badgeClass = 'bg-red-100 text-red-700';
                        ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['nama_barang']) ?> (<span class="text-xs text-gray-400"><?= $row['satuan'] ?></span>)</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= $row['jumlah'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= date('d/m/Y H:i', strtotime($row['tanggal_pengajuan'])) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $badgeClass ?>">
                                    <?= $status == 'menunggu' ? 'Menunggu' : ($status == 'disetujui' ? 'Disetujui' : 'Ditolak') ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <?= $row['tanggal_disetujui'] ? date('d/m/Y H:i', strtotime($row['tanggal_disetujui'])) : '-' ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                            <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Belum ada pengajuan. Silakan buat pengajuan baru.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>