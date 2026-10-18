<?php

namespace App\Models\ChangeManpower;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChangeManpowerDocument extends Model
{
    use HasFactory;

    protected $table = 'change_manpower_document';
    protected $primaryKey = 'id';

    protected $fillable = [
        'clinic_id',
        'cm_id',
        'doc_name',
        'doc_type',
        'file_path',
        'original_name',
        'clinic_type',
        'status',
    ];
}
