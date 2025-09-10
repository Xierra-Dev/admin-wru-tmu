<!-- app/Views/mloc/create.php -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="bi bi-plus-circle me-2"></i>Tambah M-Loc</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('mloc/add-to-temp') ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Personil *</label>
                                <select class="form-select" name="people_id" required>
                                    <option value="">Pilih Personil</option>
                                    <?php foreach ($people as $person): ?>
                                        <option value="<?= $person['id'] ?>" <?= old('people_id') == $person['id'] ? 'selected' : '' ?>>
                                            <?= $person['name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Destinasi *</label>
                                <select class="form-select" name="destination_id" required>
                                    <option value="">Pilih Destinasi</option>
                                    <?php foreach ($destinations as $destination): ?>
                                        <option value="<?= $destination['id'] ?>" <?= old('destination_id') == $destination['id'] ? 'selected' : '' ?>>
                                            <?= $destination['destination_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Request By *</label>
                        <input type="text" class="form-control" name="requestBy" value="<?= old('requestBy') ?>" placeholder="Contoh: Manager HRD" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pergi *</label>
                                <input type="datetime-local" class="form-control" name="leaveDate" value="<?= old('leaveDate') ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kembali *</label>
                                <input type="datetime-local" class="form-control" name="returnDate" value="<?= old('returnDate') ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-plus me-2"></i>Tambah ke Daftar
                        </button>
                        <a href="<?= base_url('mloc') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0"><i class="bi bi-list-check me-2"></i>Daftar Sementara</h6>
                <?php if (!empty($tmp_mlocs)): ?>
                    <a href="<?= base_url('mloc/clear-temp') ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin ingin membersihkan semua?')">
                        <i class="bi bi-trash"></i>
                    </a>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($tmp_mlocs)): ?>
                    <div class="text-center text-muted">
                        <i class="bi bi-list" style="font-size: 2rem;"></i>
                        <p class="mt-2 mb-0">Belum ada data</p>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($tmp_mlocs as $tmp): ?>
                            <div class="list-group-item px-0">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="flex-grow-1">
                                        <h6 class="mb-1"><?= $tmp['people_name'] ?></h6>
                                        <p class="mb-1 text-muted small"><?= $tmp['destination_name'] ?></p>
                                        <p class="mb-1 text-muted small">By: <?= $tmp['requestBy'] ?></p>
                                        <small class="text-muted">
                                            <?= date('d/m/Y H:i', strtotime($tmp['leaveDate'])) ?> - 
                                            <?= date('d/m/Y H:i', strtotime($tmp['returnDate'])) ?>
                                        </small>
                                    </div>
                                    <div class="btn-group-vertical">
                                        <a href="<?= base_url('mloc/edit-temp/' . $tmp['id']) ?>" class="btn btn-sm btn-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <a href="<?= base_url('mloc/delete-temp/' . $tmp['id']) ?>" class="btn btn-sm btn-danger mt-1" onclick="return confirm('Yakin ingin menghapus?')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="mt-3 d-grid">
                        <form action="<?= base_url('mloc/save-all') ?>" method="post">
                            <button type="submit" class="btn btn-primary" onclick="return confirm('Simpan semua data ke database?')">
                                <i class="bi bi-save me-2"></i>Simpan Semua
                            </button>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
