<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Model;

class ClinicNameChangeDocument extends Model
{
    protected $table = 'clinic_name_change_documents';

    protected $fillable = [
        'application_id',
        'document_type',
        'document_title',
        'file_path',
        'original_file_name',
    ];

    /**
     * Relationship: Document belongs to a Name Change Application
     */
    public function application()
    {
        return $this->belongsTo(
            ClinicNameChangeApplication::class,
            'application_id'
        );
    }
}