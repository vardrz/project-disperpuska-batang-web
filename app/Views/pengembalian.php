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
                    <input type="datetime-local" name="tgl_kembali" id="tgl_kembali" class="form-control <?= isset(session()->get('validator')['tgl_kembali']) ? 'is-invalid' : ''; ?>" value="<?= old('tgl_kembali') ?>" onchange="Denda()" />
                    <?php if (isset(session()->get('validator')['tgl_kembali'])) : ?>
                        <div class="invalid-feedback">
                            <?= session()->get('validator')['tgl_kembali']; ?>
                        </div>
                    <?php endif ?>

                    <div id="show_denda" class="d-none mt-2">
                        <label class="form-label mt-2" for="denda">Denda</label>
                        <input type="text" name="denda" id="show_hasil_denda" class="form-control" value="" readonly />
                    </div>
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

        document.getElementById("show_archive").value = archive;
        document.getElementById("show_archives").value = archives;
        document.getElementById("show_publics").value = publics;
        document.getElementById("show_date").value = date;
    }

    function Denda() {
        var id = document.getElementById("peminjam").value;
        document.getElementById("show_denda").classList.remove("d-none");
        document.getElementById("show_denda").classList.add("d-block");
        var tgl_kembali = document.getElementById("tgl_kembali").value;
        var tgl_pinjam = document.getElementById("show_date").value;

        var date_K = tgl_kembali.split("T");
        var date_K1 = date_K[0].split("-");

        var date_P = tgl_pinjam.split(" ");
        var date_P1 = date_P[0].split("-");

        var pengembalian_date = new Date(date_K1[0] + "-" + date_K1[1] + "-" + date_K1[2]);
        var pengajuan_date = new Date(date_P1[0] + "-" + date_P1[1] + "-" + date_P1[2]);

        // var pengajuan_date = date_P1[0] + "-" +
        //     date_P1[1] + "-" + date_P1[2];
        // var pengembalian_date = date_K1[0] + "-" +
        //     date_K1[1] + "-" + date_K1[2];

        var days = DaysBetween(pengajuan_date, pengembalian_date);

        if (days > 7) {
            var denda = (days - 7) * 2000;
        } else {
            var denda = 0;
        }
        var format = number_format(denda);
        document.getElementById("show_hasil_denda").value = format;
    }

    function DaysBetween(StartDate, EndDate) {
        const oneDay = 1000 * 60 * 60 * 24;

        const start = Date.UTC(EndDate.getFullYear(), EndDate.getMonth(), EndDate.getDate());
        const end = Date.UTC(StartDate.getFullYear(), StartDate.getMonth(), StartDate.getDate());

        return (start - end) / oneDay;
    }

    function number_format(number) {
        var formatter = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0
        });
        return formatter.format(number);
    }
</script>

<?= $this->endSection() ?>