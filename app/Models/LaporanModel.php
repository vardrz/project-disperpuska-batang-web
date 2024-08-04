<?php

namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table      = 'laporan';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['borrow_id', 'staffs_id', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function putAllData()
    {
        return $this->db->table('pengembalian')
            ->select('pengembalian.id as id_pengembalian, archives.archives_number, publics.name as public_name, pengembalian.update_at as tgl_kembali, pengembalian.created_at as tgl_pinjam, staffs.name as staff_name')
            ->join('archives', 'archives.id = pengembalian.id_archives')
            ->join('publics', 'publics.id = pengembalian.id_publics')
            ->join('staffs', 'staffs.id = pengembalian.staffs_id')
            ->get()->getResultObject();
    }

    public function putAllBorrow()
    {
        return $this->db->table('borrow')
            ->select('borrow.id as id_peminjaman, archives.archives_number, publics.name as public_name, borrow.created_at as tgl_pinjam')
            ->join('archives', 'archives.id = borrow.archives_id')
            ->join('publics', 'publics.id = borrow.publics_id')
            ->get()->getResultObject();
    }

    public function putAllArsip()
    {
        return $this->db->table('archives')
            ->select('*')
            ->where('keterangan', 'Dipinjam')
            ->get()->getResultObject();
    }

    public function getFilterData($date)
    {
        return $this->db->table('pengembalian')
            ->select('pengembalian.id as id_pengembalian, archives.archives_number, publics.name as public_name, pengembalian.update_at as tgl_kembali, pengembalian.created_at as tgl_pinjam, staffs.name as staff_name')
            ->join('archives', 'archives.id = pengembalian.id_archives')
            ->join('publics', 'publics.id = pengembalian.id_publics')
            ->join('staffs', 'staffs.id = pengembalian.staffs_id')
            ->where('pengembalian.created_at >=', $date[0])
            ->where('pengembalian.created_at <=', $date[1])
            ->get()->getResultObject();
    }

    public function getFilterBorrow($date)
    {
        return $this->db->table('borrow')
            ->select('borrow.id as id_peminjaman, archives.archives_number, publics.name as public_name, borrow.created_at as tgl_pinjam')
            ->join('archives', 'archives.id = borrow.archives_id')
            ->join('publics', 'publics.id = borrow.publics_id')
            ->where('borrow.created_at >=', $date[0])
            ->where('borrow.created_at <=', $date[1])
            ->get()->getResultObject();
    }

    public function getFilterArsip($date)
    {
        return $this->db->table('archives')
            ->select('*')
            ->where('keterangan', 'Dipinjam')
            ->where('archives.created_at >=', $date[0])
            ->where('archives.created_at <=', $date[1])
            ->get()->getResultObject();
    }
}
