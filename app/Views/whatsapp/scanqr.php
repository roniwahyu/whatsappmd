<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
    <h1>Scan QR Code untuk Menghubungkan WhatsApp</h1>
    <img src="<?= $qrUrl ?>" alt="QR Code">
    <p>Buka WhatsApp di ponsel Anda, lalu scan QR Code di atas.</p>
<?= $this->endSection() ?>