<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log into WhatsApp Web</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .footer {
            font-size: 12px;
            color: #999;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Log into WhatsApp Web</h1>
        <div class="instructions mb-4">
            <p class="text-muted">Message privately with friends and family using WhatsApp on your browser.</p>
            <ol class="list-unstyled">
                <li>1. Open WhatsApp on your phone</li>
                <li>2. Tap <strong>Menu</strong> on Android, or <strong>Settings</strong> on iPhone</li>
                <li>3. Tap <strong>Linked devices</strong> and then <strong>Link a device</strong></li>
                <li>4. Point your phone at this screen to scan the QR code</li>
            </ol>
        </div>
        <?php if ($qrCode): ?>
            <div class="qr-code text-center mb-4">
                <img src="<?= $qrCode ?>" alt="QR Code" class="img-fluid" style="width: 200px; height: 200px;">
            </div>
        <?php else: ?>
            <div class="alert alert-warning text-center">
                QR code tidak tersedia. Silakan coba lagi nanti.
            </div>
        <?php endif; ?>
        <div class="text-center">
            <a href="#" class="text-primary text-decoration-none">Need help getting started?</a>
        </div>
        <div class="footer text-center mt-4">
            Your personal messages are end-to-end encrypted
        </div>
    </div>

    <!-- Bootstrap 5 JS (Optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>