<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Artclinic extends Model
{
    // Specify the exact table name if it's not the plural form
    protected $table = 'artclinic';

    // Allow mass assignment on these columns
    protected $fillable = ['app_date_recieve', 
                            'app_date_payment', 
                            'transaction_id',
                            'fee_amount'
                        ];
}
