<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<h3>Preview Draft Agenda</h3>
<p class="text-muted">Cek kembali sebelum disimpan final. Anda dapat edit/hapus item.</p>
<div class="table-responsive">
<table class="table table-bordered">
  <thead>
    <tr>
      <th>#</th>
      <th>Personil ID</th>
      <th>Periode</th>
      <th>Diminta Oleh</th>
      <th>Destinasi ID</th>
      <th>Surat</th>
      <th>Status</th>
      <th>Aksi</th>
    </tr>
  </thead>
  <tbody>
  <?php foreach($rows as $i=>$row): ?>
    <tr>
      <td><?= $i+1 ?></td>
      <td><?= esc($row['personil_id']) ?></td>
      <td><?= esc($row['start_date']) ?> s/d <?= esc($row['end_date']) ?></td>
      <td><?= esc($row['requested_by']) ?></td>
      <td><?= esc($row['destination_id']) ?></td>
      <td><?php if($row['surat_kerja']): ?><a href="/<?= $row['surat_kerja'] ?>" target="_blank">Lihat</a><?php endif; ?></td>
      <td><span class="badge bg-secondary"><?= esc($row['status']) ?></span></td>
      <td>
        <form method="post" action="/mloc/finalize/<?= $row['id'] ?>" class="d-inline">
          <button class="btn btn-sm btn-success" onclick="return confirm('Finalisasikan agenda ini?')">Save Final</button>
        </form>
        <a href="/mloc/edit/<?= $row['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
        <a href="/mloc/delete/<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus draft ini?')">Hapus</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
</div>
<a href="/mloc" class="btn btn-secondary">Kembali</a>
<?= $this->endSection() ?>