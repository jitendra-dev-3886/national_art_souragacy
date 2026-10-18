<?php

namespace App\Models\patient;
use App\Models\Admin\userTable;

use Illuminate\Database\Eloquent\Model;

class PatientReportingReminder extends Model
{
    protected $table = 'patient_reporting_reminders';
    protected $fillable = [
        'initiated_by',
        'total_clinics',
        'batch_size',
        'total_batches',
        'status',
        'initiated_at',
        'completed_at',
        'remarks'
    ];

    protected $casts = [
        'initiated_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    public const STATUS_INITIATED = 'Initiated';
    public const STATUS_RUNNING   = 'Running';
    public const STATUS_COMPLETED = 'Completed';
    public const STATUS_FAILED    = 'Failed';

    public function batches()
    {
        return $this->hasMany(PatientReportingReminderBatch::class);
    }
    public function initiatedBy()
    {
        return $this->belongsTo(userTable::class, 'initiated_by', 'userid');
    }
}