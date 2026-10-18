<?php

namespace App\Models;

use App\Models\Noc\requesttable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantProfile extends Model
{
    use HasFactory;
    public $table = 'applicant_profiles';
    protected $fillable=[ 'noc_userid','name_applicant', 'gender','address','pincode','state','district','country', 'zipcode','nationality_type' ];

    public function requestData()
    {
        return $this->belongsTo(requesttable::class, 'noc_userid', 'id');
    }
}
