
<!-- app/Views/vehicles/create.php -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah Kendaraan</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle me-2"></i>
                    <strong>Contoh format:</strong> Daihatsu Xenia - D 1299 SAX
                </div>
                
                <form action="<?= base_url('vehicles/store') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nama Kendaraan *</label>
                                <input type="text" class="form-control" name="vehicle_name" value="<?= old('vehicle_name') ?>" placeholder="Contoh: Daihatsu Xenia" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nomor Plat *</label>
                                <input type="text" class="form-control" name="number_plate" value="<?= old('number_plate') ?>" placeholder="Contoh: D 1299 SAX" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Simpan
                        </button>
                        <a href="<?= base_url('vehicles') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
