<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/KategoriModel.php';

$kategori = KategoriModel::getAll();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-army to-army-dark px-6 py-4">
            <div class="flex items-center gap-3">
                <a href="index.php" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/20 text-white hover:bg-white/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Barang Baru
                    </h2>
                    <p class="text-green-100 text-sm mt-1">Lengkapi formulir di bawah ini</p>
                </div>
            </div>
        </div>

        <form method="POST" action="../../controllers/BarangController.php?action=create" class="p-6 space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Barang <span class="text-red-500">*</span></label>
                <input type="text" name="nama_barang" required autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition"
                       placeholder="Contoh: SS2 V5, Radio PRC-107">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Kategori <span class="text-red-500">*</span></label>
                <select name="id_kategori" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army">
                    <option value="">-- Pilih Kategori --</option>
                    <?php while($k = $kategori->fetch_assoc()): ?>
                        <option value="<?= $k['id'] ?>"><?= htmlspecialchars($k['nama_kategori']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Stok Awal</label>
                    <input type="number" name="stok" value="0" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Satuan</label>
                    <input type="text" name="satuan" value="pcs" class="w-full border border-gray-300 rounded-lg px-4 py-2.5" placeholder="pcs, unit, paket">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="index.php" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-army hover:bg-army-dark text-white rounded-lg shadow transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Barang
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>