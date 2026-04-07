<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/BarangModel.php'; 

// Ambil data barang
$barang = BarangModel::getAll();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="space-y-6">
    <!-- Header dengan tombol back dan tambah -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Manajemen Barang
                    </h1>
                    <p class="text-gray-500 text-sm mt-1">Kelola data persenjataan dan logistik</p>
                </div>
            </div>
            <a href="create.php" class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-army hover:bg-army-dark text-white text-sm font-medium rounded-lg transition shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Barang
            </a>
        </div>

        <!-- Tabel Barang -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-army/5">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">ID</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Nama Barang</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Satuan</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-army-dark uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    <?php if($barang->num_rows > 0): ?>
                        <?php while($row = $barang->fetch_assoc()): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700"><?= htmlspecialchars($row['nama_barang']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                <span class="inline-flex px-2 py-1 rounded-full text-xs font-medium bg-army/10 text-army"><?= htmlspecialchars($row['nama_kategori']) ?></span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold <?= $row['stok'] <= 5 ? 'text-red-600' : 'text-gray-700' ?>"><?= $row['stok'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?= $row['satuan'] ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-center space-x-2">
                                <a href="edit.php?id=<?= $row['id'] ?>" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-blue-700 bg-blue-100 hover:bg-blue-200 transition">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    Edit
                                </a>
                                <a href="../../controllers/BarangController.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Yakin hapus barang ini? Data yang terkait akan terpengaruh.')" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-red-700 bg-red-100 hover:bg-red-200 transition">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Hapus
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Belum ada data barang. Silakan tambah barang baru.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>