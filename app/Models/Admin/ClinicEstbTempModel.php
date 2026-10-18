<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


// Create by Wasim Gour
class ClinicEstbTempModel extends Model
{
    use HasFactory;
    protected $table = 'temp_table_for_date_establishment';
    protected $primaryKey = 'id'; 
    public $incrementing = true; 
    public $timestamps = false;

  
    protected $fillable = [
        'id',
        'clinic_id',
        'date_of_establishment',
        'new_date_of_establishment',
        'userid'
    ];

    public function clinic()
    {
        return $this->belongsTo(\App\Models\clinic\ClinicRegistrationModel::class, 'clinic_id', 'clinic_id');
    }
   
}
