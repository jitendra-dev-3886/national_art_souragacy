<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class clinicDirectorModel extends Model
{
    use HasFactory;

    protected $table = 'tbl_director_staff';
    protected $primaryKey = 'id';
    public $timestamps = true; // set false if no created_at/updated_at columns

    protected $fillable = [
        'clinic_id',
        'name_director',
        'quali_director',
        'reg_director',
        'status',
        'clinic_type',
        'application_no',
        'validitydate',
        'relieving_date',
    ];
}
