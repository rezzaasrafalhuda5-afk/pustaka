<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0">Katalog Buku</h2>
            <p class="text-muted">Temukan referensi bacaan untuk mendukung belajarmu.</p>
        </div>
        <div class="d-flex gap-2">
            <div class="input-group" style="width: 300px;">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control border-start-0" placeholder="Cari buku favoritmu...">
            </div>
            <?php if (session()->get('role') == 'admin') : ?>
                <a href="<?= base_url('buku/tambah') ?>" class="btn btn-primary px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i> Tambah Buku
                </a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success'); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
        <?php foreach ($buku as $b) : ?>
            <div class="col">
                <div class="card h-100 border-0 shadow-sm hover-top transition">
                    <div class="position-relative p-3">
                        <span class="badge bg-info position-absolute top-0 start-0 mt-4 ms-4 shadow-sm"><?= $b['kategori']; ?></span>
                        <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 250px;">
                            <i class="bi bi-book text-secondary display-1"></i>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <h6 class="fw-bold mb-1 text-truncate"><?= $b['judul']; ?></h6>
                        <p class="text-muted small mb-3"><?= $b['penulis'] ?? 'Penulis Anonim'; ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div class="text-warning small">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="text-muted ms-1">(4.8)</span>
                            </div>
                            <span class="badge bg-light text-success border border-success border-opacity-25">Stok: <?= $b['stok']; ?></span>
                        </div>

                        <div class="d-grid gap-2">
                            <?php if (session()->get('role') == 'admin') : ?>
                                <div class="d-flex gap-1">
                                    <a href="<?= base_url('buku/edit/' . $b['id_buku']) ?>" class="btn btn-sm btn-outline-warning flex-grow-1">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                    <a href="<?= base_url('buku/hapus/' . $b['id_buku']) ?>" 
                                       class="btn btn-sm btn-outline-danger flex-grow-1"
                                       onclick="return confirm('Yakin ingin menghapus buku ini?')">
                                        <i class="bi bi-trash"></i> Hapus
                                    </a>
                                </div>
                            <?php else : ?>
                                <?php 
                                    $db = \Config\Database::connect();
                                    $isPending = $db->table('peminjaman')
                                        ->where('id_buku', $b['id_buku'])
                                        ->where('id_user', session()->get('id_user'))
                                        ->where('status', 'pending')
                                        ->get()->getRow();
                                ?>

                                <?php if ($isPending) : ?>
                                    <button class="btn btn-sm btn-warning disabled">
                                        <i class="bi bi-clock-history me-1"></i> Menunggu Konfirmasi
                                    </button>
                                <?php elseif ($b['stok'] <= 0) : ?>
                                    <button class="btn btn-sm btn-secondary disabled">
                                        <i class="bi bi-x-circle me-1"></i> Stok Habis
                                    </button>
                                <?php else : ?>
                                    <a href="<?= base_url('buku/ajukan/' . $b['id_buku']) ?>" 
                                       class="btn btn-sm btn-primary"
                                       onclick="return confirm('Ajukan peminjaman buku ini?')">
                                        <i class="bi bi-journal-plus me-1"></i> Pinjam Sekarang
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<style>
    .hover-top {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-top:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }
    .btn-primary {
        background-color: #1a73e8;
        border-color: #1a73e8;
    }
</style>
<?= $this->endSection() ?>