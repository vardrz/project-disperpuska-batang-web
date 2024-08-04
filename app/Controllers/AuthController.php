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

        $data = $this->publicModel->where('phone', $request->getVar('phone'))->first();
        if (empty($data)) return $this->respond([
            'status' => 332,
            'message' => "Akun tidak ditemukan",
            'data' => null
        ]);

        return $this->respond([
            'status' => 200,
            'message' => 'Data akun tersedia',
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
        $request = request();

        $rules = [
            "name" => "required",
            "email" => "required|valid_email",
            "phone" => "required",
            "ktp" => "uploaded[ktp]|mime_in[ktp,image/jpg,image/jpeg,image/png]" // Validasi file KTP
        ];

        $messages = [
            "name" => [
                "required" => "Nama tidak boleh kosong"
            ],
            "email" => [
                "required" => "Email tidak boleh kosong",
                "valid_email" => "Format email tidak valid"
            ],
            "phone" => [
                "required" => "Nomor HP tidak boleh kosong"
            ],
            "ktp" => [
                "uploaded" => "File KTP harus diupload",
                "mime_in" => "Hanya gambar dengan format jpg, jpeg, png yang diizinkan",
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->respond([
                'status' => 445,
                'message' => print_r($this->validator->getErrors()),
                'data' => null
            ]);
        }

        $name = $request->getVar("name");
        $email = $request->getVar("email");
        $phone = $request->getVar("phone");
        $area = $request->getVar('area') ?? 'Kabupaten Batang';

        // Proses file upload
        $ktpFile = $request->getFile('ktp');
        $ktpFilePath = null;

        if ($ktpFile->isValid() && !$ktpFile->hasMoved()) {
            // $ktpFileName = $phone;
            $ktpFileName = $ktpFile->getRandomName();
            // Move the file to the 'assets' folder
            $ktpFile->move(FCPATH  . 'assets', $ktpFileName);
            $ktpFilePath = $ktpFileName;
        }

        $result = $this->publicModel->insert([
            "name"      => $name,
            "email"     => $email,
            "phone"     => $phone,
            "area"      => $area,
            "ktp"       => $ktpFilePath
        ], false);

        if ($result) {
            return $this->respond([
                "status"    => 200,
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
