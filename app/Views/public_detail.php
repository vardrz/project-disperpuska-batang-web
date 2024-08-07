<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row mb-5">
        <div class="col-12">
            <h1 class="my-4">Detail Akun Public</h1>
            <table class="table table-bordered">
                <tr>
                    <th>Nama</th>
                    <td><?= $public->name ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?= $public->email ?></td>
                </tr>
                <tr>
                    <th>No HP</th>
                    <td><?= $public->phone ?></td>
                </tr>
                <tr>
                    <th>Wilayah</th>
                    <td><?= $public->area ?></td>
                </tr>
                <tr>
                    <th>KTP</th>
                    <td class="text-center">
                        <img class="img-fluid" src="<?= base_url('uploads/' . $public->ktp); ?>" alt="KTP Image" style="max-height: 20rem;" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><a class="btn btn-primary" href="<?= base_url('home/public') ?>">Kembali</a></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>