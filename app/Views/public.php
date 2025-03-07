<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="my-4">Tabel Akun Public</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Wilayah</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($publics as $key => $data) { ?>
                        <tr>
                            <td><?= $key+1?></td>
                            <td><?= $data->name?></td>
                            <td><?= $data->email?></td>
                            <td><?= $data->phone?></td>
                            <td><?= $data->area?></td>
                            <td><a class="btn btn-danger" href="<?=base_url('home/public/delete/'.$data->id)?>">Hapus</a></td>
                        </tr>
                    <?php } ?>
                    <tr>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</div>

<?= $this->endSection() ?>