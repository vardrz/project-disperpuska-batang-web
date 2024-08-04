<?php

namespace App\Controllers;

use App\Models\ArchivesModel;
use App\Models\BorrowModel;
use App\Models\PengembalianModel;
use App\Models\StaffModel;

class PengembalianController extends BaseController
{
    protected $staffData;
    protected $pengembalianModel;
    protected $borrowData;
    protected $arsip;

    public function __construct()
    {
        $this->staffData = new StaffModel();
        $this->pengembalianModel = new PengembalianModel();
        $this->borrowData = new BorrowModel();
        $this->arsip = new ArchivesModel();
    }

    public function pengembalian()
    {
        // Ambil semua data dari BorrowModel, PublicModel, dan PengembalianModel
        $borrowData = $this->pengembalianModel->putBorrow();
        $staffData = $this->staffData->findAll();
        $allData = $this->pengembalianModel->putAllData();

        // Debugging: Menampilkan isi dari variabel allData
        // dd($borrowData);

        // Kirim data ke view
        return view('pengembalian', [
            'pengembalianData' => $allData,
            'peminjam' => $borrowData,
            'staff' => $staffData
        ]);
    }

    public function pengembalianSave()
    {
        if (!$this->validate([
            'peminjam' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Peminjam harus diisi.'
                ]
            ],
            'staff' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Staff harus diisi.'
                ]
            ],
            'tgl_kembali' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal kembali harus diisi.'
                ]
            ]
        ])) {
            session()->setFlashdata('validator', $this->validator->getErrors());
            return redirect()->to(base_url('home/pengembalian'))->withInput();
        }

        $data = [
            'id_publics'     => $this->request->getPost('id_publics'),
            'id_archives'   => $this->request->getPost('id_archives'),
            'staffs_id'     => $this->request->getPost('staff'),
            'created_at'    => $this->request->getPost('tgl_pinjam'),
            'update_at'     => $this->request->getPost('tgl_kembali'),
        ];

        $this->arsip->update($this->request->getPost('id_archives'), ['keterangan' => 'Tersedia']);
        $this->borrowData->delete($this->request->getPost('peminjam'));
        $this->pengembalianModel->insertData($data);
        session()->setFlashdata('pesan', 'Data pengembalian berhasil ditambahkan.');
        return redirect()->to(base_url('home/pengembalian'));
    }

    public function pengembalianEdit($id)
    {
        $borrowData = $this->pengembalianModel->putBorrow();
        $staffData = $this->staffData->findAll();
        $data = $this->pengembalianModel->putData($id);

        return view('pengembalian_detail', [
            'data' => $data,
            'peminjam' => $borrowData,
            'staff' => $staffData
        ]);
    }

    public function pengembalianUpdate($id)
    {
        if (!$this->validate([
            'peminjam' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Peminjam harus diisi.'
                ]
            ],
            'staff' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Staff harus diisi.'
                ]
            ],
            'tgl_kembali' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tanggal kembali harus diisi.'
                ]
            ]
        ])) {
            session()->setFlashdata('validator', $this->validator->getErrors());
            return redirect()->to(base_url('home/pengembalian/edit/' . $id))->withInput();
        }

        $data = [
            'id_publics'     => $this->request->getPost('peminjam'),
            'id_archives'   => $this->request->getPost('id_archives'),
            'staffs_id'     => $this->request->getPost('staff'),
            'created_at'    => $this->request->getPost('tgl_pinjam'),
            'update_at'     => $this->request->getPost('tgl_kembali'),
        ];

        $this->pengembalianModel->update($id, $data);
        session()->setFlashdata('pesan', 'Data pengembalian berhasil diubah.');
        return redirect()->to(base_url('home/pengembalian'));
    }
}
