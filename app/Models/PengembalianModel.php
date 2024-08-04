<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table      = 'pengembalian';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['id_publics', 'id_archives', 'staffs_id', 'created_at', 'update_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'update_at';

    public function putBorrow()
    {
        return $this->db->table('borrow')
            ->select('archives.id as id_archives, borrow.id as id_borrow, publics.id as id_publics, publics.name as public_name, archives.archives_number, borrow.created_at as tgl_pinjam')
            ->join('publics', 'publics.id = borrow.publics_id')
            ->join('archives', 'archives.id = borrow.archives_id')
            ->get()->getResultObject();
    }

    public function putAllData()
    {
        return $this->db->table('pengembalian')
            ->select('pengembalian.id as id_pengembalian, pengembalian.id_publics, archives.archives_number, publics.name as public_name, staffs.name as staff_name, pengembalian.update_at as tgl_kembali')
            ->join('archives', 'archives.id = pengembalian.id_archives')
            ->join('publics', 'publics.id = pengembalian.id_publics')
            ->join('staffs', 'staffs.id = pengembalian.staffs_id')
            ->get()->getResultObject();
    }

    public function putData($id)
    {
        return $this->db->table('pengembalian')
            ->select('pengembalian.id as id_pengembalian, pengembalian.id_archives, pengembalian.id_publics, publics.name as public_name, staffs.id as staff_id, staffs.name as staff_name, pengembalian.created_at as tgl_pinjam, pengembalian.update_at as tgl_kembali, archives.archives_number, archives.institute')
            ->join('publics', 'publics.id = pengembalian.id_publics')
            ->join('staffs', 'staffs.id = pengembalian.staffs_id')
            ->join('archives', 'archives.id = pengembalian.id_archives')
            ->where('pengembalian.id', $id)
            ->get()->getRowObject();
    }

    public function InsertData($data)
    {
        return $this->db->table('pengembalian')->insert($data);
    }
}
