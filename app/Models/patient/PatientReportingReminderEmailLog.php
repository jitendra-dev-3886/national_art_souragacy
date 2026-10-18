<?php

namespace App\Models\patient;

use Illuminate\Database\Eloquent\Model;

class PatientReportingReminderFailedEmail extends Model
{
    protected $table = 'patient_reporting_reminder_failed_emails';

    public const MAX_RETRY_ATTEMPTS = 3;

    protected $fillable = [
        'patient_reporting_reminder_batch_id',
        'clinic_id',
        'clinic_type',
        'clinic_name',
        'email',
        'error_message',
        'attempt_count',
        'status',
        'failed_at',
        'last_retry_at',
    ];
    protected $casts = [
        'failed_at' => 'datetime',
        'last_retry_at' => 'datetime',
    ];

    public function batch()
    {
        return $this->belongsTo(
            PatientReportingReminderBatch::class,
            'patient_reporting_reminder_batch_id'
        );
    }
}