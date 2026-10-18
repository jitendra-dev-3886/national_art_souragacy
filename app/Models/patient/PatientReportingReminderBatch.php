<?php

namespace App\Models\patient;

use Illuminate\Database\Eloquent\Model;
use App\Models\patient\PatientReportingReminderFailedEmail;

class PatientReportingReminderBatch extends Model
{
    protected $table = 'patient_reporting_reminder_batches';
    protected $fillable = [
        'patient_reporting_reminder_id',
        'batch_no',
        'batch_size',
        'clinic_ids',
        'emails_sent',
        'emails_failed',
        'status',
        'scheduled_at',
        'started_at',
        'completed_at',
        'error_message'
    ];

    protected $casts = [
        'clinic_ids'   => 'array',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];
    public const STATUS_PENDING    = 'Pending';
    public const STATUS_PROCESSING = 'Processing';
    public const STATUS_COMPLETED  = 'Completed';
    public const STATUS_FAILED     = 'Failed';
    public const STATUS_PARTIAL = 'Partially Completed';

    public function reminder()
    {
        return $this->belongsTo(PatientReportingReminder::class);
    }
    public function failedEmails()
    {
        return $this->hasMany(
            PatientReportingReminderFailedEmail::class,
            'patient_reporting_reminder_batch_id'
        );
    }
}