<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankOtherStaffModel extends Model
{
    use HasFactory;
    protected $table = 'artbank_otherstaff';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled

   
    protected $fillable = [ 
      'id',
      'artbank_id',      
      'name_otherstaff',
      'designation_otherstaff',
      'quali_otherstaff',      
      'userid',
      'datetime',

  ];
}
