<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class incident_report extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'incident_report';
}
