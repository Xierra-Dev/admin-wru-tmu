<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<!-- app/Views/dashboard/index.php -->
<div class="hero-section">
    <img src="<?= base_url('img/artimu.png') ?>" alt="artimu Logo Large" class="artimu-large-img">
    <h1 class="text-4xl font-bold"><?= $greeting ?> </h1>
    <h2 class="text-2xl font-normal">Welcome to Dashboard Admin</h2>
</div>
<?= $this->endSection() ?>
