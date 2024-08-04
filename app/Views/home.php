<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <h3 class="my-3">Data Dashboard</h3>
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Arsip</h4>
                    <p class="card-text"><?=$surat?></p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Peminjaman</h4>
                    <p class="card-text"><?=$pinjam?></p>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Total Member</h4>
                    <p class="card-text"><?=$member?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>