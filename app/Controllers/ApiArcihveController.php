<?php

namespace App\Controllers;

use App\Models\ArchivesModel;
use App\Models\BorrowModel;
use App\Models\PublicModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class ApiArcihveController extends ResourceController
{
    protected $format = 'json';
    protected $archiveModel;
    protected $publicModel;
    protected $borrowModel;

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function __construct()
    {
        $this->archiveModel = new ArchivesModel();
        $this->publicModel  = new PublicModel();
        $this->borrowModel  = new BorrowModel();
    }

    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return ResponseInterface
     */
    public function getArsip()
    {
        $data  = [
            'status'    => 200,
            'message'   => 'Data Arsip Berhasil Ditampilkan',
            'data'      => $this->archiveModel->where('status', 'public')->where('keterangan', 'Tersedia')->findAll()
        ];

        if (empty($data['data'])) {
            $data = [
                'status'    => 404,
                'message'   => 'Belum Ada Data Arsip',
                'data'      => []
            ];
        }
        return $this->respond($data, 200);
    }

    /**
     * Return the properties of a resource object
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $data = [
            'status'    => 200,
            'message'   => 'Data Arsip Berhasil Ditampilkan',
            'data'      => $this->borrowModel->select('archives.*')->join('archives', 'archives.id = borrow.archives_id')->where('borrow.publics_id', $id)->findAll()
        ];

        if (empty($data['data'])) {
            $data = [
                'status'    => 404,
                'message'   => 'Data Arsip Tidak Ditemukan',
                'data'      => []
            ];
        }
        return $this->respond($data, 200);
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return ResponseInterface
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return ResponseInterface
     */
    public function create()
    {
        if (!$this->validate([
            'needs'             => [
                'rules'         => 'required',
                'errors'        => [
                    'required'  => 'Keperluan Tidak Boleh Kosong'
                ]
            ],
        ])) {
            $response = [
                'status'    => 400,
                'error'     => $this->validator->getErrors(),
                'message'   => [
                    'error' => 'Keperluan Tidak Boleh Kosong'
                ]
            ];
            return $this->fail($response, 400);
        }

        $userData = $this->publicModel->find($this->request->getVar('publics_id'));
        if (empty($userData)) {
            $response = [
                'status'    => 400,
                'message'   => 'Akun tidak dikenal'
            ];
            return $this->fail($response, 404);
        }

        $archiveData = $this->archiveModel->find($this->request->getVar('archives_id'));
        if (empty($archiveData)) {
            $response = [
                'status'    => 400,
                'message'   => 'Data arsip tidak dikenal'
            ];
            return $this->fail($response, 404);
        }

        $this->borrowModel->insert([
            'publics_id'    => $this->request->getVar('publics_id'),
            'archives_id'   => $this->request->getVar('archives_id'),
            'needs'         => $this->request->getVar('needs')
        ]);

        $this->archiveModel->update($this->request->getVar('archives_id'), ['keterangan' => 'Diproses']);

        $response = [
            'status'    => 201,
            'message'   => [
                'success' => 'Peminjaman berhasil'
            ]
        ];
        return $this->respondCreated($response);
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
