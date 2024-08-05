<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\PublicModel;
use App\Models\StaffModel;

class ApiAuthController extends ResourceController
{
    protected $format = 'json';
    protected $PublicModel;
    protected $StaffModel;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function __construct()
    {
        $this->PublicModel  = new PublicModel();
        $this->StaffModel   = new StaffModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function loginPublic()
    {
        if (!$this->validate([
            'phone'             => [
                'rules'         => 'required',
                'errors'        => [
                    'required'  => 'Nomor HP tidak boleh kosong'
                ]
            ]
        ])) {
            $response = [
                'status'    => 400,
                'error'     => $this->validator->getErrors(),
                'message'   => [
                    'error' => 'Nomor HP tidak boleh kosong'
                ]
            ];
            return $this->respond($response, 400);
        }

        $phone  = $this->request->getVar('phone');
        $data   = $this->PublicModel->where('phone', $phone)->first();
        if (empty($data)) {
            $response   = [
                'status'    => 404,
                'error'     => 'Akun tidak ditemukan',
                'message'   => [
                    'error' => 'Akun tidak ditemukan'
                ]
            ];
            return $this->respond($response, 404);
        }

        $response   = [
            'status'    => 200,
            'message'   => 'Akun ditemukan',
            'data'      => $data
        ];

        return $this->respond($response, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function loginStaff()
    {
        if (!$this->validate([
            'nip'               => [
                'rules'         => 'required',
                'errors'        => [
                    'required'  => 'NIP tidak boleh kosong'
                ]
            ],
            'password'          => [
                'rules'         => 'required',
                'errors'        => [
                    'required'  => 'Password tidak boleh kosong'
                ]
            ]
        ])) {
            $response = [
                'status'    => 400,
                'error'     => $this->validator->getErrors(),
                'message'   => [
                    'error' => 'NIP atau Password tidak boleh kosong'
                ]
            ];
            return $this->respond($response, 400);
        }

        $nip        = $this->request->getVar('nip');
        $password   = $this->request->getVar('password');
        $data       = $this->StaffModel->where('nip', $nip)->where('password', $password)->first();
        if (empty($data)) {
            $response = [
                'status'    => 404,
                'error'     => 'Akun tidak ditemukan',
                'message'   => [
                    'error' => 'Akun tidak ditemukan'
                ]
            ];
            return $this->respond($response, 404);
        }

        $response   = [
            'status'    => 200,
            'message'   => 'Akun ditemukan',
            'data'      => $data
        ];

        return $this->respond($response, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
    public function registrationPublic()
    {
        if (!$this->validate([
            'name'              => [
                'rules'         => 'required',
                'errors'        => [
                    'required'  => 'Nama tidak boleh kosong'
                ]
            ],
            'email'                 => [
                'rules'             => 'required|valid_email',
                'errors'            => [
                    'required'      => 'Email tidak boleh kosong',
                    'valid_email'   => 'Email tidak valid'
                ]
            ],
            'phone'             => [
                'rules'         => 'required|is_unique[publics.phone]',
                'errors'        => [
                    'required'  => 'Nomor HP tidak boleh kosong',
                    'is_unique' => 'Nomor HP sudah terdaftar'
                ]
            ],
            'ktp'               => [
                'rules'         => 'uploaded[ktp]|max_size[ktp,1024]|is_image[ktp]|mime_in[ktp,image/jpg,image/jpeg,image/png]',
                'errors'        => [
                    'uploaded'  => 'KTP tidak boleh kosong',
                    'max_size'  => 'foto KTP melebihi kapasitas',
                    'is_image'  => 'foto KTP harus berupa gambar',
                    'mime_in'   => 'foto KTP harus berformat jpg, jpeg, png'
                ]
            ]
        ])) {
            $response = [
                'status'    => 400,
                'error'     => $this->validator->getErrors(),
                'message'   => [
                    'error' => 'Mohon isi dengan benar'
                ]
            ];
            return $this->respond($response, 400);
        }

        $name       = $this->request->getVar('name');
        $ktp        = $this->request->getFile('ktp');
        $namaFile   = $name . '-' . $ktp->getRandomName();
        $ktp->move('uploads', $namaFile);

        $data = [
            'name'      => $name,
            'email'     => $this->request->getVar('email'),
            'phone'     => $this->request->getVar('phone'),
            'ktp'       => $namaFile
        ];
        $this->PublicModel->insert($data);

        $response = [
            'status' => 201,
            'message' => [
                'success' => 'Data Berhasil Disimpan'
            ]
        ];
        return $this->respondCreated($response);
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        //
    }
}
