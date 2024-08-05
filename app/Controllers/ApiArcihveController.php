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
        if ($this->validate([
            'user_id'       => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'User id is required'
                ]
            ],
            'archive_id'    => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Archive id is required'
                ]
            ],
        ])) {
            $response = [
                'status'    => 400,
                'message'   => 'Terjadi Kesalahan',
            ];
        }
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
