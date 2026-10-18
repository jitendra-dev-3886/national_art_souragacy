<?php

namespace App\Models\ChangeAddress;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeAddressDirector extends Model
{
    use HasFactory;

    protected $table = 'change_address_directors';

    protected $fillable = [
        'application_id',
        'clinic_id',
        'name_director',
        'quali_director',
        'reg_director',
        'userid',
        'status',
        'clinic_type',
        'application_no',
        'validitydate',
    ];

    public $timestamps = true;

    /*
    |--------------------------------------------------------------------------
    | Casts (Replace deprecated $dates)
    |--------------------------------------------------------------------------
    */
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