<?php

namespace App\Models;

use CodeIgniter\Model;

class PersonilModel extends Model
{
    protected $table = 'personil';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name','position','contact'];
    protected $returnType = 'array';
}