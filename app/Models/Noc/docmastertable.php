<?php

namespace App\Models\Noc;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class docmastertable extends Model
{
    use HasFactory;

    // Define the table name if it's different from the plural of the model name
   //  protected $connection = 'artdumydata';
     protected $table = 'doc_masters';
     protected $fillable = [
        'doc_type', 'status','doc_desc', 'id', 'doc_master_id'     
    ];
}