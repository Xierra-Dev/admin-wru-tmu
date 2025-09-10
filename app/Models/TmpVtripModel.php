<?php

namespace App\Models;

use CodeIgniter\Model;

class TmpVtripModel extends Model
{
    protected $table = 'tmp_vtrip'; // Nama tabel sementara V-trip Anda
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'vehicle_id',
        'people_id',
        'destination_id',
        'leave_date',
        'return_date',
        'admin_id',
        'created_at'
    ];
    protected $useTimestamps = false; // Dikelola secara manual untuk created_at di controller/moveToMainTable

    /**
     * Mengambil semua data V-trip sementara dengan detail kendaraan, personil, dan destinasi berdasarkan admin.
     *
     * @return array
     */
    public function getAllTmpVTripWithDetails()
    {
        $adminId = session()->get('admin_id');
        return $this->select('tmp_vtrip.*, vehicle.number_plate, vehicle.vehicle_name, people.name as people_name, destination.destination_name')
                    ->join('vehicle', 'vehicle.id = tmp_vtrip.vehicle_id')
                    ->join('people', 'people.id = tmp_vtrip.people_id')
                    ->join('destination', 'destination.id = tmp_vtrip.destination_id')
                    ->where('tmp_vtrip.admin_id', $adminId)
                    ->findAll();
    }

    /**
     * Memindahkan semua data dari tabel temporer ke tabel utama V-trip berdasarkan session.
     * Menggunakan transaksi untuk memastikan operasi atomik.
     *
     * @return bool True jika berhasil, False jika gagal.
     */
    public function moveToMainTable()
    {
        $adminId = session()->get('admin_id');
        $vtripModel = new VtripModel();
        
        try {
            $db = \Config\Database::connect();
            $db->transStart();

            // Get temporary data for current admin
            $tmpData = $this->where('admin_id', $adminId)->findAll();

            if (empty($tmpData)) {
                return false;
            }

            // Insert each record to main table
            foreach ($tmpData as $data) {
                $insertData = [
                    'vehicle_id' => $data['vehicle_id'],
                    'people_id' => $data['people_id'],
                    'destination_id' => $data['destination_id'],
                    'leave_date' => $data['leave_date'],
                    'return_date' => $data['return_date'],
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                
                if (!$vtripModel->insert($insertData)) {
                    throw new \Exception('Failed to insert data to v_trip table');
                }
            }

            // Clear tmp table after successful move (only for current admin)
            $this->where('admin_id', $adminId)->delete();

            $db->transComplete();
            return $db->transStatus();

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'TmpVtripModel moveToMainTable error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Menghapus semua data dari tabel sementara berdasarkan admin.
     *
     * @return bool True jika berhasil, False jika gagal.
     */
    public function clearAll()
    {
        $adminId = session()->get('admin_id');
        return $this->where('admin_id', $adminId)->delete();
    }

    /**
     * Clean up old temporary data (older than 24 hours)
     */
    public function cleanupOldData()
    {
        $cutoffTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
        return $this->where('created_at <', $cutoffTime)->delete();
    }
}
