<?php

namespace App\Models\patient;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientReportingReminderLog extends Model
{
    use HasFactory;

    protected $table = 'patient_reporting_reminder_log';

    protected $fillable = [
        'clinic_id',
        'clinic_type',
        'email',
        'reminder_month',
        'sent_at',
        'status',
        'remarks',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}