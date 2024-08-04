<?php

namespace App\Controllers;

use App\Models\ArchivesModel;
use App\Models\LaporanModel;
use Dompdf\Dompdf;

class LaporanController extends BaseController
{
    protected $laporanModel;
    protected $arsipModel;

    public function __construct()
    {
        $this->laporanModel = new LaporanModel();
        $this->arsipModel  = new ArchivesModel();
    }

    public function laporan()
    {
        $date = [$_GET['start'] ?? null, $_GET['finish'] ?? null];

        $filterMode = $_GET['mode'] ?? null;
        if ($filterMode != null) {
            switch ($filterMode) {
                case 'harian':
                    if ($_GET['day'] == '') {
                        return redirect()->to(base_url('home/laporan'));
                    }
                    $date = [$_GET['day'] . ' 00:00:00', $_GET['day'] . ' 23:59:59'];
                    break;
                case 'mingguan':
                    function rangeWeek($datestr)
                    {
                        $dt = strtotime($datestr);
                        return [
                            date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt)),
                            date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt))
                        ];
                    }
                    $date = rangeWeek(date('Y-m-d'));
                    break;
                case 'bulanan':
                    $bulan = $_GET['month'] ?? date('m');
                    $date = [date('Y-' . $bulan . '-01 00:00:00'), date('Y-m-t 23:59:59', strtotime(date('Y-' . $bulan . '-01')))];
                    break;
                case 'range':
                    if ($_GET['start'] == '' || $_GET['finish'] == '') {
                        return redirect()->to(base_url('home/laporan'));
                    }
                    $date = [$_GET['start'] . ' 00:00:00', $_GET['finish'] . ' 23:59:59'];
                    break;
            }
        }

        if ($date == [null, null]) {
            // Ambil semua data dari BorrowModel, PublicModel, dan PengembalianModel
            $allData = $this->laporanModel->putAllData();
        } else {
            $allData = $this->laporanModel->getFilterData($date);
            // var_dump($allData);
            // die;
        }

        // Debugging: Menampilkan isi dari variabel allData
        // dd($staffData);

        // Kirim data ke view
        return view('laporan', [
            'laporan' => $allData,
            'date_start' => $date[0],
            'date_finish' => $date[1],
        ]);
    }


    public function laporanPeminjaman()
    {
        $date = [$_GET['start'] ?? null, $_GET['finish'] ?? null];

        $filterMode = $_GET['mode'] ?? null;
        if ($filterMode != null) {
            switch ($filterMode) {
                case 'harian':
                    if ($_GET['day'] == '') {
                        return redirect()->to(base_url('home/laporan-peminjaman'));
                    }
                    $date = [$_GET['day'] . ' 00:00:00', $_GET['day'] . ' 23:59:59'];
                    break;
                case 'mingguan':
                    function rangeWeek($datestr)
                    {
                        $dt = strtotime($datestr);
                        return [
                            date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt)),
                            date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt))
                        ];
                    }
                    $date = rangeWeek(date('Y-m-d'));
                    break;
                case 'bulanan':
                    $bulan = $_GET['month'] ?? date('m');
                    $date = [date('Y-' . $bulan . '-01 00:00:00'), date('Y-m-t 23:59:59', strtotime(date('Y-' . $bulan . '-01')))];
                    break;
                case 'range':
                    if ($_GET['start'] == '' || $_GET['finish'] == '') {
                        return redirect()->to(base_url('home/laporan-peminjaman'));
                    }
                    $date = [$_GET['start'] . ' 00:00:00', $_GET['finish'] . ' 23:59:59'];
                    break;
            }
        }

        if ($date == [null, null]) {
            // Ambil semua data dari BorrowModel, PublicModel, dan PengembalianModel
            $allData = $this->laporanModel->putAllBorrow();
        } else {
            $allData = $this->laporanModel->getFilterBorrow($date);
        }

        // var_dump($allData);
        // die;

        // Kirim data ke view
        return view('laporanpeminjaman', [
            'laporan' => $allData,
            'date_start' => $date[0],
            'date_finish' => $date[1],
        ]);
    }


    public function laporanArsip()
    {
        $date = [$_GET['start'] ?? null, $_GET['finish'] ?? null];

        $filterMode = $_GET['mode'] ?? null;
        if ($filterMode != null) {
            switch ($filterMode) {
                case 'harian':
                    if ($_GET['day'] == '') {
                        return redirect()->to(base_url('home/laporan-arsip'));
                    }
                    $date = [$_GET['day'] . ' 00:00:00', $_GET['day'] . ' 23:59:59'];
                    break;
                case 'mingguan':
                    function rangeWeek($datestr)
                    {
                        $dt = strtotime($datestr);
                        return [
                            date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt)),
                            date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt))
                        ];
                    }
                    $date = rangeWeek(date('Y-m-d'));
                    break;
                case 'bulanan':
                    $bulan = $_GET['month'] ?? date('m');
                    $date = [date('Y-' . $bulan . '-01 00:00:00'), date('Y-m-t 23:59:59', strtotime(date('Y-' . $bulan . '-01')))];
                    break;
                case 'range':
                    if ($_GET['start'] == '' || $_GET['finish'] == '') {
                        return redirect()->to(base_url('home/laporan-arsip'));
                    }
                    $date = [$_GET['start'] . ' 00:00:00', $_GET['finish'] . ' 23:59:59'];
                    break;
            }
        }

        if ($date == [null, null]) {
            // Ambil semua data dari BorrowModel, PublicModel, dan PengembalianModel
            $allData = $this->laporanModel->putAllArsip();
        } else {
            $allData = $this->laporanModel->getFilterArsip($date);
        }

        // var_dump($allData);
        // die;

        // Kirim data ke view
        return view('laporanArsip', [
            'laporan' => $allData,
            'date_start' => $date[0],
            'date_finish' => $date[1],
        ]);
    }

    public function savePDF($date)
    {
        $filter = explode('|', $date);

        if ($filter == ["", ""]) {
            $allData = $this->laporanModel->putAllData();
        } else {
            $allData = $this->laporanModel->getFilterData($filter);
        }

        $filename = 'Laporan_' . date('y-m-d');

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan_pdf', [
            'laporan' => $allData,
        ]));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream($filename);
    }

    public function saveBorrowPDF($date)
    {
        $filter = explode('|', $date);

        if ($filter == ["", ""]) {
            $allData = $this->laporanModel->putAllBorrow();
        } else {
            $allData = $this->laporanModel->getFilterBorrow($filter);
        }

        $filename = 'Laporan_Peminjaman_' . date('y-m-d');

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan_pdf_borrow', [
            'laporan' => $allData,
        ]));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream($filename);
    }

    public function saveArsipPDF($date)
    {
        $filter = explode('|', $date);

        if ($filter == ["", ""]) {
            $allData = $this->laporanModel->putAllArsip();
        } else {
            $allData = $this->laporanModel->getFilterArsip($filter);
        }

        $filename = 'Laporan_Arsip_' . date('y-m-d');

        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('laporan_pdf_arsip', [
            'laporan' => $allData,
        ]));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream($filename);
    }
}
