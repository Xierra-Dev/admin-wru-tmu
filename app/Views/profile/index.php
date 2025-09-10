<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h3 class="mb-4">Profil Admin</h3>
<form action="/profile/update" method="post" class="mb-4">
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Employee ID</label>
      <input type="text" name="employee_id" class="form-control" value="<?= esc($admin['employee_id'] ?? '') ?>" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?= esc($admin['email'] ?? '') ?>" required>
    </div>
  </div>
  <button class="btn btn-primary">Simpan</button>
</form>

<h4 class="mb-3">Ganti Password</h4>
<form action="/profile/password" method="post">
  <div class="row">
    <div class="col-md-6 mb-3">
      <label class="form-label">Password Lama</label>
      <input type="password" name="old_password" class="form-control" required>
    </div>
    <div class="col-md-6 mb-3">
      <label class="form-label">Password Baru</label>
      <input type="password" name="new_password" class="form-control" required>
    </div>
  </div>
  <button class="btn btn-warning">Ganti Password</button>
</form>
<?= $this->endSection() ?>