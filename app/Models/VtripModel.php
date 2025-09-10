<?php

namespace App\Models;

use CodeIgniter\Model;

class VtripModel extends Model
{
    protected $table = 'v_trip'; // Nama tabel utama V-trip Anda
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'vehicle_id',
        'people_id',
        'destination_id',
        'leave_date',
        'return_date',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    /**
     * Mengambil semua data V-trip dengan detail kendaraan, personil, dan destinasi.
     * Hasilnya dikelompokkan berdasarkan kendaraan.
     *
     * @return array
     */
    public function getAllVTripWithDetails()
    {
        // Melakukan join dari tabel v_trip ke tabel vehicle, people, dan destination
        $query = $this->select('v_trip.*, vehicle.vehicle_name, people.name as people_name, destination.destination_name')
                      ->join('vehicle', 'vehicle.id = v_trip.vehicle_id', 'left')
                      ->join('people', 'people.id = v_trip.people_id', 'left')
                      ->join('destination', 'destination.id = v_trip.destination_id', 'left')
                      ->where('v_trip.deleted_at', null)
                      ->where('vehicle.deleted_at', null)
                      ->where('people.deleted_at', null)
                      ->where('destination.deleted_at', null)
                      ->orderBy('vehicle.vehicle_name', 'ASC')
                      ->findAll();

        $groupedData = [];

        foreach ($query as $row) {
            $vehicleName = $row['vehicle_name'];

            // Jika kendaraan belum ada di array pengelompokan, inisialisasi
            if (!isset($groupedData[$vehicleName])) {
                $groupedData[$vehicleName] = [
                    'vehicle' => $vehicleName,
                    'schedules' => 0,
                    'schedule_list' => []
                ];
            }

            // Tambahkan jadwal ke dalam daftar
            $groupedData[$vehicleName]['schedule_list'][] = [
                'id' => $row['id'],
                'personel' => $row['people_name'],
                'destination' => $row['destination_name'],
                'from_date' => $row['leave_date'],
                'until_date' => $row['return_date'],
            ];

            // Tambahkan hitungan jadwal
            $groupedData[$vehicleName]['schedules']++;
        }

        // Mengembalikan data sebagai array berindeks numerik untuk iterasi di tampilan
        return array_values($groupedData);
    }

    /**
     * Mengambil data V-trip berdasarkan ID dengan detail lengkap.
     *
     * @param int $id ID V-trip
     * @return object|null
     */
    public function getVTripById($id)
    {
        return $this->select('v_trip.*, vehicle.vehicle_name as vehicle, people.name as personel, destination.destination_name as destination')
            ->join('vehicle', 'vehicle.id = v_trip.vehicle_id', 'left')
            ->join('people', 'people.id = v_trip.people_id', 'left')
            ->join('destination', 'destination.id = v_trip.destination_id', 'left')
            ->where('v_trip.id', $id)
            ->where('v_trip.deleted_at', null)
            ->where('vehicle.deleted_at', null)
            ->where('people.deleted_at', null)
            ->where('destination.deleted_at', null)
            ->first();
    }
}
