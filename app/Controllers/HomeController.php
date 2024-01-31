<?php

namespace App\Controllers;

use App\Models\PublicModel;
use App\Models\StaffModel;
use PhpParser\Node\Expr\Cast\Object_;
use stdClass;

class HomeController extends BaseController
{
    protected $publicsModel;
    protected $staffsModel;

    public function __construct() {
        $this->publicsModel = new PublicModel();
        $this->staffsModel = new StaffModel();
    }
    public function index(): string
    {
        return view('home');
    }

    public function public(): string {
        $allData = $this->publicsModel->findAll();
        return view('public',['publics'=>$allData]);
    }

    public function publicDelete($id) {
        $this->publicsModel->delete($id);
        return redirect()->to(base_url('home/public'));
    }

    public function admin(): string {
        $id = request()->getGet("id");
        
        if(empty($id) || $id == null) {
            $oneData = new stdClass();
            $oneData->nip = "";
            $oneData->role = "";
            $oneData->name = "";
            $oneData->id = "";
            $oneData->password = "";
        }else {
            $oneData = $this->staffsModel->find($id);
        }
        
        $allData = $this->staffsModel->findAll();
        return view('admin',['staffs' => $allData, 'is_edit'=>!empty($id), 'data'=>$oneData]);
    }

    public function adminDelete($id){
        $this->staffsModel->delete($id);
        return redirect()->to(base_url('home/admin'));
    }

    public function adminSave(){
        $request = request();
        $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Nama tidak boleh kosong.'
                ]
            ],
            'nip' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'NIP tidak boleh kosong.'
                ]
            ],
            'tipe' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Tingkat admin tidak boleh kosong.'
                ]
            ],
        ]);
        
        $id = $request->getGet("id");

        if(empty($id) || $id == null){
            $result = $this->staffsModel->insert([
                'name'    =>  $request->getPost("nama"),
                'nip'     =>  $request->getPost("nip"),
                'password'   =>  $request->getPost("password"),
                'roles'   =>  $request->getPost("tipe"),
            ], false);
        }else{
            $result = $this->staffsModel->update($id, [
                'name'    =>  $request->getPost("nama"),
                'nip'     =>  $request->getPost("nip"),
                'password'   =>  $request->getPost("password"),
                'roles'   =>  $request->getPost("tipe"),
            ]);
        }
        
        if(!$result){
            session()->setFlashdata('message','Terjadi kesalahan');
        }

        return redirect()->to(base_url('home/admin'));
    }

    public function surat(): string {

    }
}
