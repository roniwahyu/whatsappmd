<?= $this->extend('layouts/dashboard') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1>Pengaturan</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Ubah Password</h5>
            <form>
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Password Saat Ini</label>
                    <input type="password" class="form-control" id="currentPassword">
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">Password Baru</label>
                    <input type="password" class="form-control" id="newPassword">
                </div>
                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Konfirmasi Password Baru</label>
                    <input type="password" class="form-control" id="confirmPassword">
                </div>
                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Notifikasi</h5>
            <form>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                    <label class="form-check-label" for="emailNotifications">
                        Aktifkan Notifikasi Email
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="pushNotifications" checked>
                    <label class="form-check-label" for="pushNotifications">
                        Aktifkan Notifikasi Push
                    </label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Pengaturan</button>
            </form>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">Pengaturan Tema</h5>
            <form>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="theme" id="lightTheme" checked>
                    <label class="form-check-label" for="lightTheme">
                        Tema Terang
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="theme" id="darkTheme">
                    <label class="form-check-label" for="darkTheme">
                        Tema Gelap
                    </label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Simpan Tema</button>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>