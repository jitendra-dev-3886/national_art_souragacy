<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurrogacyClinicDirectorModel extends Model
{
    use HasFactory;
    protected $table = 'surrogacyclinic_director';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled

   
    protected $fillable = [ 
      'id',
      'surrogacyclinic_id',
      'name_director',
      'quali_director',
      'reg_director',
      'userid',
      'datetime',

  ];
}
