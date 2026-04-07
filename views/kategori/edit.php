<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPetugas()) die("Akses ditolak"); 
require_once '../../models/KategoriModel.php';

$id = $_GET['id'];
$kategori = KategoriModel::getById($id);
if(!$kategori) {
    header("Location: index.php?error=notfound");
    exit;
}
?>
<?php require_once '../../includes/header.php'; ?>

<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-xl shadow-md overflow-hidden">
        <div class="bg-gradient-to-r from-amber-700 to-amber-800 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Edit Kategori
            </h2>
            <p class="text-amber-100 text-sm mt-1">Ubah nama kategori yang sudah ada</p>
        </div>
        <form method="POST" action="../../controllers/KategoriController.php?action=update&id=<?= $id ?>" class="p-6 space-y-5">
            <div>
                <label class="block text-gray-700 font-medium mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="nama_kategori" value="<?= htmlspecialchars($kategori['nama_kategori']) ?>" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition">
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="index.php" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit" class="px-5 py-2.5 bg-blue-700 hover:bg-blue-800 text-white rounded-lg shadow transition flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Update Kategori
                </button>
            </div>
        </form>
    </div>
</div>

<?php require_once '../../includes/footer.php'; ?>