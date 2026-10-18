<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtClinicDirectorModel extends Model
{
    use HasFactory;
    protected $table = 'artclinic_director';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled

   // Use a specific database connection
   //protected $connection = 'mysql2';


    protected $fillable = [ 
      'id',
      'artclinic_id',
      'name_director',
      'quali_director',
      'reg_director',
      'userid',
      'datetime',

  ];
}
