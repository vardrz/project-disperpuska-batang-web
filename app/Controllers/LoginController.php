<?php

namespace App\Controllers;

use App\Models\BorrowModel;
use App\Models\StaffModel;

class LoginController extends BaseController
{
    protected $borrowModel;
    protected $staffModel;

    public function __construct()
    {
        $this->staffModel   = new StaffModel();
        $this->borrowModel  = new BorrowModel();
    }

    public function index()
    {
        $currentSession = session()->get('user_id');
        if (empty($currentSession)) return view('login');
        return redirect()->to(base_url('home'));
    }


    public function login()
    {
        $validation = $this->validate([
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password tidak boleh kosong.'
                ]
            ],
        ]);
        $peminjaman = $this->borrowModel->relasi();

        if (!$validation) {
            session()->setFlashdata('message', 'Data harus lengkap');
            return redirect()->to(base_url(''));
        }

        $nip = $this->request->getPost('nip');
        $password = $this->request->getPost('password');

        $userStaff = $this->staffModel->where('nip', $nip)->where('password', $password)->get()->getFirstRow();
        if (empty($userStaff)) {
            session()->setFlashdata('message', 'Data tidak dikenal');
            return redirect()->to(base_url(''));
        }


        session()->set('user_id', $userStaff->id);
        session()->set('user_nama', $userStaff->name);
        session()->set('user_role', $userStaff->role);
        session()->set('arsip', $peminjaman);

        return redirect()->to(base_url('home'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
