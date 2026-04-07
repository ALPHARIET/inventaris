<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
?>
<?php require_once '../../includes/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-army to-army-dark px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kategori Baru
            </h2>
            <p class="text-green-100 text-sm mt-1">Isi nama kategori untuk mengelompokkan barang</p>
        </div>
        <form method="POST" action="../../controllers/KategoriController.php?action=create" class="p-6 space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kategori" required autofocus
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition"
                       placeholder="Contoh: Senjata, Alat Komunikasi, Logistik Makanan">
                <p class="text-gray-400 text-xs mt-1">Nama kategori harus unik dan mudah dikenali.</p>
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="index.php" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-army hover:bg-army-dark text-white rounded-lg shadow transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Simpan Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>