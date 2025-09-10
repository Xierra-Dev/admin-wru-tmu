<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\TmpPeopleModel;

class Tmppeople extends BaseController
{
    protected $tmpPeople;

    public function __construct()
    {
        $this->tmpPeople = new TmpPeopleModel();
    }

    // Fungsi hapus chip
    public function removeTmp($id = null)
    {
        if ($id === null) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'ID tidak ditemukan'
            ]);
        }

        $deleted = $this->tmpPeople->delete($id);

        if ($deleted) {
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Chip berhasil dihapus'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Chip gagal dihapus'
            ]);
        }
    }
}
