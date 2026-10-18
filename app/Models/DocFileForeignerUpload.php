<?php

namespace App\Models;

use App\Models\Noc\docmastertable;
use App\Models\Noc\Nocforeigner;
use App\Models\Noc\requesttable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DocFileForeignerUpload extends Model 
{
    use HasFactory;

    public $table = 'doc_file_uploads_foreigner';
    protected $fillable = [
        'noc_user_id',
        'app_id',
        'doc_id',
        'doc_type',
        'upload_desc',
        'doc_upload_ref',
        'noc_query_id',
        'admin_id',
        'doc_master_id_ref',
        'query_raised_id',
    ];
    
    public function docFile_Uploads()
    {
        return $this->hasMany(docmastertable::class);
    }
    public function Nocforeigner()
    {
        return $this->belongsTo(Nocforeigner::class, 'app_id', 'id');
    }
    public function userRequest()
    {
        return $this->belongsTo(requesttable::class, 'noc_user_id', 'id');
    }
}

