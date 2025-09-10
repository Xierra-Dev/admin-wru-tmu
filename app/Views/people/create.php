
<!-- app/Views/people/create.php -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="bi bi-person-plus me-2"></i>Tambah Personil</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('people/store') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Personil *</label>
                        <input type="text" class="form-control" name="name" value="<?= old('name') ?>" placeholder="Masukkan nama lengkap" required>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Simpan
                        </button>
                        <a href="<?= base_url('people') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
