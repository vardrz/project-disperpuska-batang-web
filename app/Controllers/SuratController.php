<?php

namespace App\Controllers;

use App\Models\ArchivesModel;
use App\Models\BorrowModel;
use App\Models\PublicModel;

class SuratController extends BaseController
{
    protected $archivesModel;
    protected $borrowModel;
    protected $publicModel;

    public function __construct()
    {
        $this->archivesModel = new ArchivesModel();
        $this->borrowModel = new BorrowModel();
        $this->publicModel = new PublicModel();
    }

    public function suratDetail(): string
    {
        $id = request()->getGet("id");
        if (empty($id)) return redirect()->to(base_url('home/surat'));

        $data = $this->archivesModel->find($id);
        if (empty($data)) {
            session()->setFlashdata('message', 'Terjadi kesalahan');
            return redirect()->to(base_url('home/surat'));
        }

        $peminjaman = $this->borrowModel->where('archives_id', $id)->get()->getResult();
        if (empty($peminjaman)) {
            $peminjaman = [];
        } else {
            foreach ($peminjaman as $borrow) {
                $query = $this->publicModel->find($borrow->publics_id);
                $borrow->public_name = (empty($query) ? "-" : $query->name);
            }
        }

        return view('surat', ['data' => $data, 'pinjam' => $peminjaman]);
    }

    public function suratSave()
    {
        $request = request();

        if ($request->getPost("is_new") != null) {
            $result = $this->archivesModel->save([
                'archives_number' => $request->getPost("archives_number"),
                'institute' => $request->getPost("institute"),
                'on_date' => $request->getPost("on_date"),
                'isi' => $request->getPost("isi"),
                'status' => $request->getPost("status"),
                'keterangan' => 'Tersedia',
            ]);

            if (!$result) {
                session()->setFlashdata('message', 'Terjadi Kesalahan Input');
            } else {
                session()->setFlashdata('message', 'Penambahan Berhasil');
            }
            return redirect()->to(base_url('home/surat'));
        }

        $id = $request->getPost("id");
        if (empty($id)) {
            session()->setFlashdata('message', 'Terjadi Kesalahan | ID tidak dikenal');
            return redirect()->to(base_url('home/surat'));
        }

        $data = $this->archivesModel->find($id);
        if (empty($data)) {
            session()->setFlashdata('message', 'Terjadi Kesalahan | Data tidak dikenal');
            return redirect()->to(base_url('home/surat'));
        }

        $result = $this->archivesModel->update($id, [
            'archives_number' => $request->getPost("archives_number"),
            'institute' => $request->getPost("institute"),
            'on_date' => $request->getPost("on_date"),
            'isi' => $request->getPost("isi"),
            'status' => $request->getPost("status"),
        ]);

        if (!$result) {
            session()->setFlashdata('message', 'Terjadi Kesalahan Input');
        } else {
            session()->setFlashdata('message', 'Edit Berhasil');
        }

        return redirect()->to(base_url('home/surat/detail?id=' . $id));
    }
}
