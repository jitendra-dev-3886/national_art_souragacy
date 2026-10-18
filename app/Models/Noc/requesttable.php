<?php

namespace App\Models\Noc;

use App\Models\ApplicantProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class requesttable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'user_request_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_name', 'email', 'countryCode', 'mobileno', 'token'
    ];
  
     // Define the relationship
     public function verifiedData()
     {
         return $this->hasOne(verifiedtable::class, 'user_request_id', 'id');
     }
     public function applicantProfile()
    {
        return $this->belongsTo(ApplicantProfile::class, 'id', 'noc_userid');
    }
}