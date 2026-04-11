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
            <a href="<?= base_url('buku/tambah') ?>" class="btn btn-primary px-4 shadow-sm">
    <i class="bi bi-plus-lg me-2"></i> Tambah Buku
</a>
        </div>
    </div>

    <div class="d-flex gap-2 mb-4 overflow-auto pb-2">
    <a href="<?= base_url('buku') ?>" 
       class="btn <?= !request()->getGet('kategori') ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-4">Semua</a>
    
    <a href="<?= base_url('buku?kategori=Sains') ?>" 
       class="btn <?= request()->getGet('kategori') == 'Sains' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-4">Sains</a>
    
    <a href="<?= base_url('buku?kategori=Matematika') ?>" 
       class="btn <?= request()->getGet('kategori') == 'Matematika' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-4">Matematika</a>
    
    <a href="<?= base_url('buku?kategori=Sejarah') ?>" 
       class="btn <?= request()->getGet('kategori') == 'Sejarah' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-4">Sejarah</a>
    
    <a href="<?= base_url('buku?kategori=Sastra') ?>" 
       class="btn <?= request()->getGet('kategori') == 'Sastra' ? 'btn-primary' : 'btn-outline-secondary' ?> rounded-pill px-4">Sastra</a>
</div>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 row-cols-xl-5 g-4">
        <div class="col">
            <div class="card h-100 border-0 shadow-sm hover-top transition">
                <div class="position-relative p-3">
                    <span class="badge bg-info position-absolute top-0 start-0 mt-4 ms-4 shadow-sm">Sains</span>
                    <div class="bg-light rounded-3 d-flex align-items-center justify-content-center" style="height: 250px;">
                        <i class="bi bi-book text-secondary display-1"></i>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <h6 class="fw-bold mb-1 text-truncate">The Psychology of Money</h6>
                    <p class="text-muted small mb-3">Morgan Housel</p>
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="text-warning small">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-half"></i>
                            <span class="text-muted ms-1">(4.8)</span>
                        </div>
                        <span class="badge bg-light text-success border border-success border-opacity-25">Stok: 5</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-sm btn-primary">
                            <i class="bi bi-journal-plus me-1"></i> Pinjam Sekarang
                        </button>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-outline-warning flex-grow-1"><i class="bi bi-pencil-square"></i></button>
                            <button class="btn btn-sm btn-outline-danger flex-grow-1"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
</div>

<style>
    /* Tambahan CSS untuk efek halus */
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