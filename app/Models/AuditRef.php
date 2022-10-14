<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditRef extends Model
{
    use HasFactory;
    protected $table = 'ref_table';
}
