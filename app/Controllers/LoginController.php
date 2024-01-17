<?php

namespace App\Controllers;

class LoginController extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function login(){
        $validation = $this->validate([
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Email tidak boleh kosong.'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kata sandi tidak boleh kosong.'
                ]
            ],
        ]);

        
        if(!$validation){
            session()->setFlashdata('gagal','Username/password salah');
        }
    }
}
