<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userTable extends Model
{
    use HasFactory;

    // Specify the correct table name
    //protected $connection = 'artregistry_latest';
    protected $table = 'user_table';
    protected $primaryKey = 'userid';

    public $incrementing = true; // if it auto increments

    protected $keyType = 'int'; // or 'string' if it's varchar

    // Fillable fields for mass assignment
    protected $fillable = [
        'username', 'First_name', 'Last_name', 'Post', 'designation', 
        'mobile_no', 'phone', 'email', 'password', 'stateid', 'address', 'Is_Active_and_Deactive'
    ];

    // Optional: You might want to hide sensitive fields like password in the API response
    protected $hidden = [
        'password',
    ]; 

    public function roleData()
    {
        return $this->belongsTo(userrolesaccesstable::class, 'user_id', 'userid');
    }
   
}
