<?php

namespace App\Models\Admin;

use App\Models\Admin\RoleTable;
use App\Models\Admin\userTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userrolesaccesstable extends Model
{
    use HasFactory;

    // Specify the correct table name
    protected $table = 'user_roles_access_table';

    // Fillable fields for mass assignment
    protected $fillable = [
        'user_id', 'role_id', 'created_by', 'deactivated_by', 'is_active'
        
    ];

    // // Optional: You might want to hide sensitive fields like password in the API response
    // protected $hidden = [
    //     'password',
    // ];

    // Optional: If you want to cast the "Is_Active_and_Deactive" column to a boolean
   
    public function user()
    {
        return $this->belongsTo(userTable::class, 'user_id','userid');
    }
    public function role()
    {
        return $this->belongsTo(RoleTable::class, 'role_id','id');
    }
    public function rolesAccess()
    {
        return $this->belongsTo(approveauthoritytable::class,  'user_id','user_id');
    }
    
}