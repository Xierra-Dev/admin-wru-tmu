<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Data V-Trip Sementara</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('vtrip/updateTemp/' . $tmpVtrip->id) ?>" method="post">
                <?= csrf_field(); ?>
                <input type="hidden" name="_method" value="PUT">
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Kendaraan</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                        <option value="">Pilih Kendaraan</option>
                        <?php foreach ($vehicles as $vehicle) : ?>
                            <option value="<?= $vehicle->id; ?>" <?= (old('vehicle_id', $tmpVtrip->vehicle_id) == $vehicle->id) ? 'selected' : ''; ?>>
                                <?= $vehicle->license_plate . ' (' . $vehicle->brand . ' ' . $vehicle->model . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="people_id" class="form-label">Personil</label>
                    <select class="form-control" id="people_id" name="people_id" required>
                        <option value="">Pilih Personil</option>
                        <?php foreach ($people as $person) : ?>
                            <option value="<?= $person->id; ?>" <?= (old('people_id', $tmpVtrip->people_id) == $person->id) ? 'selected' : ''; ?>>
                                <?= $person->name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="destination_id" class="form-label">Destinasi</label>
                    <select class="form-control" id="destination_id" name="destination_id" required>
                        <option value="">Pilih Destinasi</option>
                        <?php foreach ($destinations as $destination) : ?>
                            <option value="<?= $destination->id; ?>" <?= (old('destination_id', $tmpVtrip->destination_id) == $destination->id) ? 'selected' : ''; ?>>
                                <?= $destination->destination_name; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="leave_date" class="form-label">Tanggal & Waktu Pergi</label>
                    <input type="datetime-local" class="form-control" id="leave_date" name="leave_date" value="<?= old('leave_date', date('Y-m-d\TH:i', strtotime($tmpVtrip->leave_date))); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="return_date" class="form-label">Tanggal & Waktu Kembali</label>
                    <input type="datetime-local" class="form-control" id="return_date" name="return_date" value="<?= old('return_date', date('Y-m-d\TH:i', strtotime($tmpVtrip->return_date))); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Data Sementara</button>
                <a href="<?= base_url('vtrip/create') ?>" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>