<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class moc_review extends Model
{
    use HasFactory;
    protected $table = 'moc_review';
    // public function children()
    //  {
    //      return $this->hasMany(managementofchange::class, 'parent_id')->with('children');
    //  }
}