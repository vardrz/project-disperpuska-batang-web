<?php

namespace App\Controllers;

use App\Models\PublicModel;

class HomeController extends BaseController
{
    protected $publicsModel;

    public function __construct() {
        $this->publicsModel = new PublicModel();
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

    }

    public function surat(): string {

    }
}
