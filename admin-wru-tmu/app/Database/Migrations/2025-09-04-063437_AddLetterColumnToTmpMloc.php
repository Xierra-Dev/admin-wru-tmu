<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddLetterColumnToTmpMloc extends Migration
{
    public function up()
    {
        // Check if tmp_mloc table exists, if not create it
        if (!$this->db->tableExists('tmp_mloc')) {
            $this->forge->addField([
                'id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                    'auto_increment' => true,
                ],
                'people_id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                ],
                'destination_id' => [
                    'type' => 'INT',
                    'constraint' => 5,
                    'unsigned' => true,
                ],
                'requestBy' => [
                    'type' => 'VARCHAR',
                    'constraint' => 255,
                    'null' => true,
                ],
                'leaveDate' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
                'returnDate' => [
                    'type' => 'DATETIME',
                    'null' => false,
                ],
                'letter' => [
                    'type' => 'TINYINT',
                    'constraint' => 1,
                    'default' => 0,
                    'null' => false,
                ],
                'created_at' => [
                    'type' => 'DATETIME',
                    'null' => true,
                ],
            ]);
            $this->forge->addKey('id', true);
            $this->forge->addForeignKey('people_id', 'people', 'id', 'CASCADE', 'CASCADE');
            $this->forge->addForeignKey('destination_id', 'destination', 'id', 'CASCADE', 'CASCADE');
            $this->forge->createTable('tmp_mloc');
        } else {
            // If table exists, check if letter column exists and add it if not
            if (!$this->db->fieldExists('letter', 'tmp_mloc')) {
                $this->forge->addColumn('tmp_mloc', [
                    'letter' => [
                        'type' => 'TINYINT',
                        'constraint' => 1,
                        'default' => 0,
                        'null' => false,
                        'after' => 'returnDate'
                    ]
                ]);
            }
        }
    }

    public function down()
    {
        // Drop the letter column if it exists
        if ($this->db->fieldExists('letter', 'tmp_mloc')) {
            $this->forge->dropColumn('tmp_mloc', 'letter');
        }
        
        // Optionally drop the entire table if it was created by this migration
        // Uncomment the line below if you want to drop the entire table on rollback
        // $this->forge->dropTable('tmp_mloc');
    }
}
