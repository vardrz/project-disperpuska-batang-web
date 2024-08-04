<?php

namespace App\Controllers;

use App\Models\ArchivesModel;
use App\Models\BorrowModel;
use App\Models\PublicModel;
use App\Models\StaffModel;
use stdClass;

class HomeController extends BaseController
{
    protected $publicsModel;
    protected $archivesModel;
    protected $borrowModel;
    protected $staffsModel;


    public function __construct()
    {
        $this->publicsModel = new PublicModel();
        $this->staffsModel = new StaffModel();
        $this->archivesModel = new ArchivesModel();
        $this->borrowModel = new BorrowModel();
    }

    public function index(): string
    {
        $totalSurat = $this->archivesModel->countAllResults();
        $totalMember = $this->publicsModel->countAllResults();
        $totalPinjam = $this->borrowModel->countAllResults();
        return view('home', [
            'surat'     =>  $totalSurat,
            'member'    =>  $totalMember,
            'pinjam'    =>  $totalPinjam,
        ]);
    }

    public function public(): string
    {
        $allData = $this->publicsModel->findAll();
        return view('public', ['publics' => $allData]);
    }

    public function publicDelete($id)
    {
        $this->publicsModel->delete($id);
        return redirect()->to(base_url('home/public'));
    }

    public function admin(): string
    {
        $id = request()->getGet("id");

        if (empty($id) || $id == null) {
            $oneData = new stdClass();
            $oneData->nip = "";
            $oneData->role = "";
            $oneData->name = "";
            $oneData->id = "";
            $oneData->password = "";
        } else {
            $oneData = $this->staffsModel->find($id);
        }

        $allData = $this->staffsModel->findAll();
        return view('admin', ['staffs' => $allData, 'is_edit' => !empty($id), 'data' => $oneData]);
    }

    public function adminDelete($id)
    {
        $this->staffsModel->delete($id);
        return redirect()->to(base_url('home/admin'));
    }

    public function adminSave()
    {
        $request = request();
        $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong.'
                ]
            ],
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong.'
                ]
            ],
            'tipe' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tingkat admin tidak boleh kosong.'
                ]
            ],
        ]);

        $id = $request->getGet("id");

        if (empty($id) || $id == null) {
            $result = $this->staffsModel->insert([
                'name'    =>  $request->getPost("nama"),
                'nip'     =>  $request->getPost("nip"),
                'password'   =>  $request->getPost("password"),
                'role'   =>  $request->getPost("tipe"),
            ], false);
        } else {
            $result = $this->staffsModel->update($id, [
                'name'    =>  $request->getPost("nama"),
                'nip'     =>  $request->getPost("nip"),
                'password'   =>  $request->getPost("password"),
                'role'   =>  $request->getPost("tipe"),
            ]);
        }

        if (!$result) {
            session()->setFlashdata('message', 'Terjadi kesalahan');
        }

        return redirect()->to(base_url('home/admin'));
    }

    public function surat(): string
    {
        $request = request();
        $archivesData = $this->archivesModel->findAll();
        $is_new = $request->getPost("is_new");
        if (empty($is_new)) return view('surat_list', ['data_surat' => $archivesData]);

        $result = $this->archivesModel->insert([
            'archives_number'      =>  $request->getPost("number"),
            'institute'            =>  $request->getPost("instansi"),
            'on_date'              =>  $request->getPost("tanggal"),
            'isi'                  =>  $request->getPost("isi"),
            'status'               =>  $request->getPost("status"),
            'keterangan'           =>  'Tersedia',
        ], false);

        if (!$result) {
            session()->setFlashdata('message', 'Terjadi kesalahan');
        }
        return redirect()->to(base_url('home/surat'));
    }
}
