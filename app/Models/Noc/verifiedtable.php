<?php

namespace App\Models\Noc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class verifiedtable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'user_verified_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_request_id', 'password '
    ];    
    // Define the inverse relationship
    public function requestData()
    {
        return $this->belongsTo(requesttable::class, 'user_request_id', 'id');
    }
}