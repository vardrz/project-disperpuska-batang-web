<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h1 class="my-3">Tabel Data Pengembalian</h1>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Peminjam</th>
                        <th>Nomor Arsip</th>
                        <th>Staff</th>
                        <th>Tanggal Kembali</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengembalianData as $key => $value) { ?>
                        <tr>
                            <td class="text-center"><?= $key + 1 ?></td>
                            <td><?= $value->public_name ?></td>
                            <td><?= $value->archives_number ?></td>
                            <td><?= $value->staff_name ?></td>
                            <td class="text-center"><?= $value->tgl_kembali ?></td>
                            <td>
                                <a class="btn btn-warning" href="<?= base_url('home/pengembalian/edit/' . $value->id_pengembalian) ?>">Lihat</a>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                    </tr>
                </tbody>
            </table>

        </div>
        <div class="col-4">
            <form class="form" method="post" action="<?= base_url('home/pengembalian/save') ?>">
                <h3>Tambah Data Pengembalian</h3>
                <div class="form-outline mt-2">
                    <label class="form-label" for="peminjam">Peminjam</label>
                    <select name="peminjam" id="peminjam" class="form-control <?= isset(session()->get('validator')['peminjam']) ? 'is-invalid' : ''; ?>" onchange="showBorrowData()">
                        <option disabled selected>Pilih Peminjam</option>
                        <?php foreach ($peminjam as $value) { ?>
                            <option value="<?= $value->id_borrow ?>"><?= $value->public_name ?></option>
                        <?php } ?>
                    </select>
                    <?php if (isset(session()->get('validator')['peminjam'])) : ?>
                        <div class="invalid-feedback">
                            <?= session()->get('validator')['peminjam']; ?>
                        </div>
                    <?php endif ?>

                    <?php foreach ($peminjam as $value) : ?>
                        <input type="hidden" id="archive_<?= $value->id_borrow ?>" value="<?= $value->archives_number ?>">
                        <input type="hidden" id="date_<?= $value->id_borrow ?>" value="<?= $value->tgl_pinjam ?>">
                        <input type="hidden" id="archives_<?= $value->id_borrow ?>" value="<?= $value->id_archives ?>">
                        <input type="hidden" id="publics_<?= $value->id_borrow ?>" value="<?= $value->id_publics ?>">
                    <?php endforeach; ?>
                    <div id="show_borrow_data" class="d-none mt-2">
                        <input type="hidden" name="id_archives" id="show_archives" class="form-control" value="" readonly />
                        <input type="hidden" name="id_publics" id="show_publics" class="form-control" value="" readonly />
                        <label class="form-label" for="archive">Nomor Arsip</label>
                        <input type="text" id="show_archive" class="form-control" value="" readonly />
                        <label class="form-label mt-2" for="date">Tanggal Pinjam</label>
                        <input type="text" name="tgl_pinjam" id="show_date" class="form-control" value="" readonly />
                        <label class="form-label mt-2" for="denda">Denda</label>
                        <input type="text" name="denda" id="show_denda" class="form-control" value="" readonly />
                    </div>
                </div>

                <div class="form-outline mt-2">
                    <label class="form-label" for="staff">Staff</label>
                    <select name="staff" id="staff" class="form-control <?= isset(session()->get('validator')['staff']) ? 'is-invalid' : ''; ?>">
                        <option disabled selected>Pilih Staff</option>
                        <?php foreach ($staff as $value) { ?>
                            <option value="<?= $value->id ?>"><?= $value->name ?></option>
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
                    <input type="datetime-local" name="tgl_kembali" id="tgl_kembali" class="form-control <?= isset(session()->get('validator')['tgl_kembali']) ? 'is-invalid' : ''; ?>" value="<?= old('tgl_kembali') ?>" />
                    <?php if (isset(session()->get('validator')['tgl_kembali'])) : ?>
                        <div class="invalid-feedback">
                            <?= session()->get('validator')['tgl_kembali']; ?>
                        </div>
                    <?php endif ?>
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-4">Sudah Dikembalikan</button>
            </form>
        </div>
    </div>
</div>

<script>
    function showBorrowData() {
        document.getElementById("show_borrow_data").classList.remove("d-none");
        document.getElementById("show_borrow_data").classList.add("d-block");

        var id = document.getElementById("peminjam").value;
        var archive = document.getElementById("archive_" + id).value;
        var archives = document.getElementById("archives_" + id).value;
        var publics = document.getElementById("publics_" + id).value;
        var date = document.getElementById("date_" + id).value;

        var date1 = new Date(date);
        var date2 = new Date();

        // document.getElementById("show_denda").value = denda;
        document.getElementById("show_archive").value = archive;
        document.getElementById("show_archives").value = archives;
        document.getElementById("show_publics").value = publics;
        document.getElementById("show_date").value = date;
    }
</script>

<?= $this->endSection() ?>