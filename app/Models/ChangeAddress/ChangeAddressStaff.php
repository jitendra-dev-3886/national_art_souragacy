<?php

namespace App\Models\ChangeAddress;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeAddressStaff extends Model
{
    use HasFactory;

    protected $table = 'change_address_staffs';

    protected $fillable = [
        'clinic_id',
        'application_id',
        'name',
        'post',
        'qualification',
        'application_no',
        'regno',
        'status',
        'userid',
        'clinic_type',
        'type_emp',
        'validitydate',
    ];

    public $timestamps = true;

    protected $casts = [
        'validitydate' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function changeAddressApplication()
    {
        return $this->belongsTo(ChangeAddressApplication::class, 'application_id');
    }
}