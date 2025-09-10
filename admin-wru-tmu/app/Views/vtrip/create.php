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
            <h6 class="m-0 font-weight-bold text-primary">Form Tambah V-Trip</h6>
        </div>
        <div class="card-body">
            <form action="<?= base_url('vtrip/addToTemp') ?>" method="post">
                <?= csrf_field(); ?>
                <div class="mb-3">
                    <label for="vehicle_id" class="form-label">Kendaraan</label>
                    <select class="form-control" id="vehicle_id" name="vehicle_id" required>
                        <option value="">Pilih Kendaraan</option>
                        <?php foreach ($vehicles as $vehicle) : ?>
                            <option value="<?= $vehicle['id']; ?>" <?= (old('vehicle_id') == $vehicle['id']) ? 'selected' : ''; ?>>
                                <?= $vehicle['number_plate'] . ' (' . $vehicle['vehicle_name']  . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="people_id" class="form-label">Personil</label>
                    <select class="form-control" id="people_id" name="people_id" required>
                        <option value="">Pilih Personil</option>
                        <?php foreach ($people as $person) : ?>
                            <option value="<?= $person['id']; ?>" <?= (old('people_id') == $person['id']) ? 'selected' : ''; ?>>
                                <?= $person['name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="destination_id" class="form-label">Destinasi</label>
                    <select class="form-control" id="destination_id" name="destination_id" required>
                        <option value="">Pilih Destinasi</option>
                        <?php foreach ($destinations as $destination) : ?>
                            <option value="<?= $destination['id']; ?>" <?= (old('destination_id') == $destination['id']) ? 'selected' : ''; ?>>
                                <?= $destination['destination_name']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="leave_date" class="form-label">Tanggal & Waktu Pergi</label>
                    <input type="datetime-local" class="form-control" id="leave_date" name="leave_date" value="<?= old('leave_date'); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="return_date" class="form-label">Tanggal & Waktu Kembali</label>
                    <input type="datetime-local" class="form-control" id="return_date" name="return_date" value="<?= old('return_date'); ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Tambah ke Draft</button>
            </form>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar V-Trip Sementara</h6>
            <div>
                <form action="<?= base_url('vtrip/saveAll') ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Apakah Anda yakin ingin menyimpan semua data ini ke tabel utama?')">Simpan Semua</button>
                </form>
                <form action="<?= base_url('vtrip/clearTemp') ?>" method="post" class="d-inline">
                    <?= csrf_field(); ?>
                    <button type="submit" class="btn btn-warning btn-sm ms-2" onclick="return confirm('Apakah Anda yakin ingin membersihkan semua data sementara?')">Bersihkan Draft</button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($tmp_vtrips)) : ?>
                <p class="text-center">Tidak ada data V-Trip sementara.</p>
            <?php else : ?>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kendaraan</th>
                                <th>Personil</th>
                                <th>Destinasi</th>
                                <th>Waktu Pergi</th>
                                <th>Waktu Kembali</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($tmp_vtrips as $tmp) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $tmp['number_plate'] . ' (' . $tmp['vehicle_name'] . ')'; ?></td>
                                    <td><?= $tmp['people_name']; ?></td>
                                    <td><?= $tmp['destination_name']; ?></td>
                                    <td><?= date('d M Y H:i', strtotime($tmp['leave_date'])); ?></td>
                                    <td><?= date('d M Y H:i', strtotime($tmp['return_date'])); ?></td>
                                    <td>
                                        <a href="<?= base_url('vtrip/editTemp/' . $tmp['id']) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="<?= base_url('vtrip/deleteTemp/' . $tmp['id']) ?>" method="post" class="d-inline">
                                            <?= csrf_field(); ?>
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
