<?php

namespace App\Models\ChangeAddress;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeAddressEquipment extends Model
{
    use HasFactory;

    protected $table = 'change_address_equipments';

    protected $fillable = [
        'application_id',
        'clinic_id',
        'equipmentname',
        'status',
        'userid',
        'clinic_type',
        'application_no',
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