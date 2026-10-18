<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Admin\servicesTable;

class approveauthoritytable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'approve_authority_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id', 'service_id ', 'is_active'
    ];

    // Optional: You might want to hide sensitive fields like password in the API response
    // protected $hidden = [
    //     'password',
    // ];

    // Optional: If you want to cast the "Is_Active_and_Deactive" column to a boolean
    // protected $casts = [
    //     'is_active' => 'boolean',
    // ];
    public function service()
    {
        return $this->belongsTo(servicesTable::class, 'service_id','id');
    }
    public function userAccess()
    {
        return $this->belongsTo(userrolesaccesstable::class,  'user_id','id');
    }
}