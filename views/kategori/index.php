<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/KategoriModel.php'; 
?>
<?php require_once '../../includes/header.php'; ?>

<div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center p-6 border-b border-gray-100 bg-gray-50/50">
        <div class="flex items-center gap-3">
            <!-- Tombol Back ke Dashboard -->
            <a href="../dashboard_petugas.php" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-army/10 text-army hover:bg-army hover:text-white transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-army-dark flex items-center gap-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path></svg>
                    Manajemen Kategori
                </h1>
                <p class="text-gray-500 text-sm mt-1">Kelompokkan barang sesuai jenisnya</p>
            </div>
        </div>
        <a href="create.php" class="mt-3 sm:mt-0 inline-flex items-center px-4 py-2 bg-army hover:bg-army-dark text-white text-sm font-medium rounded-lg transition shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Tambah Kategori
        </a>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-army/5">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-army-dark uppercase tracking-wider">Nama Kategori</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-army-dark uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                <?php 
                $kategori = KategoriModel::getAll();
                if($kategori->num_rows > 0):
                    while($row = $kategori->fetch_assoc()): 
                ?>
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900"><?= $row['id'] ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        <span class="inline-flex items-center gap-1.5">
                            <span class="w-2 h-2 bg-army-light rounded-full"></span>
                            <?= htmlspecialchars($row['nama_kategori']) ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm space-x-3">
                        <a href="edit.php?id=<?= $row['id'] ?>" class="text-blue-600 hover:text-blue-800 inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Edit
                        </a>
                        <a href="../../controllers/KategoriController.php?action=delete&id=<?= $row['id'] ?>" onclick="return confirm('Hapus kategori ini? Data barang dengan kategori ini tidak akan terhapus, tapi kategori akan dikosongkan.')" class="text-red-600 hover:text-red-800 inline-flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            Hapus
                        </a>
                    </td>
                </tr>
                <?php 
                    endwhile;
                else:
                ?>
                <tr>
                    <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Belum ada kategori. Silakan tambah kategori baru.
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>