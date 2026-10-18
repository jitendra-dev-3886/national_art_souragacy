<?php

namespace App\Models\ChangeAddress;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeAddressFee extends Model
{
    use HasFactory;
    protected $table = 'change_address_fees';

    protected $fillable = [
        'clinic_type',
        'level',
        'fees_before_expiry',
        'fees_after_expiry',
        'status',
        'valid_till_date',
    ];
}
