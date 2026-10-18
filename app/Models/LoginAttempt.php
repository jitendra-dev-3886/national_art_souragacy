<?php

namespace App\Models;

use App\Models\clinic\signup;
use App\Models\noc\requesttable;
use App\Models\Admin\user;
use App\Models\Admin\userTable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    use HasFactory;
    public $table = 'signup_login_attempt';
    // protected $primaryKey = 'ids';
    // public $incrementing = true;
    // public $keyType = 'int'; // or 'string'
    protected $fillable=['userid','user_type','start_time', 'end_time','session_id','ip'];

    public function clinics()
    {
        return $this->belongsTo(signup::class, 'userid', 'id');
    }
    public function nocusers()
    {
        return $this->belongsTo(requesttable::class, 'userid', 'id');
    }
    public function ssa()
    {
        return $this->belongsTo(user::class, 'userid', 'id');
    }
    public function admin()
    {
        return $this->belongsTo(userTable::class, 'userid', 'userid');
    }
    public function usertype()
    {
        return $this->belongsTo(UserType::class, 'user_type', 'id');
    }
}
