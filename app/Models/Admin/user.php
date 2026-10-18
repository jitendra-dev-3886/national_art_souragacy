<?php

namespace App\Models\Admin;

use App\Models\ApplicantProfile;
use App\Models\clinic\Statetable;
use Illuminate\Database\Eloquent\Model;
use App\Models\clinic\SurrogacyClinicModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class user extends Model
{
    use HasFactory;

    // Specify the correct table name   
    protected $table = 'user';

    // Fillable fields for mass assignment
    protected $fillable = [
       'id', 'name', 'designation', 'email', 'mobileno','password','stateid','isAdmin','ministry_approved','isresetrequest','ministry_role',
    ];
    public function state()
    {
        //return $this->belongsTo(ArtClinicModel::class,'userid', 'id');
        return $this->belongsTo(Statetable::class,'stateid', 'state_id');
    }
    // public function surrogacyclinics()
    // {

    //     return $this->belongsTo(SurrogacyClinicModel::class,'id', 'userid');
    // }
    // public function artClinic()
    // {

    //     return $this->belongsTo(Ar::class,'id', 'userid');
    // }   
}