<?php

namespace App\Models\clinic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Statetable extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural of the model name
    protected $table = 'state';

    // Specify the fillable attributes (optional for mass assignments)
    protected $fillable = ['state_id','state_name','state_abb']; // Add other columns as needed  
 
}