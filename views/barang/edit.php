<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/BarangModel.php';
require_once '../../models/KategoriModel.php';

$id = $_GET['id'];
$barang = BarangModel::getById($id);
if(!$barang) {
    header("Location: index.php?error=notfound");
    exit;
}
$kategori = KategoriModel::getAll();
?>
<?php require_once '../../includes/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-amber-700 to-amber-800 px-6 py-4">
            <div class="flex items-center gap-3">
                <a href="index.php" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-white/20 text-white hover:bg-white/30 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Barang
                    </h2>
                    <p class="text-amber-100 text-sm mt-1">Ubah data barang yang sudah ada</p>
                </div>
            </div>
        </div>

        <form method="POST" action="../../controllers/BarangController.php?action=update&id=<?= $id ?>" class="p-6 space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Barang</label>
                <input type="text" name="nama_barang" value="<?= htmlspecialchars($barang['nama_barang']) ?>" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army">
            </div>
            <div>
                <label class="block text-gray-700 font-medium mb-2">Kategori</label>
                <select name="id_kategori" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                    <?php while($k = $kategori->fetch_assoc()): ?>
                        <option value="<?= $k['id'] ?>" <?= $k['id'] == $barang['id_kategori'] ? 'selected' : '' ?>><?= htmlspecialchars($k['nama_kategori']) ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Stok</label>
                    <input type="number" name="stok" value="<?= $barang['stok'] ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
                <div>
                    <label>Satuan</label>
                    <input type="text" name="satuan" value="<?= htmlspecialchars($barang['satuan']) ?>" class="w-full border border-gray-300 rounded-lg px-4 py-2.5">
                </div>
            </div>
            <div class="flex justify-end gap-3 pt-4">
                <a href="index.php" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg shadow transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Update Barang
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>