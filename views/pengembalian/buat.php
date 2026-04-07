<?php 
require_once '../../config/database.php';
require_once '../../includes/auth.php'; 
if(!isPrajurit()) die("Akses ditolak"); 

// Ambil daftar pengajuan yang sudah disetujui oleh petugas dan belum pernah dikembalikan (atau boleh lebih dari sekali, tapi sederhananya kita batasi)
// Query ini mengambil pengajuan yang statusnya 'disetujui' dan belum ada entri di pengembalian (atau bisa juga dengan left join)
$id_prajurit = $_SESSION['user_id'];
$pengajuan_tersedia = $conn->query("
    SELECT p.id, b.nama_barang, p.jumlah, b.satuan 
    FROM pengajuan p 
    JOIN barang b ON p.id_barang = b.id 
    WHERE p.id_prajurit = $id_prajurit 
    AND p.status = 'disetujui'
    AND p.id NOT IN (SELECT id_pengajuan FROM pengembalian WHERE id_prajurit = $id_prajurit)
");
?>
<?php require_once '../../includes/header.php'; ?>

<div class="max-w-3xl mx-auto">
    <!-- Pesan sukses/error -->
    <?php if(isset($_GET['success'])): ?>
        <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Pengembalian berhasil diajukan! Menunggu verifikasi petugas.</span>
            </div>
        </div>
    <?php elseif(isset($_GET['error']) && $_GET['error'] == 'jumlah'): ?>
        <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>Jumlah kembali tidak boleh melebihi jumlah yang diajukan!</span>
            </div>
        </div>
    <?php elseif(isset($_GET['error']) && $_GET['error'] == 'empty'): ?>
        <div class="mb-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded shadow-sm">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <span>Tidak ada pengajuan yang tersedia untuk dikembalikan.</span>
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
                        Form Pengembalian Barang
                    </h2>
                    <p class="text-green-100 text-sm mt-1">Ajukan pengembalian barang setelah selesai digunakan</p>
                </div>
            </div>
        </div>

        <?php if($pengajuan_tersedia->num_rows > 0): ?>
            <form method="POST" action="../../controllers/PengembalianController.php?action=buat" class="p-6 space-y-5">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Pilih Pengajuan yang Disetujui <span class="text-red-500">*</span></label>
                    <select name="id_pengajuan" id="id_pengajuan" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition">
                        <option value="">-- Pilih Pengajuan --</option>
                        <?php while($row = $pengajuan_tersedia->fetch_assoc()): ?>
                            <option value="<?= $row['id'] ?>" data-jumlah="<?= $row['jumlah'] ?>">
                                <?= htmlspecialchars($row['nama_barang']) ?> (Diajukan: <?= $row['jumlah'] ?> <?= $row['satuan'] ?>)
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Jumlah Dikembalikan <span class="text-red-500">*</span></label>
                    <input type="number" name="jumlah_kembali" id="jumlah_kembali" min="1" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition" placeholder="Masukkan jumlah">
                    <p class="text-gray-400 text-xs mt-1">Maksimal jumlah yang diajukan.</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Kondisi Barang <span class="text-red-500">*</span></label>
                    <select name="kondisi" required class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition">
                        <option value="Baik">Baik - Barang dalam kondisi normal</option>
                        <option value="Rusak">Rusak - Barang mengalami kerusakan</option>
                        <option value="Hilang">Hilang - Barang tidak dapat dikembalikan</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Catatan (Opsional)</label>
                    <textarea name="catatan" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-army focus:border-army transition" placeholder="Misal: Kerusakan ringan pada gagang senjata..."></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="../dashboard_prajurit.php" class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                    <button type="submit" class="px-5 py-2.5 bg-army hover:bg-army-dark text-white rounded-lg shadow transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Ajukan Pengembalian
                    </button>
                </div>
            </form>
        <?php else: ?>
            <div class="p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <p class="text-gray-500">Tidak ada pengajuan yang tersedia untuk dikembalikan.</p>
                <p class="text-gray-400 text-sm mt-1">Pastikan Anda memiliki pengajuan yang sudah disetujui dan belum dikembalikan.</p>
                <a href="riwayat.php" class="inline-block mt-4 px-4 py-2 bg-army/10 text-army rounded-lg hover:bg-army/20 transition">Lihat Riwayat Pengembalian</a>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Validasi jumlah kembali tidak melebihi jumlah yang diajukan
    const selectPengajuan = document.getElementById('id_pengajuan');
    const inputJumlah = document.getElementById('jumlah_kembali');

    if(selectPengajuan) {
        selectPengajuan.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const maxJumlah = selectedOption.getAttribute('data-jumlah');
            if(maxJumlah) {
                inputJumlah.setAttribute('max', maxJumlah);
                inputJumlah.placeholder = `Maksimal ${maxJumlah}`;
            }
        });
        // Trigger change untuk set awal
        selectPengajuan.dispatchEvent(new Event('change'));
    }

    inputJumlah.addEventListener('input', function() {
        const max = parseInt(this.getAttribute('max'));
        if(max && parseInt(this.value) > max) {
            this.setCustomValidity('Jumlah tidak boleh melebihi jumlah yang diajukan');
        } else {
            this.setCustomValidity('');
        }
    });
</script>

<?php require_once '../../includes/footer.php'; ?>