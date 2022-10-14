<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class auditmodel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'inspection_and_audit_master';
}
