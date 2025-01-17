<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="text-center mb-4">Log into WhatsApp Web</h1>
    <div class="instructions mb-4">
        <p class="text-muted">Message privately with friends and family using WhatsApp on your browser.</p>
        <ol class="list-unstyled">
            <li><i class="fas fa-mobile-alt me-2"></i>1. Open WhatsApp on your phone</li>
            <li><i class="fas fa-cog me-2"></i>2. Tap <strong>Menu</strong> on Android, or <strong>Settings</strong> on iPhone</li>
            <li><i class="fas fa-link me-2"></i>3. Tap <strong>Linked devices</strong> and then <strong>Link a device</strong></li>
            <li><i class="fas fa-qrcode me-2"></i>4. Point your phone at this screen to scan the QR code</li>
        </ol>
    </div>
    <?php if ($qrCode): ?>
        <div class="qr-code text-center mb-4">
            <img src="<?= $qrCode ?>" alt="QR Code" class="img-fluid" style="width: 200px; height: 200px;">
        </div>
        <!-- Indikator Timer -->
        <div class="text-center mb-4">
            <p>QR code akan diperbarui dalam: <span id="timer">00:30</span></p>
        </div>
    <?php else: ?>
        <div class="alert alert-warning text-center">
            <i class="fas fa-exclamation-triangle me-2"></i>QR code tidak tersedia. Silakan coba lagi nanti.
        </div>
    <?php endif; ?>
    <div class="text-center">
        <a href="#" class="text-primary text-decoration-none">
            <i class="fas fa-question-circle me-2"></i>Need help getting started?
        </a>
    </div>
    <div class="footer text-center mt-4">
        <i class="fas fa-lock me-2"></i>Your personal messages are end-to-end encrypted
    </div>
</div>
<!-- JavaScript untuk Timer -->
<script>
    // Waktu awal (dalam detik)
    let timeLeft = 30;

    // Fungsi untuk mengupdate timer
    function updateTimer() {
        const timerElement = document.getElementById('timer');
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;

        // Format menit dan detik (00:00)
        timerElement.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;

        // Kurangi waktu
        timeLeft--;

        // Jika waktu habis, refresh halaman
        // if (timeLeft === 10) {
        //     alert("QR code akan segera diperbarui!");
        // }
        if (timeLeft < 0) {
            window.location.reload();
        }
        
    }

    // Jalankan timer setiap 1 detik
    setInterval(updateTimer, 1000);
</script>
<?= $this->endSection() ?>