<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkFlowTable extends Model
{
    use HasFactory;

    protected $table = 'work_flow_table';
    protected $fillable = [
        'application_id',
        'service_id',
        'level_id',
        'user_id',
        'remarks',
        'notesheet',
        'medical_report',
        'is_active',
        'action_taken_by',
        'noc_user',
        'query_raised_by'
    ];
    public $timestamps = false; 
}
