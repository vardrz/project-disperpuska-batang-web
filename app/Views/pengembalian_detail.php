<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="row m-4">
    <div class="col-8">
        <h1 class="my-3">Tabel Pemgembalian</h1>
        <table class="table table-bordered table-hover">
            <thead>
                <tr class="text-center">
                    <th>No</th>
                    <th>Nama Peminjam</th>
                    <th>Nomor Arsip</th>
                    <th>Instansi</th>
                    <th>Staff</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Kembali</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $data->public_name ?></td>
                    <td><?= $data->archives_number ?></td>
                    <td><?= $data->institute ?></td>
                    <td><?= $data->staff_name ?></td>
                    <td class="text-center"><?= $data->tgl_pinjam ?></td>
                    <td class="text-center"><?= $data->tgl_kembali ?></td>
                </tr>
                <tr>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="col-4">
        <form class="form" method="POST" action="<?= base_url('home/pengembalian/update/' . $data->id_pengembalian) ?>">
            <h3>Edit Data Pengembalian</h3>
            <div class="form-outline mt-2">
                <label class="form-label" for="peminjam">Peminjam</label>
                <input type="hidden" name="peminjam" value="<?= $data->id_publics; ?>">
                <input type="text" id="peminjam" value="<?= $data->public_name; ?>" class="form-control <?= isset(session()->get('validator')['peminjam']) ? 'is-invalid' : ''; ?>" readonly>
                <?php if (isset(session()->get('validator')['peminjam'])) : ?>
                    <div class="invalid-feedback">
                        <?= session()->get('validator')['peminjam']; ?>
                    </div>
                <?php endif ?>
                <div id="show_borrow_data" class="mt-2">
                    <label class="form-label" for="archive">Nomor Arsip</label>
                    <input type="hidden" name="id_archives" class="form-control" value="<?= $data->id_archives; ?>" />
                    <input type="text" class="form-control" value="<?= $data->archives_number; ?>" readonly />
                </div>
            </div>
            <div class="form-outline mt-2">
                <label class="form-label" for="date">Tanggal Pinjam</label>
                <input type="text" name="tgl_pinjam" class="form-control" value="<?= $data->tgl_pinjam; ?>" readonly />
            </div>
            <div class="form-outline mt-2">
                <label class="form-label" for="staff">Staff</label>
                <select name="staff" id="staff" class="form-control <?= isset(session()->get('validator')['staff']) ? 'is-invalid' : ''; ?>">
                    <option disabled selected>Pilih Staff</option>
                    <?php foreach ($staff as $value) { ?>
                        <option value="<?= $value->id ?>" <?= $value->id == $data->staff_id ? 'selected' : '' ?>><?= $value->id == $data->staff_id ? $value->name : $value->staff_name ?></option>
                    <?php } ?>
                </select>
                <?php if (isset(session()->get('validator')['staff'])) : ?>
                    <div class="invalid-feedback">
                        <?= session()->get('validator')['staff']; ?>
                    </div>
                <?php endif ?>
            </div>

            <div class="form-outline mt-2">
                <label class="form-label" for="tgl_kembali">Tanggal Kembali</label>
                <input type="datetime-local" name="tgl_kembali" id="tgl_kembali" class="form-control <?= isset(session()->get('validator')['tgl_kembali']) ? 'is-invalid' : ''; ?>" value="<?= $data->tgl_kembali ?>" />
                <?php if (isset(session()->get('validator')['tgl_kembali'])) : ?>
                    <div class="invalid-feedback">
                        <?= session()->get('validator')['tgl_kembali']; ?>
                    </div>
                <?php endif ?>
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-4">Simpan</button>
        </form>
    </div>

</div>

<!-- <script>
    var url = window.location.href.split("/");
    var borrowId = url[6];
    document.getElementById("show_archive").value = document.getElementById("archive_" + borrowId).value;
    document.getElementById("show_date").value = document.getElementById("date_" + borrowId).value;

    function showBorrowData() {
        var id = document.getElementById("peminjam").value;
        var archive = document.getElementById("archive_" + id).value;
        var archives = document.getElementById("archives_" + id).value;
        var date = document.getElementById("date_" + id).value;

        document.getElementById("show_archive").value = archive;
        document.getElementById("show_archives").value = archives;
        document.getElementById("show_date").value = date;
    }
</script> -->
<?= $this->endSection() ?>