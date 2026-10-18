<?php

namespace App\Models\Noc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class countrytable extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural of the model name
    protected $table = 'apps_countries';

    // Specify the fillable attributes (optional for mass assignments)
    protected $fillable = ['id','country_code','country_name'];// Add other columns as needed  
 
}
