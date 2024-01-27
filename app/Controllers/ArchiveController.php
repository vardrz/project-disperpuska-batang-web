<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\IncomingRequest;
use App\Models\ArchivesModel;
use App\Models\BorrowModel;
use App\Models\PublicModel;

class ArchiveController extends ResourceController
{
    protected $archiveModel;
    protected $publicModel;
    protected $borrowModel;

    public function __construct() {
        $this->archiveModel = new ArchivesModel();
        $this->publicModel = new PublicModel();
        $this->borrowModel = new BorrowModel();
    }

    public function findArchived() {
        $request = request();
        $data = $request->getGet("query");
        $data = $this->archiveModel->like('archives_number',$data)->orLike('isi',$data)->orLike('institute', $data)->get()->getResultObject();
        return $this->respond([
            'status'    =>  222,
            'message'   =>  'search respond',
            'data'      =>  $data
        ]);
    }

    public function leanArchive(){
        $request = request();
        
        $rules = [
            "user_id" => "required",
            "archive_id" => "required",
        ];

        $messages = [
            "user_id" => [
                "required" => "User id is required"
            ],
            "archive_id" => [
                "required" => "Archive id is required"
            ],
        ];

        if (!$this->validate($rules, $messages)) return $this->respond([
            'status' => 445,
            'message' => print_r($this->validator->getErrors()),
            'data' => null
        ]);

        $userData = $this->publicModel->find($request->getPost("user_id"));
        if(empty($userData)) return $this->respond([
            'status'    => 332,
            'message'   => 'Akun tidak dikenal'
        ]);

        $archiveData = $this->archiveModel->find($request->getPost("archive_id"));
        if(empty($archiveData)) return $this->respond([
            'status'    =>  333,
            'message'   =>  'Data arsip tidak dikenal'
        ]);

        $isSaved = $this->borrowModel->insert([
            'publics_id'   =>  $request->getPost('user_id'),
            'archives_id'  =>  $request->getPost('archive_id'),
            'notes'        =>  $request->getPost('notes'),
            'needs'        =>  $request->getPost('needs')
        ], false);

        if ($isSaved) {
            return $this->respond([
                "status"    => 0,
                "message"   => "Peminjaman berhasil"
            ]);
        } else {
            return $this->respond([
                "status"    => 232, 
                "message"   => "Terjadi kesalahan"
            ]);
        }
    }
}
