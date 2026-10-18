<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArtClinicOtherStaffModel extends Model
{
    use HasFactory;
    protected $table = 'artclinic_otherstaff';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled

   
    protected $fillable = [ 
      'id',
      'artclinic_id',
      'post_otherstaff',
      'name_otherstaff',
      'quali_otherstaff',
      'regno',
      'userid',
      'datetime',
  ];
}
