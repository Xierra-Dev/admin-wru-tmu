<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLetterColumnToMloc extends Migration
{
    public function up()
    {
        // Add letter column to m_loc table if it doesn't exist
        if (!$this->db->fieldExists('letter', 'm_loc')) {
            $this->forge->addColumn('m_loc', [
                'letter' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => false,
                    'comment' => 'Letter flag: 0 = No, 1 = Yes'
                ]
            ]);
        }
    }

    public function down()
    {
        $this->forge->dropColumn('m_loc', 'letter');
    }
}