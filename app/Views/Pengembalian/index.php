<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="" method="get" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="keyword" class="form-control border-start-0 ps-0" placeholder="Cari nama siswa atau judul buku..." value="<?= request()->getGet('keyword') ?>">
                </div>
            </div>
            <div class="col-md-3">
                <input type="date" name="tanggal" class="form-control" value="<?= request()->getGet('tanggal') ?>">
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-filter me-1"></i> Filter
                </button>
            </div>
            <div class="col-md-1">
                <a href="<?= base_url('pengembalian') ?>" class="btn btn-light border w-100" title="Reset">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="fw-bold text-dark mb-1">Riwayat Pengembalian Buku</h4>
            <p class="text-muted small">Daftar buku yang telah dikembalikan oleh siswa secara resmi.</p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
    <thead class="bg-light">
        <tr>
            <th class="ps-4 py-3 text-uppercase text-muted small fw-bold" style="width: 5%">No</th>
            <th class="py-3 text-uppercase text-muted small fw-bold">Nama Siswa</th>
            <th class="py-3 text-uppercase text-muted small fw-bold">Judul Buku</th>
            <th class="py-3 text-uppercase text-muted small fw-bold text-center">Tgl Pinjam</th>
            <th class="py-3 text-uppercase text-muted small fw-bold text-center">Tgl Kembali</th>
            <th class="py-3 text-uppercase text-muted small fw-bold text-center">Denda</th>
            <th class="py-3 text-uppercase text-muted small fw-bold text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($pengembalian)) : ?>
            <tr>
                <td colspan="7" class="text-center py-5 text-muted">Belum ada data.</td>
            </tr>
        <?php else : ?>
            <?php $no = 1; foreach ($pengembalian as $p) : ?>
                <tr>
                    <td class="ps-4"><?= $no++; ?></td>
                    <td>
                        <div class="fw-bold text-dark"><?= $p['nama']; ?></div>
                        <small class="text-muted">ID: #<?= str_pad($p['id_user'], 4, '0', STR_PAD_LEFT); ?></small>
                    </td>
                    <td><?= $p['judul']; ?></td>
                    <td class="text-center small text-secondary">
                        <?= date('d M Y', strtotime($p['tanggal_pinjam'])); ?>
                    </td>
                    <td class="text-center small text-dark fw-medium">
                        <?= date('d M Y H:i', strtotime($p['tanggal_kembali'])); ?>
                    </td>
                    <td class="text-center">
                        <?php if ($p['denda'] > 0) : ?>
                            <span class="text-danger fw-bold">Rp <?= number_format($p['denda'], 0, ',', '.'); ?></span>
                        <?php else : ?>
                            <span class="text-muted small">-</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                            <i class="bi bi-check-all me-1"></i> Selesai
                        </span>
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