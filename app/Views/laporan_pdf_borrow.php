<!DOCTYPE html>

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <h3 style="text-align: center;">Laporan Peminjaman</h3>
    <table style="width:100%">
        <thead>
            <tr style="text-align: center;">
                <th>No</th>
                <th>Nama</th>
                <th>Arsip</th>
                <th>Tanggal Pinjam</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $key => $value) : ?>
                <tr>
                    <td style="text-align: center;"><?= $key + 1 ?></td>
                    <td><?= $value->public_name ?></td>
                    <td><?= $value->archives_number ?></td>
                    <td style="text-align: center;"><?= $value->tgl_pinjam ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>