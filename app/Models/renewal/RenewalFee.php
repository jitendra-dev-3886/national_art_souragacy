<?php

namespace App\Models\renewal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RenewalFee extends Model
{
    use HasFactory;
    protected $table = 'renewal_fees';

    protected $fillable = [
        'clinic_type',
        'level',
        'fees_before_expiry',
        'fees_after_expiry',
        'status',
        'valid_till_date',
    ];
}
