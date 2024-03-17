<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="row m-4">

    <div class="col-8">
        <h1 class="my-3">Tabel Peminjam</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Peminjam</th>
                        <th>Kebutuhan</th>
                        <th>Catatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Nama Peminjam</th>
                        <th>Kebutuhan</th>
                        <th>Catatan</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($pinjam as $key => $value) { ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value->created_at ?></td>
                            <td><?= $value->public_name ?></td>
                            <td><?= $value->needs ?></td>
                            <td><?= $value->notes ?></td>
                            <td>-</td>
                        </tr>
                    <?php } ?>
                    <tr>
                    </tr>
                </tbody>
            </table>

    </div>
    <div class="col-4">
        <form class="form" method="POST" action="<?= base_url('home/surat/save') ?>">
            <h3>Edit Data Surat</h3>
            <input type="hidden" name="id" value="<?= $data->id ?>" />
            <div class="form-outline mt-4">
                <label class="form-label" for="archives_number" name="archives_number">Nomor Arsip</label>
                <input type="text" id="archives_number" class="form-control" name="archives_number" value="<?= $data->archives_number ?>" />
            </div>

            <div class="form-outline mt-2">
                <label class="form-label" for="institute" name="institute">Institusi</label>
                <input type="text" id="institute" class="form-control" name="institute" value="<?= $data->institute ?>" />
            </div>

            <div class="form-outline mt-2">
                <label class="form-label" for="isi" name="isi">Isi Kearsipan</label>
                <input type="text" id="isi" class="form-control" name="isi" value="<?= $data->isi ?>" />
            </div>

            <div class="form-outline mt-2">
                <label class="form-label" for="on_date" name="on_date">Tanggal Arsip</label>
                <input type="text" id="on_date" class="form-control" name="on_date" value="<?= $data->on_date ?>" />
            </div>

            <label class="form-label mt-2" for="status">Status</label>
            <select class="browser-default custom-select" id="status" name="status">
                <option value="public" <?= ($data->status == 'public')?'selected="selected"':''?>>Publik</option>
                <option value="internal" <?= ($data->status == 'internal')?'selected="selected"':''?>>Internal</option>
            </select>

            <button type="submit" class="btn btn-primary btn-block mt-4">Simpan</button>
        </form>
    </div>

</div>
<?= $this->endSection() ?>