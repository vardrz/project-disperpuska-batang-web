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

    public function loginPublic(){
        $request = request();

        $rules = [
			"phone" => "required",
		];

		$messages = [
			"phone" => [
				"required" => "Nomor HP tidak boleh kosong"
			],
		];

        if(!$this->validate($rules, $messages)) return $this->respond([
            'code' => 445,
            'message' => $this->validator->getErrors()['phone'],
            'data' => null
        ]);

        $data = $this->publicModel->where('phone',$request->getPost('phone'))->first();
        if(empty($data)) return $this->respond([
            'code' => 332,
            'message' => "Akun tidak ditemukan",
            'data' => null
        ]);

        return $this->respond([
            'code' => 000,
            'message' => '',
            'data' => $data 
        ]);
    }

    public function loginStaff(){
        $request = request();

        $rules = [
			"nip" => "required",
		];

		$messages = [
			"nip" => [
				"required" => "NIP tidak boleh kosong"
			],
		];

        if(!$this->validate($rules, $messages)) return $this->respond([
            'code' => 445,
            'message' => $this->validator->getErrors()['nip'],
            'data' => null
        ]);

        $data = $this->staffModel->where('nip',$request->getPost('nip'))->first();
        if(empty($data)) return $this->respond([
            'code' => 332,
            'message' => "Akun tidak ditemukan",
            'data' => null
        ]);

        return $this->respond([
            'code' => 000,
            'message' => '',
            'data' => $data 
        ]);
    }
}