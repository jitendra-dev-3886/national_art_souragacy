<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankEquipmentModel extends Model
{
    use HasFactory;
    protected $table = 'artbank_equipment';
    //public $timestamps = false;
    protected $primaryKey = 'id'; // Default is 'id'
    public $incrementing = true; // Ensure auto-increment is enabled

   
    protected $fillable = [ 
      'id',
      'artbank_id',
      'equipmentname',  
      'userid',
      'datetime',

  ];
}
