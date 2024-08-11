<?php

namespace App\Controllers;

use App\Models\StaffModel;

class LoginController extends BaseController
{
    protected $staffModel;

    public function __construct()
    {
        $this->staffModel   = new StaffModel();
    }

    public function index()
    {
        $currentSession = session()->get('user_id');
        if (empty($currentSession)) return view('login');
        return redirect()->to(base_url('home'));
    }


    public function login()
    {
        if (!$this->validate([
            'nip'   => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP harus diisi.'
                ]
            ],
            'password'   => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Password harus diisi.'
                ]
            ]
        ])) {
            session()->setFlashdata('message', $this->validator->listErrors());
            return redirect()->to(base_url('/'))->withInput();
        }

        $nip = $this->request->getPost('nip');
        $password = $this->request->getPost('password');

        $userStaff = $this->staffModel->where('nip', $nip)->where('password', $password)->get()->getFirstRow();
        if (empty($userStaff)) {
            session()->setFlashdata('message', 'Data tidak dikenal');
            return redirect()->to(base_url('/'));
        }
        session()->set('user_id', $userStaff->id);
        session()->set('user_nama', $userStaff->name);
        session()->set('role', $userStaff->role);
        session()->set('logged_in', TRUE);

        session()->setFlashdata('pesan', 'Login Berhasil');
        return redirect()->to(base_url('home'));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
