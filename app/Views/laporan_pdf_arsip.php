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
    <h3 style="text-align: center;">Laporan Arsip</h3>
    <table style="width:100%">
        <thead>
            <tr style="text-align: center;">
                <th>No</th>
                <th>Arsip</th>
                <th>Institute</th>
                <th>Isi</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($laporan as $key => $value) : ?>
                <tr>
                    <td style="text-align: center;"><?= $key + 1 ?></td>
                    <td><?= $value->archives_number ?></td>
                    <td><?= $value->institute ?></td>
                    <td><?= $value->isi ?></td>
                    <td style="text-align: center;"><?= $value->created_at ?></td>
                    <td style="text-align: center;"><?= $value->keterangan ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>