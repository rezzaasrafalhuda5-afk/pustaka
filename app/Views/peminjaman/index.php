<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold text-dark mb-0">Daftar Peminjaman</h4>
        <a href="<?= base_url('peminjaman/tambah') ?>" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Peminjaman
        </a>
        
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success border-0 shadow-sm"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">No</th>
                            <th>Nama Siswa</th>
                            <th>Judul Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($peminjaman)) : ?>
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                            </tr>
                        <?php else : ?>
                            <?php $no = 1; foreach ($peminjaman as $p) : ?>
                                <tr>
                                    <td class="ps-4"><?= $no++; ?></td>
                                    <td class="fw-bold"><?= $p['nama']; ?></td>
                                    <td><?= $p['judul']; ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($p['tanggal_pinjam'])); ?></td>
                                    <td>
                                        <span class="badge <?= $p['status'] == 'dipinjam' ? 'bg-warning text-dark' : 'bg-success' ?>">
                                            <?= ucfirst($p['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('peminjaman/proses_kembali/'.$p['id_pinjam']) ?>" 
   class="btn btn-sm btn-outline-success" 
   onclick="return confirm('Yakin buku ini sudah dikembalikan?')">
   Kembalikan
</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>