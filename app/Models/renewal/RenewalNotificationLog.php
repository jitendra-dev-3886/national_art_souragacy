<?php

namespace App\Models\renewal;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewalNotificationLog extends Model
{
    use HasFactory;

    protected $table = 'renewal_notification_logs';

    protected $fillable = [
        'clinic_id',
        'clinic_type',
        'email_type',
        'expiry_date',
        'scheduled_send_date',
        'attempts',
        'status',
        'sent_at',
        'last_attempt_at',
        'error_message',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'scheduled_send_date' => 'date',
        'sent_at' => 'datetime',
        'last_attempt_at' => 'datetime',
        'attempts' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Status Constants
    |--------------------------------------------------------------------------
    */

    public const STATUS_PENDING = 'pending';
    public const STATUS_SENT = 'sent';
    public const STATUS_FAILED = 'failed';

    /*
    |--------------------------------------------------------------------------
    | Normal Reminder Types
    |--------------------------------------------------------------------------
    */

    public const EMAIL_TYPE_60_DAYS = '60_days';
    public const EMAIL_TYPE_53_DAYS = '53_days';
    public const EMAIL_TYPE_45_DAYS = '45_days';

    /*
    |--------------------------------------------------------------------------
    | Relaxation Reminder Types
    |--------------------------------------------------------------------------
    */

    public const EMAIL_TYPE_60_DAYS_RELAXATION = '60_days_relaxation';
    public const EMAIL_TYPE_53_DAYS_RELAXATION = '53_days_relaxation';
    public const EMAIL_TYPE_45_DAYS_RELAXATION = '45_days_relaxation';
}