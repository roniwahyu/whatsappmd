<?= $this->include('partials/header') ?>
<?= $this->include('partials/navbar') ?>

<div class="d-flex">
    <?= $this->include('partials/sidebar') ?>
    <main class="flex-grow-1 p-4" style="margin-left: 250px;">
        <?= $this->renderSection('content') ?>
    </main>
</div>

<?= $this->include('partials/footer') ?>