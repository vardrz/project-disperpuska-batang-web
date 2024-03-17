<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\IncomingRequest;
use App\Models\PublicModel;
use App\Models\StaffModel;

class AuthController extends ResourceController
{
    protected $publicModel;
    protected $staffModel;

    public function __construct()
    {
        $this->publicModel =  new PublicModel();
        $this->staffModel = new StaffModel();
    }

    public function loginPublic()
    {
        $request = request();

        $rules = [
            "phone" => "required",
        ];

        $messages = [
            "phone" => [
                "required" => "Nomor HP tidak boleh kosong"
            ],
        ];

        if (!$this->validate($rules, $messages)) return $this->respond([
            'status' => 445,
            'message' => $this->validator->getErrors()['phone'],
            'data' => null
        ]);

        $data = $this->publicModel->where('phone', $request->getPost('phone'))->first();
        if (empty($data)) return $this->respond([
            'status' => 332,
            'message' => "Akun tidak ditemukan",
            'data' => null
        ]);

        return $this->respond([
            'status' => 000,
            'message' => '',
            'data' => $data
        ]);
    }

    public function loginStaff()
    {
        $request = request();

        $rules = [
            "nip" => "required",
            "password" => "required",
        ];

        $messages = [
            "nip" => [
                "required" => "NIP tidak boleh kosong"
            ],
            "password" => [
                "required"  => "Password tidak boleh kosong"
            ],
        ];

        if (!$this->validate($rules, $messages)) return $this->respond([
            'status' => 445,
            'message' => $this->validator->getErrors()['nip'],
            'data' => null
        ]);

        $data = $this->staffModel
            ->where('nip', $request->getPost('nip'))
            ->where('password', $request->getPost('password'))
            ->first();
            
        if (empty($data)) return $this->respond([
            'status' => 332,
            'message' => "Akun tidak ditemukan",
            'data' => null
        ]);

        return $this->respond([
            'status' => 000,
            'message' => '',
            'data' => $data
        ]);
    }

    public function registrationPublic()
    {
        $request  = request();

        $rules = [
            "name" => "required",
            "email" => "required",
            "phone" => "required",
        ];

        $messages = [
            "name" => [
                "required" => "Nama tidak boleh kosong"
            ],
            "email" => [
                "required" => "Email tidak boleh kosong"
            ],
            "phone" => [
                "required" => "Nomor HP tidak boleh kosong"
            ],
        ];

        if (!$this->validate($rules, $messages)) return $this->respond([
            'status' => 445,
            'message' => print_r($this->validator->getErrors()),
            'data' => null
        ]);

        $area = $request->getPost('area');
        if ($area == null) $area = '';

        $result = $this->publicModel->insert([
            "name"      => $request->getPost("name"),
            "email"     => $request->getPost("email"),
            "phone"     => $request->getPost("phone"),
            "area"      => $area
        ], false);

        if ($result) {
            return $this->respond([
                "status"    => 0,
                "message"   => "Pembuatan akun berhasil, silahkan login"
            ]);
        } else {
            return $this->respond([
                "status"    => 232, 
                "message"   => "Mohon isi dengan benar"
            ]);
        }
    }
}
