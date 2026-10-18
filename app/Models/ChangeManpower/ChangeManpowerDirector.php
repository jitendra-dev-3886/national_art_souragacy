<?php

namespace App\Models\ChangeManpower;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeManpowerDirector extends Model
{
    use HasFactory;

    protected $table = 'ch_manpaower_director';
    protected $primaryKey = 'id';

    protected $fillable = [
        'clinic_id',
        'cm_id',
        'application_no',
        'name_director',
        'quali_director',
        'reg_director',
        'expiry_date',
        'status',
        'clinic_type',
        'type',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
