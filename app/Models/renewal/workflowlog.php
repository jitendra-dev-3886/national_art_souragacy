<?php

namespace App\Models\Renewal;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class workflowlog extends Model
{
    use HasFactory;

    protected $table = 'workflow_logs';

    protected $fillable = [
        'renewal_application_id',
        'clinic_id',
        'workflow_status',
        'from_status',
        'to_status',
        'last_changed_by',
        'last_changed_ip',
        'remarks',
        'created_at',
        'updated_at',
       
    ];
}