<?php

namespace App\Controllers;

use App\Models\StaffModel;

class LoginController extends BaseController
{

    protected $staffModel;

    public function __construct() {
        $this->staffModel = new StaffModel();
    }

    public function index()
    {
        $currentSession = session()->get('user_id');
        if(empty($currentSession)) return view('login');
        return redirect()->to(base_url('home'));
    }


    public function login(){
        $validation = $this->validate([
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong.'
                ]
            ],
        ]);

        
        if(!$validation){
            session()->setFlashdata('message','NIP tidak boleh kosong');
            return redirect()->to(base_url(''));
        }

        $nip = $this->request->getPost('nip');

        $userStaff = $this->staffModel->where('nip', $nip)->get()->getFirstRow();
        if(empty($userStaff)) {
            session()->setFlashdata('message', 'NIP tidak dikenal');
            return redirect()->to(base_url(''));
        }
        
        session()->set('user_id', $userStaff->id);
        session()->set('user_nama', $userStaff->name);
        session()->set('user_role', $userStaff->role);

        return redirect()->to(base_url('home'));
    }

    public function logout(){
        session()->destroy();
        return redirect()->to(base_url('/'));
    }
}
