<?php

namespace App\Models;

use CodeIgniter\Model;

class BorrowModel extends Model
{
    protected $table      = 'borrow';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $allowedFields = ['publics_id', 'archives_id', 'needs', 'created_at', 'updated_at'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function relasi()
    {
        return $this->db->table('borrow')
            ->select('borrow.*, publics.name as public_name, archives.archives_number, archives.keterangan')
            ->join('publics', 'publics.id = borrow.publics_id')
            ->join('archives', 'archives.id = borrow.archives_id')
            ->where('archives.keterangan', 'Diproses')
            ->get()->getResultObject();
    }
}
