<?php
$bulan = [
    "Januari" => '01',
    "Februai" => '02',
    "Maret" => '03',
    "April" => '04',
    "Mei" => '05',
    "Juni" => '06',
    "Juli" => '07',
    "Agustus" => '08',
    "September" => '09',
    "Oktober" => '10',
    "November" => '11',
    "Desember" => '12'
];
?>

<?= $this->extend('layout/page_layout') ?>

<?= $this->section('content') ?>

<div class="container">
    <div class="row">
        <div class="col-12">
            <a href="/home/laporan" class="btn btn-danger mt-5">Laporan Pengembalian</a>
            <a href="/home/laporan-peminjaman" class="btn btn-success mt-5">Laporan Peminjaman</a>
            <a href="/home/laporan-arsip" class="btn btn-info mt-5">Laporan Arsip</a>
            <h1 class="my-4">Tabel Laporan Arsip</h1>
            <div class="text-right mb-3">
                <span id="filter-desc" class="mr-5">Menampilkan data dari tanggal (<?= $date_start ?>) - (<?= $date_start == date('Y-m-d', strtotime("-1 day", strtotime($date_finish))) ? $date_start : $date_finish ?>)</span>
                <a href="/home/laporan-arsip" class="btn btn-danger" id="reset-filter">Reset Filter</a>
                <button class="btn btn-primary" data-toggle="modal" data-target="#filter">Filter</button>
            </div>
            <table class="table table-bordered table-hover">
                <thead>
                    <tr class="text-center">
                        <th>No</th>
                        <th>Arsip</th>
                        <th>Isi</th>
                        <th>Institute</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($laporan as $key => $value) : ?>
                        <tr>
                            <td><?= $key + 1 ?></td>
                            <td><?= $value->archives_number ?></td>
                            <td><?= $value->isi ?></td>
                            <td><?= $value->institute ?></td>
                            <td class="text-center"><?= $value->created_at ?></td>
                            <td class="text-center"><?= $value->keterangan ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="text-right my-3">
                <a href="/home/laporan-arsip/pdf/<?= $date_start . "|" . $date_finish ?>" class="btn btn-danger">PDF</a>
                <button class="btn btn-primary" onclick="printReport()">Print</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Filter -->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="get">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Filter Laporan Arsip</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span>Filter : </span>
                    <select id="filter-mode" name="mode" onchange="filter()">
                        <option value="harian">Harian</option>
                        <option value="mingguan">Mingguan</option>
                        <option value="bulanan">Bulanan</option>
                        <option value="range">Rentang Tanggal</option>
                    </select>
                    <p />
                    <div id="filter-day" class="d-none">
                        <span>Tanggal Arsip : </span>
                        <input type="date" name="day" />
                    </div>
                    <div id="filter-bulan" class="d-none">
                        <span>Pilih Bulan : </span>
                        <select id="select-bulan" name="month" onchange="month()">
                            <option disabled selected>Pilih</option>
                            <?php foreach ($bulan as $i => $b) : ?>
                                <option value="<?= $b ?>"><?= $i ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div id="filter-range" class="d-none">
                        <span>Tanggal Arsip : </span>
                        <input type="date" name="start" />
                        <span>-</span>
                        <input type="date" name="finish" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
    filter();
    resetFilter();

    function resetFilter() {
        var url = window.location.href.split("/");
        console.log(url[4] == 'laporan');
        if (url[4] == 'laporan-arsip') {
            document.getElementById("reset-filter").classList.add("d-none");
            document.getElementById("filter-desc").classList.add("d-none");
        } else {
            document.getElementById("reset-filter").classList.remove("d-none");
            document.getElementById("filter-desc").classList.remove("d-none");
        }
    }

    function filter() {
        var mode = document.getElementById('filter-mode').value;
        console.log(mode);

        if (mode == 'range') {
            document.getElementById("filter-range").classList.remove("d-none");
            document.getElementById("filter-range").classList.add("d-block");
            document.getElementById("filter-day").classList.remove("d-block");
            document.getElementById("filter-day").classList.add("d-none");
            document.getElementById("filter-bulan").classList.remove("d-block");
            document.getElementById("filter-bulan").classList.add("d-none");
        } else if (mode == 'harian') {
            document.getElementById("filter-day").classList.remove("d-none");
            document.getElementById("filter-day").classList.add("d-block");
            document.getElementById("filter-range").classList.remove("d-block");
            document.getElementById("filter-range").classList.add("d-none");
            document.getElementById("filter-bulan").classList.remove("d-block");
            document.getElementById("filter-bulan").classList.add("d-none");
        } else if (mode == 'mingguan') {
            document.getElementById("filter-day").classList.remove("d-block");
            document.getElementById("filter-day").classList.add("d-none");
            document.getElementById("filter-range").classList.remove("d-block");
            document.getElementById("filter-range").classList.add("d-none");
            document.getElementById("filter-bulan").classList.remove("d-block");
            document.getElementById("filter-bulan").classList.add("d-none");
        } else if (mode == 'bulanan') {
            document.getElementById("filter-bulan").classList.remove("d-none");
            document.getElementById("filter-day").classList.remove("d-block");
            document.getElementById("filter-day").classList.add("d-none");
            document.getElementById("filter-range").classList.remove("d-block");
            document.getElementById("filter-range").classList.add("d-none");
        }
    }

    function printReport() {
        window.print();
    }
</script>
<?= $this->endSection() ?>