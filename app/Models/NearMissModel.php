<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearMissModel extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $table = 'near_miss_accident_report';
}
