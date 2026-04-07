<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPrajurit()) die("Akses ditolak"); 

// Ambil daftar barang yang tersedia (stok > 0)
$barang_tersedia = $conn->query("SELECT id, nama_barang, stok, satuan FROM barang WHERE stok > 0 ORDER BY nama_barang ASC");
?>
<?php require_once '../../includes/header.php'; ?>

<div class="max-w-3xl mx-auto">
    <!-- Pesan sukses/error -->
    <?php if(isset($_GET['success'])): ?>
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Pengajuan berhasil dikirim! Menunggu persetujuan petugas.</span>
            </div>
        </div>
    <?php elseif(isset($_GET['error']) && $_GET['error'] == 'stok'): ?>
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Stok tidak mencukupi! Silakan pilih jumlah yang lebih kecil.</span>
            </div>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="bg-gradient-to-r from-army to-army-dark px-6 py-4">
            <div class="flex items-center gap-3">
                <a href="../dashboard_prajurit.php" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/20 text-white hover:bg-white/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Form Pengajuan Barang
                    </h2>
                    <p class="text-green-100 text-sm mt-1">Isi permintaan barang yang diperlukan untuk operasional</p>
                </div>
            </div>
        </div>

        <form method="POST" action="../../controllers/PengajuanController.php?action=buat" class="p-6 space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Pilih Barang <span class="text-red-500">*</span></label>
                <select name="id_barang" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition">
                    <option value="">-- Pilih Barang --</option>
                    <?php if($barang_tersedia->num_rows > 0): ?>
                        <?php while($b = $barang_tersedia->fetch_assoc()): ?>
                            <option value="<?= $b['id'] ?>"><?= htmlspecialchars($b['nama_barang']) ?> (Stok: <?= $b['stok'] ?> <?= $b['satuan'] ?>)</option>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <option value="" disabled>Tidak ada barang tersedia saat ini</option>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-medium mb-2">Jumlah <span class="text-red-500">*</span></label>
                <input type="number" name="jumlah" min="1" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition" placeholder="Masukkan jumlah">
                <p class="text-gray-400 text-xs mt-1">Pastikan jumlah tidak melebihi stok yang tersedia.</p>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <a href="../dashboard_prajurit.php" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-army hover:bg-army-dark text-white rounded-lg shadow transition flex items-center gap-2" <?= ($barang_tersedia->num_rows == 0) ? 'disabled' : '' ?>>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Ajukan Permintaan
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>