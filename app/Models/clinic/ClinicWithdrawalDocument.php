<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;

class ClinicWithdrawalDocument extends Model
{
    protected $table = 'clinic_withdrawal_documents';

    protected $fillable = [
        'withdrawal_application_id',
        'document_type',
        'file_name',
        'file_path',
        'remarks',
        'uploaded_by'
    ];

    public function application()
    {
        return $this->belongsTo(ClinicWithdrawal::class, 'withdrawal_application_id');
    }
}