<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class Archive extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'surrogacyarchive';

    // Fillable fields for mass assignment
    protected $fillable = [
        'application_no',
        'registraion_no',
        'userid',
        'clinicname',
        'address',
        'pincode',
        'state',
        'district',
        'email',
        'contactno',
        'mobile',
        'website',
        'other_procedure',
        'other_details',
        'name_director',
        'status'
    ];
}