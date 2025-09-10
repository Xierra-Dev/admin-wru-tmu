
<!-- app/Views/destinations/create.php -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="bi bi-geo-alt-fill me-2"></i>Tambah Destinasi</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('destinations/store') ?>" method="post">
                    <div class="mb-3">
                        <label class="form-label">Nama Destinasi *</label>
                        <input type="text" class="form-control" name="destination_name" value="<?= old('destination_name') ?>" placeholder="Contoh: Jakarta, Bandung, Surabaya" required>
                        <div class="form-text">Masukkan nama kota, daerah, atau lokasi tujuan</div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Simpan
                        </button>
                        <a href="<?= base_url('destinations') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
