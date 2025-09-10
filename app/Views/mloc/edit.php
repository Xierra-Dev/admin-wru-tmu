
<!-- app/Views/mloc/edit_temp.php -->
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="fw-bold mb-0"><i class="bi bi-pencil me-2"></i>Edit Data Sementara</h5>
            </div>
            <div class="card-body">
                <form action="<?= base_url('mloc/update-temp/' . $tmpMloc['id']) ?>" method="post">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Personil *</label>
                                <select class="form-select" name="people_id" required>
                                    <option value="">Pilih Personil</option>
                                    <?php foreach ($people as $person): ?>
                                        <option value="<?= $person['id'] ?>" <?= $tmpMloc['people_id'] == $person['id'] ? 'selected' : '' ?>>
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
                                        <option value="<?= $destination['id'] ?>" <?= $tmpMloc['destination_id'] == $destination['id'] ? 'selected' : '' ?>>
                                            <?= $destination['destination_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Request By *</label>
                        <input type="text" class="form-control" name="requestBy" value="<?= $tmpMloc['request_by'] ?>" required>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Pergi *</label>
                                <?php
                                // Convert datetime safely - extract date and time parts separately
                                if (!empty($tmpMloc['leave_date'])) {
                                    // Parse the datetime string and format for datetime-local input
                                    $dt = new DateTime($tmpMloc['leave_date']);
                                    $leaveDateTime = $dt->format('Y-m-d\TH:i');
                                } else {
                                    $leaveDateTime = '';
                                }
                                ?>
                                <input type="datetime-local" class="form-control" name="leaveDate" value="<?= $leaveDateTime ?>" required>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Tanggal Kembali *</label>
                                <?php
                                // Convert datetime safely - extract date and time parts separately
                                if (!empty($tmpMloc['return_date'])) {
                                    // Parse the datetime string and format for datetime-local input
                                    $dt = new DateTime($tmpMloc['return_date']);
                                    $returnDateTime = $dt->format('Y-m-d\TH:i');
                                } else {
                                    $returnDateTime = '';
                                }
                                ?>
                                <input type="datetime-local" class="form-control" name="returnDate" value="<?= $returnDateTime ?>" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Update
                        </button>
                        <a href="<?= base_url('mloc/create') ?>" class="btn btn-secondary">
                            <i class="bi bi-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>