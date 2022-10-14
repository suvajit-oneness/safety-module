<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class managementofchange extends Model
{
    use HasFactory;
    protected $table = 'change_checklist';
    public function children()
     {
         return $this->hasMany(managementofchange::class, 'parent_id')->with('children');
     }
}
