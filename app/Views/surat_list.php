<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="row mx-5 mb-5">
    <div class="col-8">
        <h1 class="my-3">Tabel Data Arsip</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nomor Arsip</th>
                    <th>Instansi</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Isi</th>
                    <th>Keterangan</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data_surat as $key => $value) { ?>
                    <tr>
                        <td><?= $key + 1 ?></td>
                        <td><?= $value->archives_number ?></td>
                        <td><?= $value->institute ?></td>
                        <td><?= $value->status ?></td>
                        <td><?= $value->on_date ?></td>
                        <td><?= $value->isi ?></td>
                        <td class="text-center">
                            <?php if ($value->keterangan == 'Tersedia') : ?>
                                <span class="badge bg-success text-white">Tersedia</span>
                            <?php elseif ($value->keterangan == 'Dipinjam') : ?>
                                <span class="badge bg-danger text-white">Dipinjam</span>
                            <?php else : ?>
                                <span class="badge bg-warning text-white">Diproses</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a class="btn btn-warning" href="<?= base_url('home/surat/detail?id=' . $value->id) ?>">Lihat</a>
                        </td>
                    </tr>
                <?php } ?>
                <tr>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-4">
        <form class="form" method="post" action="<?= base_url('home/surat/save') ?>">
            <h3>Tambah Data Arsip</h3>
            <input type="hidden" name="is_new" value="1" />
            <div class="form-outline mt-4">
                <label class="form-label" for="number" name="number">Nomor Arsip</label>
                <input type="text" id="number" class="form-control" name="archives_number" />
            </div>

            <div class="form-outline mt-2">
                <label class="form-label" for="instansi" name="instansi">Nama Instansi</label>
                <input type="text" id="instansi" class="form-control" name="institute" />
            </div>

            <div class="form-outline mt-2">
                <label class="form-label" for="tanggal">Tanggal</label>
                <input type="date" id="tanggal" class="form-control" name="on_date" />
            </div>

            <div>
                <label class="form-label mt-2" for="isi">Isi</label>
                <input type="text" id="isi" class="form-control" name="isi" />
            </div>

            <label class="form-label mt-2" for="status">Status</label>
            <select class="browser-default custom-select" id="status" name="status">
                <option value="public" selected>Public</option>
                <option value="internal">Internal</option>
            </select>

            <button type="submit" class="btn btn-primary btn-block mt-4">Simpan</button>
        </form>
    </div>
</div>

<?= $this->endSection() ?>