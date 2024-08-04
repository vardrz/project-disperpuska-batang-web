<?php

namespace App\Models;

use CodeIgniter\Model;

class ArchivesModel extends Model
{
    protected $table      = 'archives';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['archives_number', 'institute', 'on_date', 'isi', 'status', 'keterangan', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    // public function joinPeminjaman()
    // {
    //     return $this->db->table('borrow')
    //         ->select('borrow.id as id_borrow, borrow.publics_id, borrow.archives_id, archives.*')
    //         ->join('archives', 'archives.id = borrow.archives_id')
    //         ->get()->getResultArray();
    // }
}
